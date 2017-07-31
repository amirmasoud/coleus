<?php

namespace App\Models;

use Cache;
use App\Models\Table;
use App\Models\Content;
use Illuminate\Database\Eloquent\Model;

class Content extends Model
{

    protected $fillable = ['text', 'order', 'table_id'];

    /**
     *
     * @param  integer $ucid Unique Cache ID
     * @return \App\Models\Author
     */
    public static function cache($ucid, ...$extra)
    {
        $cache_key = config('app.name') . '_content_' . $ucid;
        if (Cache::has($cache_key)) {
            return Cache::get($cache_key);
        } else {
            if ($ucid == '*') {
                $cache_value = Content::get();
            } elseif (strpos($ucid, 'next')) {
                // {$content->id}_content_{$content->book_slug}_book_{$section}_section_next
                $pieces = explode('_', $ucid);
                if ($pieces[4] == '') {
                    $cache_value = self::cache("{$pieces[0]}_poem_{$pieces[2]}_book__section", $extra[0])
                                        ->getNextSibling();
                    if (! is_null($cache_value)) {
                        $cache_value->content = $cache_value->content;
                    } else {
                        $cache_value = '#';
                    }
                } else {
                    ////////////
                    $cache_value = Content::where('id', '>', $pieces[0])
                                          ->where('book_id', $pieces[2])
                                          ->where('type', 'poem')
                                          ->where('content_id', $pieces[4])
                                          ->orderBy('id')
                                          ->first() ?? '#';
                }
            } elseif (strpos($ucid, 'prev')) {
                // {$content->id}_content_{$poem->book_id}_book_{$section}_section_prev
                $pieces = explode('_', $ucid);
                if ($pieces[4] == '') {
                    $cache_value = self::cache("{$pieces[0]}_poem_{$pieces[2]}_book__section", $extra[0])
                                        ->getPrevSibling();
                    if (! is_null($cache_value)) {
                        $cache_value->content = $cache_value->content;
                    } else {
                        $cache_value = '#';
                    }
                } else {
                    ///////////
                    $cache_value = Content::where('id', '<', $pieces[0])
                                          ->where('book_id', $pieces[2])
                                          ->where('type', 'poem')
                                          ->where('content_id', $pieces[4])
                                          ->orderBy('id', 'desc')
                                          ->first() ?? '#';
                }
            } elseif (strpos($ucid, 'poem')) {
                // {$index}_poem_{$book_slug}_book_{$section}_section
                $pieces = explode('_', $ucid);
                if ($pieces[4] == '') {
                    $cache_value = Table::join('contents', 'contents.table_id', 'tables.id')
                                        ->where('tables.book_id', $extra[0]->id) // $extra[0] -> Book
                                        ->where('contents.order', $pieces[0])
                                        ->first();
                } else {
                    /////////////
                    $cache_value = Content::where('book_id', $pieces[2])
                                          ->where('type', 'poem')
                                          ->where('content_id', $pieces[4])
                                          ->where('key', $pieces[0])->first();
                }
            } elseif (strpos($ucid, 'list')) {
                $cache_value = Content::where('type', 'section')
                                      ->where('book_id', explode('_', $ucid)[0])
                                      ->orderBy('key')
                                      ->get();
            } elseif (strpos($ucid, 'section')) {
                // _content_{$book->id}_book_{$content->value}_section
                $cache_value = Content::where('type', 'poem')
                                      ->where('book_id', explode('_', $ucid)[0])
                                      ->where('content_id', explode('_', $ucid)[2])
                                      ->orderBy('key')
                                      ->get();
            } else {
                $cache_value = Content::find($ucid);
            }
            Cache::forever($cache_key, $cache_value);
            return $cache_value;
        }
    }

    /**
     * Insert poems.
     * @param  json $content
     * @param  integer $book_id
     * @return void
     */
    public static function batchInsert($content, $book_id)
    {
        ini_set('max_execution_time', 5*60);
        $content = json_decode($content);
        $root = self::getRoot($book_id);
        $parent = self::appendNodeIfNotExists($content, $root);
        foreach($content->children as $child) {
            // Insert New Node
            $table = self::appendNodeIfNotExists($child, $parent);
            // Insert New Content
            self::insertContentIfNotExists($child, $table);
        }
    }

    /**
     * Get book ID table of contents. Create new one or return exist one.
     * @param  integer $book_id
     * @return \App\Models\Table
     */
    protected static function getRoot($book_id)
    {
        if (!Table::where('book_id', $book_id)->whereNull('parent_id')->exists()) {
            return Table::create([
                'title'   => '',
                'unit'    => '',
                'book_id' => $book_id
            ]);
        } else {
            return Table::where('book_id', $book_id)
                ->whereNull('parent_id')->first();
        }
    }

    /**
     * Append a child to the parent.
     * @param  StdObj $content
     * @param  \App\Models\Table $parent
     * @return void
     */
    protected static function appendNodeIfNotExists($content, $parent)
    {
        if (! Table::where('book_id', $parent->book_id)
                ->where('title', $content->title)
                ->where('unit', $content->unit)
                ->whereNotNull('parent_id')
                ->exists()) {
            $node = Table::create([
                        'title'   => $content->title,
                        'unit'    => $content->unit,
                        'book_id' => $parent->book_id
                    ]);
            $node->appendToNode($parent)->save();
            return $node;
        } else {
            return Table::where('book_id', $parent->book_id)
                ->where('title', $content->title)
                ->where('unit', $content->unit)
                ->whereNotNull('parent_id')->first();
        }
    }

    /**
     * Insert new content if not exists.
     * @param  StdObj $child
     * @param  \App\Models\Table $table
     * @return void
     */
    public static function insertContentIfNotExists($child, $table)
    {
        $text = json_encode($child->text);
        if (! Content::where('order', $child->order)
                ->where('table_id', $table->id)
                ->where('text', $text)
                ->exists()) {
            Content::create([
                'text' => $text,
                'order' => $child->order,
                'table_id' => $table->id
            ]);
        }
    }

    /**
     * Get the title value.
     *
     * @param  string  $value
     * @return string
     */
    public function getTitleAttribute($value)
    {
        return property_exists($value = json_decode($this->value), 'title')
            ? ' - ' . $value->title
            : '';
    }

    /**
     * Get the unit value.
     *
     * @param  string  $value
     * @return string
     */
    public function getUnitAttribute($value)
    {
        return property_exists($value = json_decode($this->value), 'unit')
            ? $value->unit
            : 'شعر';
    }
}
