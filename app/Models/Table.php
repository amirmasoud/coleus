<?php

namespace App\models;

use Cache;
use App\Models\Content;
use Kalnoy\Nestedset\NodeTrait;
use Illuminate\Database\Eloquent\Model;

class Table extends Model
{
    protected $fillable = ['key', 'value', 'title', 'book_id'];

    use NodeTrait;

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
}
