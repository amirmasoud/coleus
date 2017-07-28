<?php

namespace App\models;

use Kalnoy\Nestedset\NodeTrait;
use Illuminate\Database\Eloquent\Model;

class Table extends Model
{
    protected $fillable = ['key', 'value', 'title', 'unit', 'book_id'];
    use NodeTrait;
}
