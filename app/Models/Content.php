<?php

namespace App\Models;

use Cache;
use App\Models\Table;
use App\Models\Content;
use App\Repositories\TableRepo;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Content extends Model
{
    use Sluggable;

    protected $fillable = ['text', 'hash', 'slug', 'order', 'table_id', 'html'];

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'hash'
            ]
        ];
    }

    public function table()
    {
        return $this->belongsTo(Table::class);
    }

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
        $root = self::getRoot($book_id, $content->title);
        $parent = self::appendNodeIfNotExists($content, $root);
        foreach ($content->children as $child) {
            // Insert New Node
            $table = self::appendNodeIfNotExists($child, $parent);
            // Insert New Content
            self::insertContentIfNotExists($child, $table);
        }
    }

    /**
     * Get book ID table of contents. Create new one or return exist one.
     * @param  integer $book_id
     * @param  string $title
     * @return \App\Models\Table
     */
    protected static function getRoot($book_id, $title)
    {
        if (!Table::where('book_id', $book_id)
                  ->whereNull('parent_id')->exists()) {
            return Table::create([
                'title'   => '',
                'book_id' => $book_id,
                'slug' => $book_id,
                'type' => 'no-type'
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
                  ->where('parent_id', $parent->id)
                  ->exists()) {
            $node = Table::create([
                        'title'   => $content->title,
                        'book_id' => $parent->book_id,
                        'type'   => isset($content->type) ? $content->type : 'no-type'
                    ]);
            $node->appendToNode($parent)->save();
            return $node;
        } else {
            return Table::where('book_id', $parent->book_id)
                ->where('title', $content->title)
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
        $html = self::htmlify($child->text);
        $text =json_encode($child->text);
        $hash = md5($text . '-' . $html . '-' . $table->id . '-' . $child->order);
        if (! Content::where('hash', $hash)
                ->exists()) {
            Content::create([
                'html' => $html,
                'text' => $text,
                'order' => $child->order,
                'hash' => $hash,
                'table_id' => $table->id
            ]);
        }
    }

    public static function htmlify($text)
    {
        $html = '';
        foreach ($text as $content) {
            if (isset($content->m1)) {
                $html .= '<div class="b"><span class="m1">' . $content->m1 .
                '</span><span class="m2">' . $content->m2 . '</span></div>';
            } else if (isset($content->p)) {
                $html .= '<div class="p"><p>' . $content->p . '</p></div>';
            } else if (isset($content->t1)) {
                $html .= '<div class="t">' .
                    '<p class="t1 text-center"><strong>' . $content->t1 .
                    '</strong></p>' .
                    '<p class="t2 text-center"><strong>' . $content->t2 .
                    '</strong></p></div>';
            } else {
                // What to do ?
            }
        }
        return $html;
    }

    /**
     * Set the text value.
     *
     * @param  string  $value
     * @return void
     */
    // public function setTextAttribute($value)
    // {
    //     $this->attributes['text'] = json_encode($value);
    // }

    /**
     * Get the text value.
     *
     * @param  string  $value
     * @return string
     */
    public function getTextAttribute($value)
    {
        return json_decode($value);
    }

    /**
     * Get the pages value.
     *
     * @param  string  $value
     * @return string
     */
    public function getPagesAttribute($value)
    {
        return TableRepo::count($this->table_id);
    }
}
