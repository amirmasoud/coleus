<?php

namespace App\Console\Commands;

use App\User;
use App\Book;
use App\Section;
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
                            {path? : The path to dataset}
                            {book? : The book ID to content add to}
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
        Book::truncate();
        Storage::deleteDirectory('book_cover');
        Section::truncate();

        $users = json_decode(Storage::disk('dataset')->get('ganjoor/users/all.json'));
        foreach ($users as $user) {
            $user = $this->insertUser($user);

            $books = json_decode(Storage::disk('dataset')->get('ganjoor/books/' . $user->username . '/books.json'));

            foreach ($books as $book) {
                $uniqid = uniqid('', true);
                $cover = 'ganjoor/books/' . $user->username . '/' . $book->slug . '/' . $book->slug . '.jpg';
                if (Storage::disk('dataset')->exists($cover)) {
                    Storage::put('book_cover/' . $uniqid . '.jpg', Storage::disk('dataset')->get($cover));
                } else {
                    if (Storage::missing('book_cover/default.jpg')) {
                        Storage::put('book_cover/default.jpg', Storage::disk('dataset')->get('ganjoor/books/default.jpg'));
                    }
                    $uniqid = 'default';
                }

                // 2560x1600
                $original = Storage::url('public/book_cover/' . $uniqid . '.jpg');

                // 1280x800
                $medium = $this->image('public/book_cover/' . $uniqid . '.jpg', 800, 1200);

                // 640x400
                $small = $this->image('public/book_cover/' . $uniqid . '.jpg', 400, 640);

                // 160x100
                $xsmall = $this->image('public/book_cover/' . $uniqid . '.jpg', 100, 160);

                // 40x25
                $thumbnail = $this->image('public/book_cover/' . $uniqid . '.jpg', 25, 40);

                // 8*5
                $placeholder = $this->image('public/book_cover/' . $uniqid . '.jpg', 5, 8);

                $book = $user->books()->create([
                    'title' => $book->title,
                    'slug' => $book->slug,
                    'description' => $book->description ?? '',
                    'original' => $original,
                    'medium' => $medium,
                    'placeholder' => $placeholder,
                    'small' => $small,
                    'thumbnail' => $thumbnail,
                    'xsmall' => $xsmall,
                ]);

                $sections = json_decode(Storage::disk('dataset')->get('ganjoor/books/' . $user->username . '/' . $book->slug . '/sections.json'));
                usort($sections, function ($a, $b) {
                    return $a->order > $b->order;
                });
                foreach ($sections as $section) {
                    $sectionModel = $book->sections()->create([
                        'title' => $section->title,
                        'order' => $section->order,
                        'status' => 'published'
                    ]);

                    $pages = (Storage::disk('dataset')->directories('ganjoor/books/' . $user->username . '/' . $book->slug . '/' . $section->path));
                    sort($pages, SORT_NATURAL);
                    $pageOrder = 0;
                    foreach ($pages as $page) {

                        $file = json_decode(Storage::disk('dataset')->get($page . '/output.json'));
                        $title = '';
                        $content = '';
                        $customCount = 1;
                        foreach ($file->text as $key => $part) {
                            if (!$key) { // First item
                                if (!property_exists($section, 'page_title') && property_exists($part, 'm1') && !property_exists($section, 'page_header')) { // First m2
                                    $title = $part->m1;
                                } else { // Custom title
                                    if (property_exists($section, 'page_header') && @isset(property_exists($section, 'page_header')[$pageOrder])) {
                                        $title = property_exists($section, 'page_header')[$pageOrder];
                                    } else {
                                        if (property_exists($section, 'page_count_lang') && $section->page_count_lang == 'fa') {
                                            $str = $customCount;
                                            $western_persian = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9');
                                            $eastern_persian = array('٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩');

                                            $str = str_replace($western_persian, $eastern_persian, $str);
                                            $customCount++;
                                        }
                                        $title = property_exists($section, 'page_count')
                                            ? $section->page_title . ' ' . (property_exists($section, 'page_count_lang') ? $str : $customCount++)
                                            : $section->page_title;
                                        dd($customCount);
                                    }

                                    if (property_exists($section, 'page_append') && property_exists($part, 'm1')) {
                                        $title .= ': ' . $part->m1;
                                    }
                                }
                            }

                            if (property_exists($part, 'm1') && property_exists($part, 'm2')) {
                                $content .= '<p "coleus-m-1/2">' . $part->m1 . '</p>';
                                $content .= '<p "coleus-m-1/2">' . $part->m2 . '</p>';
                            }

                            if (property_exists($part, 't1') && property_exists($part, 't2')) {
                                $content .= '<p "coleus-t-1/2">' . $part->t1 . '</p>';
                                $content .= '<p "coleus-t-1/2">' . $part->t2 . '</p>';
                            }

                            if (property_exists($part, 'p')) {
                                $content .= '<p "coleus-t-full">' . $part->p . '</p>';
                            }
                        }

                        $pageModel = $sectionModel->pages()->create([
                            'title' => $title,
                            'order' => $pageOrder,
                            'status' => 'published'
                        ]);
                        $pageOrder++;

                        $pageModel->blocks()->create([
                            'order' => 0,
                            'content' => $content,
                            'status' => 'published'
                        ]);
                    }
                }
            }
        }
    }
}
