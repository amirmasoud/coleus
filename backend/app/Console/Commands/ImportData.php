<?php

namespace App\Console\Commands;

use App\User;
use App\Book;
use App\Page;
use App\Block;
use App\Contracts\Image;
use Illuminate\Support\Str;
use Illuminate\Console\Command;
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
                            {bookSlug? : Book Slug}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'import author and books';

    /**
     * Image contract instance.
     *
     * @var /App/Contracts/Image
     */
    private $image;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Image $image)
    {
        parent::__construct();

        $this->image = $image;
    }

    /**
     * Insert a new user.
     *
     * @param \App\User $user
     * @return void
     */
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
        $medium = $this->image->publicUrl('public/profile_picture/' . $uniqid . '.jpg', 512, 512);
        $placeholder = $this->image->publicUrl('public/profile_picture/' . $uniqid . '.jpg', 4, 4);
        $small = $this->image->publicUrl('public/profile_picture/' . $uniqid . '.jpg', 256, 256);
        $thumbnail = $this->image->publicUrl('public/profile_picture/' . $uniqid . '.jpg', 32, 32);
        $xsmall = $this->image->publicUrl('public/profile_picture/' . $uniqid . '.jpg', 64, 64);

        return User::create([
            'name' => $user->name,
            'username' => $user->username,
            'email' => $user->email,
            'password' => Str::random(40),
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
     * Insert a new book.
     *
     * @param \App\User $user
     * @param stdClass $book
     * @return void
     */
    public function insertBook($user, $book)
    {
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
        $medium = $this->image->publicUrl('public/book_cover/' . $uniqid . '.jpg', 800, 1200);

        // 640x400
        $small = $this->image->publicUrl('public/book_cover/' . $uniqid . '.jpg', 400, 640);

        // 160x100
        $xsmall = $this->image->publicUrl('public/book_cover/' . $uniqid . '.jpg', 100, 160);

        // 40x25
        $thumbnail = $this->image->publicUrl('public/book_cover/' . $uniqid . '.jpg', 25, 40);

        // 8*5
        $placeholder = $this->image->publicUrl('public/book_cover/' . $uniqid . '.jpg', 5, 8);

        return $user->books()->create([
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
    }

    /**
     * Convert western number to persian numbers.
     *
     * @param  string $input
     * @return void
     */
    private function convertToPersian($input)
    {
        $persian = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9');
        $western = array('٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩');

        return str_replace($western, $persian, $input);
    }

    /**
     * Format page number if it's set.
     *
     * @param  stdObject $page
     * @param  integer $idx
     * @return void
     */
    private function getPageNumber($page, $idx)
    {
        if (property_exists($page, 'page_count_lang') && $page->page_count_lang == 'fa') {
            return ' ' . $this->convertToPersian($idx);
        }
        return '';
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
        $this->info('Reset data');
        if (!is_null($this->argument('username'))) {
            $user = User::whereUsername($this->argument('username'))->first();
            if (!is_null($user)) {
                foreach ($user->books as $book) {
                    foreach ($book->pages as $page) {
                        $page->blocks()->delete();
                    }
                    $book->pages()->delete();
                    $user->books()->detach($book->id);
                    $book->delete();
                }
                $user->delete();
            }
        } else {
            User::truncate();
            Storage::deleteDirectory('profile_picture');
            Book::truncate();
            Storage::deleteDirectory('book_cover');
            Page::truncate();
            Block::truncate();
        }

        $users = json_decode(Storage::disk('dataset')->get('ganjoor/users/all.json'));
        foreach ($users as $user) {
            if (!is_null($this->argument('username')) && $user->username != $this->argument('username')) {
                continue;
            }
            $user = $this->insertUser($user);
            $this->info('Inserted user: ' . $user->username);

            $books = json_decode(Storage::disk('dataset')->get('ganjoor/books/' . $user->username . '/books.json'));

            foreach ($books as $book) {
                if (!is_null($this->argument('bookSlug')) && $book->slug != $this->argument('bookSlug')) {
                    continue;
                }
                $bookPath = property_exists($book, 'path') ? $book->path : $book->slug;
                $bookModel = $this->insertBook($user, $book);
                $this->info('Inserted book: ' . $book->slug);
                $pages = json_decode(Storage::disk('dataset')->get('ganjoor/books/' . $user->username . '/' . $bookPath . '/pages.json'));
                usort($pages, function ($a, $b) {
                    return $a->order > $b->order;
                });
                foreach ($pages as $page) {
                    $this->info('Inserting pages of ' . $book->slug . ' > ' . $page->title);
                    $pageModel = $bookModel->pages()->create([
                        'title' => $page->title,
                        'order' => $page->order,
                        'status' => 'published'
                    ]);

                    $pages = (Storage::disk('dataset')->directories('ganjoor/books/' . $user->username . '/' . $bookPath . '/' . $page->path));
                    sort($pages, SORT_NATURAL);
                    $pageOrder = 0;
                    $idx = 1;
                    $bar = $this->output->createProgressBar(count($pages));
                    $bar->start();
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
                                        if (property_exists($page, 'page_count')) {
                                            $title = $page->page_title . $this->getPageNumber($page, $idx++);
                                        } else {
                                            $title = $page->page_title;
                                        }
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
                                    'book_id' => $bookModel->id
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
                        $bar->advance();
                    }
                    $bar->finish();
                }
            }
        }
    }
}
