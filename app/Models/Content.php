<?php

namespace App\Models;

use Cache;
use App\Models\Table;
use App\Models\Content;
use App\Repositories\TableRepo;
use Elasticquent\ElasticquentTrait;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Content extends Model
{
    use Sluggable, ElasticquentTrait;

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

    private function buildFieldsParameter($getSourceIfPossible, $getTimestampIfPossible)
    {
        return null;
    }

    /**
     * Paginate Collection
     *
     * @param int $pageLimit
     *
     * @return Paginator
     */
    public function paginate($pageLimit = 10)
    {
        $page = Paginator::resolveCurrentPage() ?: 1;
        //$sliced_items = array_slice($this->items, ($page - 1) * $pageLimit, $pageLimit);

        return new Paginator($this->items, $this->hits, $this->totalHits(), $pageLimit, $page, ['path' => Paginator::resolveCurrentPath()]);
    }
}
