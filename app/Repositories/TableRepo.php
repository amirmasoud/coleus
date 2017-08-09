<?php

namespace App\Repositories;

use Cache;
use App\Models\Table;

class TableRepo extends Repo
{
    /**
     * Find a table by slug.
     *
     * @param  string $slug
     * @return \App\Models\Table
     */
    public static function slug($slug)
    {
        return Cache::remember("table:{$slug}",
            self::MONTH_IN_MINUTE, function () use ($slug) {
                return Table::where('slug', $slug)->first();
            });
    }

    /**
     * Is book's table of content multi level.
     *
     * @param  integer  $book_id
     * @return boolean
     */
    public static function isMultiLevel($book_id)
    {
        return Cache::remember("table:book:{$book_id}:multilevel",
            self::MONTH_IN_MINUTE, function () use ($book_id) {
                return Table::where('book_id', $book_id)
                            ->whereIsRoot()->first()
                            ->children()->count() > 1 ? true : false;
            });
    }

    /**
     * Get leaves of book's table of content.
     *
     * @param  integer $book_id
     * @return collection
     */
    public static function leaves($book_id)
    {
        return Cache::remember("table:book:{$book_id}:leaves",
            self::MONTH_IN_MINUTE, function () use ($book_id) {
                return Table::join('contents', 'contents.table_id', 'tables.id')
                            ->whereRaw('tables._lft + 1 = tables._rgt')
                            ->where('tables.book_id', $book_id)
                            ->orderBy('contents.order')
                            ->get();
            });
    }

    /**
     * Get leaves of book's table of content.
     *
     * @param  integer $book_id
     * @param  integer $parent_id
     * @return collection
     */
    public static function leavesOfParent($book_id, $parent_id)
    {
        return Cache::remember("table:book:{$book_id}:parent:{$parent_id}:leaves",
            self::MONTH_IN_MINUTE, function () use ($book_id, $parent_id) {
                return Table::join('contents', 'contents.table_id', 'tables.id')
                            ->whereRaw('tables._lft + 1 = tables._rgt')
                            ->where('tables.book_id', $book_id)
                            ->where('parent_id', $parent_id)
                            ->orderBy('contents.order')
                            ->get();
            });
    }


    /**
     * Get route's children.
     *
     * @param  integer $book_id
     * @return \App\Models\Table
     */
    public static function routeChildren($book_id)
    {
        return Cache::remember("table:book:{$book_id}:routeChildren",
            self::MONTH_IN_MINUTE, function () use ($book_id) {
                return Table::where('book_id', $book_id)
                          ->where('parent_id', Table::where('book_id', $book_id)
                                                    ->whereIsRoot()->first()->id)
                          ->orderBy('id')
                          ->get();
            });
    }
}
