<?php

namespace App\Console\Commands;

use App\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AddUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'add:user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @todo extract to package
     *
     * @return void
     */
    public function image($path)
    {
        $key = 'f4740b81b9581903dff7cad6b95d4ce87538296893fff3766d3680e111b3bec0c8ec6cbd51496cb393cc9f7af95d90276b9a7803ddf5d0833060070394294d44';
        $salt = '3d2088cbd7254ab2ae4488db2d51bb3bd55feda242773c318a0c6117f7c2f91a4cf9802f8ff27f9bac0acf79f14c4bd6e58d9c88cf9fc9f9e4bc61bb247bfd66';

        $keyBin = pack("H*", $key);
        if (empty($keyBin)) {
            die('Key expected to be hex-encoded string');
        }

        $saltBin = pack("H*", $salt);
        if (empty($saltBin)) {
            die('Salt expected to be hex-encoded string');
        }

        $resize = 'fill';
        $width = 32;
        $height = 32;
        $gravity = 'no';
        $enlarge = 1;
        $extension = 'jpg';
        $filename = uniqid('', true);

        $url = 's3://' . $path;
        $encodedUrl = rtrim(strtr(base64_encode($url), '+/', '-_'), '=');

        $path = "/filename:{$filename}/resize:{$resize}/width:{$width}/height:{$height}/gravity:{$gravity}/enlarge:{$enlarge}/{$encodedUrl}.{$extension}";

        $signature = rtrim(strtr(base64_encode(hash_hmac('sha256', $saltBin . $path, $keyBin, true)), '+/', '-_'), '=');

        return sprintf("/%s%s", $signature, $path);
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        User::truncate();
        Storage::deleteDirectory('profile_images');
        $users = json_decode(Storage::disk('dataset')->get('ganjoor/users/all.json'));
        foreach ($users as $user) {
            User::create([
                'name' => $user->name,
                'username' => $user->username,
                'email' => $user->email,
                'password' => Hash::make('123456'), // @todo
            ]);
            if (Storage::disk('dataset')->exists('ganjoor/users/assets/images/' . $user->username . '.jpg')) {
                Storage::put('profile_images/' . uniqid('', true) . '.jpg', Storage::disk('dataset')->get('ganjoor/users/assets/images/' . $user->username . '.jpg'));
            } else {
                if (Storage::missing('profile_images/default.jpg')) {
                    dd($this->image('public/profile_images/default.jpg'));
                    Storage::put('profile_images/default.jpg', Storage::disk('dataset')->get('ganjoor/users/assets/images/default.jpg'));
                }
            }
        }
    }
}
