<?php

namespace App\Console\Commands;

use App\User;
use App\Book;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ImportData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:data
                            {path : The path to dataset}
                            {book : The book ID to content add to}
                            {parent? : The parent of the content}
                            {--T|title= : The title of the content}
                            {--R|refresh : Refresh book\'s content before import}
                            {--C|count : Count title on indexing}
                            {--P|persian : Persian numbers}
                            {--H|header=* : Subheader titles}
                            {--A|append : Append m1 to titles}
                            {--D|delimiter= : Delimiter for append and title, default is ": "}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'import author and books';

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
    public function image($path, $width = 32, $height = 32)
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
        $gravity = 'no';
        $enlarge = 1;
        $extension = 'jpg';
        $filename = uniqid('', true);

        $url = 's3://' . $path;
        $encodedUrl = rtrim(strtr(base64_encode($url), '+/', '-_'), '=');

        $path = "/filename:{$filename}/resize:{$resize}/width:{$width}/height:{$height}/gravity:{$gravity}/enlarge:{$enlarge}/{$encodedUrl}.{$extension}";

        $signature = rtrim(strtr(base64_encode(hash_hmac('sha256', $saltBin . $path, $keyBin, true)), '+/', '-_'), '=');

        return 'https://image.coleus.test' . sprintf("/%s%s", $signature, $path);
    }

    public function insertUser($user)
    {
        $uniqid = uniqid('', true);
        $original = '';
        if (Storage::disk('dataset')->exists('ganjoor/users/assets/images/' . $user->username . '.jpg')) {
            Storage::put('profile_picture/' . $uniqid . '.jpg', Storage::disk('dataset')->get('ganjoor/users/assets/images/' . $user->username . '.jpg'));
        } else {
            if (Storage::missing('profile_picture/default.jpg')) {
                Storage::put('profile_picture/default.jpg', Storage::disk('dataset')->get('ganjoor/users/assets/images/default.jpg'));
            }
            $uniqid = 'default';
        }

        $original = Storage::url('public/profile_picture/' . $uniqid . '.jpg');
        $medium = $this->image('public/profile_picture/' . $uniqid . '.jpg', 512, 512);
        $placeholder = $this->image('public/profile_picture/' . $uniqid . '.jpg', 4, 4);
        $small = $this->image('public/profile_picture/' . $uniqid . '.jpg', 256, 256);
        $thumbnail = $this->image('public/profile_picture/' . $uniqid . '.jpg', 32, 32);
        $xsmall = $this->image('public/profile_picture/' . $uniqid . '.jpg', 64, 64);

        return User::create([
            'name' => $user->name,
            'username' => $user->username,
            'email' => $user->email,
            'password' => Hash::make('123456'), // @todo
            'original' => $original,
            'medium' => $medium,
            'placeholder' => $placeholder,
            'small' => $small,
            'thumbnail' => $thumbnail,
            'xsmall' => $xsmall,
        ]);
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        ini_set('memory_limit', '-1');

        // Reset
        User::truncate();
        Storage::deleteDirectory('profile_picture');

        $users = json_decode(Storage::disk('dataset')->get('ganjoor/users/all.json'));
        foreach ($users as $user) {
            if (! in_array($user->username, ['molana', 'hafez', 'iqbal', 'sadi', 'roodaki', 'ferdosi', 'nezami', 'babataher', 'naserkhosro'])) {
                continue;
            }
            $user = $this->insertUser($user);

            $books = Storage::disk('dataset')->directories('ganjoor/books/' . $user->username);
            foreach ($books as $book) {
                $info = json_decode(Storage::disk('dataset')->get($book . '/info.json'));
                $uniqid = uniqid('', true);
                $original = '';
                if (Storage::disk('dataset')->exists($book . '/cover.jpg')) {
                    Storage::put('book_cover/' . $uniqid . '.jpg', Storage::disk('dataset')->get($book . '/cover.jpg'));
                } else {
                    if (Storage::missing('book_cover/default.jpg')) {
                        Storage::put('book_cover/default.jpg', Storage::disk('dataset')->get('ganjoor/books/default.jpg'));
                    }
                    $uniqid = 'default';
                }

                // 2560x1600
                $original = Storage::url('public/profile_picture/' . $uniqid . '.jpg');

                // 1280x800
                $medium = $this->image('public/profile_picture/' . $uniqid . '.jpg', 1280, 800);

                // 640x400
                $small = $this->image('public/profile_picture/' . $uniqid . '.jpg', 640, 400);

                // 160x100
                $xsmall = $this->image('public/profile_picture/' . $uniqid . '.jpg', 160, 100);

                // 40x25
                $thumbnail = $this->image('public/profile_picture/' . $uniqid . '.jpg', 40, 25);

                // 8*5
                $placeholder = $this->image('public/profile_picture/' . $uniqid . '.jpg', 8, 5);

                $book = $user->books()->create([
                    'title' => $info->title,
                    'slug' => $info->slug,
                    'description' => $info->description,
                    'original' => $original,
                    'medium' => $medium,
                    'placeholder' => $placeholder,
                    'small' => $small,
                    'thumbnail' => $thumbnail,
                    'xsmall' => $xsmall,
                ]);
            }
        }
    }
}
