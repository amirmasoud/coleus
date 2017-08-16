<?php

namespace App\Repositories;

use Cache;
use App\Models\Table;
use App\Models\Content;
use App\Repositories\TableRepo;

class ContentRepo extends Repo
{
    /**
     * Get content by book_id and order
     *
     * @param integer $book_id
     * @param integer $order
     */
    public static function leaf($book_id, $order, $parent = null)
    {
        return Cache::remember("content:{$order}:book:{$book_id}:parent:{$parent}",
            self::MONTH_IN_MINUTE, function () use ($book_id, $order, $parent) {
                return Table::join('contents', 'contents.table_id', 'tables.id')
                            ->where('tables.book_id', $book_id)
                            ->where('contents.order', $order)
                            ->when(!is_null($parent), function($query) use ($parent) {
                                return $query->where('tables.parent_id', TableRepo::slug($parent)->id);
                            })
                            ->first();
            });
    }

    /**
     * Get next content by book_id and order
     *
     * @param integer $book_id
     * @param integer $order
     */
    public static function next($book_id, $order, $parent = null)
    {
        $content = self::leaf($book_id, $order, $parent);
        return Cache::remember("content:{$order}:book:{$book_id}:parent:{$parent}:next",
            self::MONTH_IN_MINUTE, function() use ($content) {
            return self::checkLink($content->getNextSibling());
        });
    }

    /**
     * Get prev content by book_id and order
     *
     * @param integer $book_id
     * @param integer $order
     */
    public static function prev($book_id, $order, $parent = null)
    {
        $content = self::leaf($book_id, $order, $parent);
        return Cache::remember("content:{$order}:book:{$book_id}:parent:{$parent}:prev",
            self::MONTH_IN_MINUTE, function() use ($content) {
            return self::checkLink($content->getPrevSibling());
        });
    }

    /**
     * Get content by slug
     *
     * @param  string $slug
     * @return \App\Models\Content
     */
    public static function slug($slug)
    {
        return Cache::remember("content:{$slug}",
            self::MONTH_IN_MINUTE, function() use ($slug) {
            return Content::with('table')->whereSlug($slug)->first();
        });
    }

    /**
     * Check boundary of content.
     *
     * @param  \App\Models\Content $content
     * @return string|\App\Models\Content
     */
    protected static function checkLink($content)
    {
        if (! is_null($content)) {
            // Append content to content object
            $content->content = $content->content;
        } else {
            // If it's the last leaf
            $content = '#';
        }
        return $content;
    }
}
