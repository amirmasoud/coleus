<?php

namespace App\Models;

use Cache;
use App\Models\Content;
use Kalnoy\Nestedset\NodeTrait;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Table extends Model
{
    use NodeTrait, Sluggable {
        Sluggable::replicate insteadof NodeTrait;
        NodeTrait::replicate as NodeTraitReplicate;
    }

    protected $fillable = ['title', 'slug', 'book_id', 'type'];


    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    /**
     *
     * @param  integer $ucid Unique Cache ID
     * @return \App\Models\Author
     */
    public static function cache($ucid)
    {
        $cache_key = config('app.name') . '_table_' . $ucid;
        if (Cache::has($cache_key)) {
            return Cache::get($cache_key);
        } else {
            if (strpos($ucid, 'exists')) {
                // {$book->id}_exists
                $cache_value = Table::whereRaw('_lft + 1 != _rgt')
                                      ->whereNotNull('parent_id')
                                      ->where('book_id', explode('_', $ucid)[0])
                                      ->count() > 1 ? true : false;
            } elseif (strpos($ucid, 'book')) {
                $cache_value = Table::join('contents', 'contents.table_id', 'tables.id')
                                      ->whereRaw('tables._lft + 1 = tables._rgt')
                                      ->where('tables.book_id', explode('_', $ucid)[0])
                                      ->orderBy('contents.order')
                                      ->get();
            }
            Cache::forever($cache_key, $cache_value);
            return $cache_value;
        }
    }

    /**
     * Get the content for the table.
     * @return Illuminate\Database\Eloquent\Concerns\belongsTo
     */
    public function content()
    {
        return $this->belongsTo(Content::class, 'id', 'table_id');
    }

    public function book()
    {
        return $this->belongsTo('App\Models\Book');
    }

    public function v1Json()
    {
        return [
            'id' => $this->id,
            'slug' => $this->slug,
            'type' => $this->type,
            'parent_id' => $this->parent_id,
            'text' => $this->text,
            'order' => $this->order,
            'table_id' => $this->table_id,
            'content' => $this->content,
        ];
    }

    /**
     * Set the text value.
     *
     * @param  string  $value
     * @return void
     */
    public function setTextAttribute($value)
    {
        $this->attributes['text'] = json_encode($value);
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
}
