<?php

namespace App\Models;

use Kalnoy\Nestedset\NodeTrait;
use Illuminate\Database\Eloquent\Model;

class Sort extends Model
{
    use NodeTrait;

    /**
     * timestamps.
     *
     * @var boolean
     */
    public $timestamps = false;

    /**
     * primaryKey
     *
     * @var integer
     */
    protected $primaryKey = null;

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * Get all of the owning sortable models.
     */
    public function sortable()
    {
        return $this->morphTo();
    }
}
