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
                $author = \App\Repositories\AuthorRepo::slug(Route::input('author'));
                return [[
                    'name' => '<i class="fa fa-home"></i> خانه',
                    'href' => route('home')
                ], [
                    'name' => $author->name,
                    'href' => '#'
                ]];
                break;
            case 'books.list':
                $author = \App\Repositories\AuthorRepo::slug(Route::input('author'));
                $book = \App\Repositories\BookRepo::slug(Route::input('book'));
                $parent = Route::input('parent', '');
                if (Route::input('parent', '') != '') {
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
                        'name' => $parent,
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
                        'name' => $parent,
                        'href' => '#'
                    ]];
                }
                break;
            case 'reads.show':
                $author = \App\Repositories\AuthorRepo::slug(Route::input('author'));
                $book = \App\Repositories\BookRepo::slug(Route::input('book'));
                $parent = Route::input('parent', '');
                $index = Route::input('index', '');
                if ($parent != '') {
                    $content = \App\Repositories\ContentRepo::leaf($book->id, $index, $parent);
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
                        'name' => $parent,
                        'href' => route('books.list', ['author' => $author->slug, 'book' => $book->slug, 'parent' => $parent])
                    ], [
                        'name' => $content->title,
                        'href' => '#'
                    ]];
                } else {
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
                        $content = \App\Repositories\ContentRepo::leaf($book->id, $index, $parent);
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
                            'name' => convert($content->title),
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

