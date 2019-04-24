<?php

namespace App\Models;

use Tightenco\Parental\HasParentModel;
use Backpack\PageManager\app\Models\Page;

class Single extends Page
{
    use HasParentModel;

    protected $table = 'singles';
}
