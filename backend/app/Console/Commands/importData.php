<?php

namespace App\Console\Commands;

use App\User;
use App\Book;
use App\Page;
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
                            {username? : Username}
                            {bookSlug? : Book Slug}
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
            'order' => $user->order ?? 0
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
        Page::truncate();

        $users = json_decode(Storage::disk('dataset')->get('ganjoor/users/all.json'));
        foreach ($users as $user) {
            if (!is_null($this->argument('username')) && $user->username != $this->argument('username')) {
                continue;
            }
            $user = $this->insertUser($user);

            $books = json_decode(Storage::disk('dataset')->get('ganjoor/books/' . $user->username . '/books.json'));

            foreach ($books as $book) {
                if (!is_null($this->argument('bookSlug')) && $book->slug != $this->argument('bookSlug')) {
                    continue;
                }
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

                $bookPath = property_exists($book, 'path') ? $book->path : $book->slug;

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
                    'order' => $book->order ?? 0
                ]);
                $this->info('Inserting ' . $user->username . ' → ' . $book->slug . '...');

                $pages = json_decode(Storage::disk('dataset')->get('ganjoor/books/' . $user->username . '/' . $bookPath . '/pages.json'));
                usort($pages, function ($a, $b) {
                    return $a->order > $b->order;
                });
                foreach ($pages as $page) {
                    $pageModel = $book->pages()->create([
                        'title' => $page->title,
                        'order' => $page->order,
                        'status' => 'published'
                    ]);

                    $pages = (Storage::disk('dataset')->directories('ganjoor/books/' . $user->username . '/' . $bookPath . '/' . $page->path));
                    sort($pages, SORT_NATURAL);
                    $pageOrder = 0;
                    $customCount = 1;
                    foreach ($pages as $subpage) {
                        $file = json_decode(Storage::disk('dataset')->get($subpage . '/output.json'));
                        $title = '';

                        foreach ($file->text as $key => $part) {
                            if (!$key) { // First item
                                if (!property_exists($page, 'page_title') && property_exists($part, 'm1') && !property_exists($page, 'page_header')) { // First m2
                                    $title = $part->m1;
                                } else { // Custom title
                                    $CustomHeader = '';
                                    $hasCustomHeader = false;
                                    if (property_exists($page, 'page_header')) {
                                        foreach ($page->page_header as $value) {
                                            $key = key($value);
                                            if ($key == $pageOrder) {
                                                $CustomHeader = $value->{$key};
                                                $hasCustomHeader = true;
                                                break;
                                            }
                                        }
                                    }

                                    if ($hasCustomHeader) {
                                        $title = $CustomHeader;
                                    } else {
                                        if (property_exists($page, 'page_count_lang') && $page->page_count_lang == 'fa') {
                                            $str = $customCount;
                                            $western_persian = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9');
                                            $eastern_persian = array('٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩');

                                            $str = str_replace($western_persian, $eastern_persian, $str);
                                            $customCount++;
                                        }
                                        $title = property_exists($page, 'page_count')
                                            ? $page->page_title . ' ' . (property_exists($page, 'page_count_lang') ? $str : $customCount++)
                                            : $page->page_title;
                                    }

                                    if (property_exists($page, 'page_append') && property_exists($part, 'm1')) {
                                        $title .= ': ' . $part->m1;
                                    }

                                    if (property_exists($page, 'page_append') && property_exists($part, 't1')) {
                                        $title .= ': ' . $part->t1;
                                    }
                                }

                                $subPageModel = $pageModel->children()->create([
                                    'title' => $title,
                                    'order' => $pageOrder,
                                    'status' => 'published',
                                    'book_id' => $book->id
                                ]);
                                $pageOrder++;
                            }

                            if (property_exists($part, 'm1') && property_exists($part, 'm2')) {
                                $subPageModel->blocks()->create([
                                    'order' => $key,
                                    'content' => $part->m1,
                                    'status' => 'published',
                                    'type' => 'm-1/2'
                                ]);
                                $subPageModel->blocks()->create([
                                    'order' => $key,
                                    'content' => $part->m2,
                                    'status' => 'published',
                                    'type' => 'm-1/2'
                                ]);
                            }

                            if (property_exists($part, 't1') && property_exists($part, 't2')) {
                                $subPageModel->blocks()->create([
                                    'order' => $key,
                                    'content' => $part->t1,
                                    'status' => 'published',
                                    'type' => 't-1/2'
                                ]);
                                $subPageModel->blocks()->create([
                                    'order' => $key,
                                    'content' => $part->t2,
                                    'status' => 'published',
                                    'type' => 't-1/2'
                                ]);
                            }

                            if (property_exists($part, 'p')) {
                                $subPageModel->blocks()->create([
                                    'order' => $key,
                                    'content' => $part->p,
                                    'status' => 'published',
                                    'type' => 'p-full'
                                ]);
                            }
                        }
                    }
                }
            }
        }
    }
}
