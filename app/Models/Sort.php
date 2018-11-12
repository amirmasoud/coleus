<?php

namespace App\Models;

use Kalnoy\Nestedset\NodeTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Sort extends Model
{
    use NodeTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'sortable_id', 'sortable_type', '_lft', '_rgt', 'parent_id', 'scope'
    ];

    /**
     * timestamps.
     *
     * @var boolean
     */
    public $timestamps = false;

    protected function getScopeAttributes()
    {
        return ['scope'];
    }

    /**
     * Scope a query.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @param  mixed $class
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOfType($query, $class)
    {
        return $query->where('sortable_type', get_class($class))
                     ->where('sortable_id', $class->id);
    }

    /**
     * Get all of the owning sortable models.
     */
    public function sortable()
    {
        return $this->morphTo();
    }
}
