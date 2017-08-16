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
                            ->when(!is_null($parent), function ($query) use ($parent) {
                                return $query->where('tables.parent_id', TableRepo::slug($parent)->id);
                            })
                            ->first();
            });
    }

    /**
     * Get content by book_id and order
     *
     * @param integer $book_id
     * @param integer $order
     */
    public static function API_leaf($slug)
    {
        return Cache::remember("api:content:{$slug}",
            self::MONTH_IN_MINUTE, function () use ($slug) {
                $content = self::slug($slug);
                return self::formatted(self::leaf($content->table->book->id,
                    $content->order, $content->table->parent->slug));
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
            self::MONTH_IN_MINUTE, function () use ($content) {
                return self::checkLink($content->getNextSibling());
            });
    }

    /**
     * Get next content.
     *
     * @param string $slug
     */
    public static function API_next($slug)
    {
        return Cache::remember("api:content:{$slug}:next",
            self::MONTH_IN_MINUTE, function () use ($slug) {
                $content = self::slug($slug);
                $content = self::leaf($content->table->book->id,
                    $content->order, $content->table->parent->slug);
                return ($next = self::checkLink($content->getNextSibling())) == '#'
                    ? '#'
                    : $next->content->slug;
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
            self::MONTH_IN_MINUTE, function () use ($content) {
                return self::checkLink($content->getPrevSibling());
            });
    }

    /**
     * Get prev content.
     *
     * @param string $slug
     */
    public static function API_prev($slug)
    {
        return Cache::remember("api:content:{$slug}:prev",
            self::MONTH_IN_MINUTE, function () use ($slug) {
                $content = self::slug($slug);
                $content = self::leaf($content->table->book->id,
                    $content->order, $content->table->parent->slug);
                $prev = self::checkLink($content->getPrevSibling());
                return ($prev = self::checkLink($content->getPrevSibling())) == '#'
                    ? '#'
                    : $prev->content->slug;
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
            self::MONTH_IN_MINUTE, function () use ($slug) {
                return Content::with('table')->whereSlug($slug)->first();
            });
    }

    /**
     * Get content by slug
     *
     * @param  string $slug
     * @return \App\Models\Content
     */
    public static function API_slug($slug)
    {
        return Cache::remember("api:content:{$slug}",
            self::MONTH_IN_MINUTE, function () use ($slug) {
                return self::formatted(Content::whereSlug($slug)->first());
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

    /**
     * Prepare json for content.
     * @param  Collection|\App\Models\Content $content
     * @return array
     */
    public static function formatted($content)
    {
        if ($content instanceof Content) {
            return [
                'title'  => $content->table->title,
                'text'   => $content->text,
                'page'   => $content->order,
                'pages'  => $content->pages,
            ];
        } else {
            $formatted = [];
            foreach ($content as $c) {
                $formatted[] = [
                    'title'  => $c->title,
                    'text'   => $c->text,
                    'page'   => $c->order,
                    'pages'  => $c->pages,
                ];
            }
            return $formatted;
        }
    }
}
