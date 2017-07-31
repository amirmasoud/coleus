<?php
/**
 * Helper global functions.
 */
if (! function_exists('convert')) {
    /**
     * Convert string numbers to Persian format.
     *
     * @param  string $string
     * @return string
     */
    function convert($string)
    {
        $persian = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
        $num = range(0, 9);
        $converted = str_replace($num, $persian, $string);
        return $converted;
    }
}

if (! function_exists('activeRoute')) {
    /**
     * Return active word to add to the class when we are on a route. used for
     * highlighting current menus.
     * @param  array $on
     * @return string
     */
    function activeRoute($on)
    {
        return str_contains(Request::url(), $on)
                ? 'active'
                : '';
    }
}

if (! function_exists('breadcrumb')) {
    /**
     * Print Breadcrumb on the page.
     *
     * @return string
     */
    function breadcrumb()
    {
        switch (Route::currentRouteName()) {
            case 'home':
                return [];
                break;
            case 'authors.books':
                $author = \App\Models\Author::cache(Route::input('author'));
                return [[
                    'name' => '<i class="fa fa-home"></i> خانه',
                    'href' => route('home')
                ], [
                    'name' => $author->name,
                    'href' => '#'
                ]];
                break;
            case 'books.list':
                $author = \App\Models\Author::cache(Route::input('author'));
                $book = \App\Models\Book::cache(Route::input('book'));
                if (Route::input('section', '') != '') {
                    $section = \App\Models\Content::cache(ROute::input('section'));
                    return [[
                        'name' => '<i class="fa fa-home"></i> خانه',
                        'href' => route('home')
                    ], [
                        'name' => $author->name,
                        'href' => route('authors.books', ['author' => $author->slug])
                    ], [
                        'name' => $book->title,
                        'href' => route('books.list', ['author' => $author->slug, 'book' => $book->slug])
                    ], [
                        'name' => $section->value,
                        'href' => '#'
                    ]];
                } else {
                    return [[
                        'name' => '<i class="fa fa-home"></i> خانه',
                        'href' => route('home')
                    ], [
                        'name' => $author->name,
                        'href' => route('authors.books', ['author' => $author->slug])
                    ], [
                        'name' => $book->title,
                        'href' => '#'
                    ]];
                }
                break;
            case 'reads.show':
                $author = \App\Models\Author::cache(Route::input('author'));
                $book = \App\Models\Book::cache(Route::input('book'));
                $section = Route::input('section', '');
                $index = Route::input('index', '');
                if ($section != '') {
                    ////////
                    $poem = \App\Models\Content::cache("{$index}_poem_{$book->id}_book_{$section}_section", $book);
                    $section = \App\Models\Content::cache($section);
                    return [[
                        'name' => '<i class="fa fa-home"></i> خانه',
                        'href' => route('home')
                    ], [
                        'name' => $author->name,
                        'href' => route('authors.books', ['author' => $author->slug])
                    ], [
                        'name' => $book->title,
                        'href' => route('books.list', ['author' => $author->slug, 'book' => $book->slug])
                    ], [
                        'name' => $section->value,
                        'href' => route('books.list', ['author' => $author->slug, 'book' => $book->slug, 'section' => $section->id])
                    ], [
                        'name' => $poem->unit . ' شماره ' . convert($poem->key) . $poem->title,
                        'href' => '#'
                    ]];
                } else {
                    $section = \App\Models\Content::cache("{$index}_poem_{$book->slug}_book_{$section}_section", $book);
                    if ($book->pages == 1) {
                        return [[
                            'name' => '<i class="fa fa-home"></i> خانه',
                            'href' => route('home')
                        ], [
                            'name' => $author->name,
                            'href' => route('authors.books', ['author' => $author->slug])
                        ], [
                            'name' => $book->title,
                            'href' => '#'
                        ]];
                    } else {
                        return [[
                            'name' => '<i class="fa fa-home"></i> خانه',
                            'href' => route('home')
                        ], [
                            'name' => $author->name,
                            'href' => route('authors.books', ['author' => $author->slug])
                        ], [
                            'name' => $book->title,
                            'href' => route('books.list', [
                                            'author' => $author->slug,
                                            'book' => $book->slug])
                        ], [
                            'name' => convert($section->title),
                            'href' => '#'
                        ]];
                    }
                }
                break;
            default:
                return [];
                break;
        }
    }
}
