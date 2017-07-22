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
                        'name' => $author->name,
                        'href' => route('authors.books', ['author' => $author->id])
                    ], [
                        'name' => $book->title,
                        'href' => route('books.list', ['author' => $author->id, 'book' => $book->id])
                    ], [
                        'name' => $section->value,
                        'href' => '#'
                    ]];
                } else {
                    return [[
                        'name' => $author->name,
                        'href' => route('authors.books', ['author' => $author->id])
                    ], [
                        'name' => $book->title,
                        'href' => '#'
                    ]];
                }
                break;
            case 'reads.show':
                $author = \App\Models\Author::cache(Route::input('author'));
                $book = \App\Models\Book::cache(Route::input('book'));
                if (Route::input('section', '') != '') {
                    $section = \App\Models\Content::cache(ROute::input('section'));
                    return [[
                        'name' => $author->name,
                        'href' => route('authors.books', ['author' => $author->id])
                    ], [
                        'name' => $book->title,
                        'href' => route('books.list', ['author' => $author->id, 'book' => $book->id])
                    ], [
                        'name' => $section->value,
                        'href' => route('books.list', ['author' => $author->id, 'book' => $book->id, 'section' => $section->id])
                    ], [
                        'name' => 'غزل شماره ' . convert(Route::input('index')),
                        'href' => '#'
                    ]];
                } else {
                    return [[
                        'name' => $author->name,
                        'href' => route('authors.books', ['author' => $author->id])
                    ], [
                        'name' => $book->title,
                        'href' => route('books.list', ['author' => $author->id, 'book' => $book->id])
                    ], [
                        'name' => 'غزل شماره ' . convert(Route::input('index')),
                        'href' => '#'
                    ]];
                }
                break;
            default:
                return [];
                break;
        }
    }
}
