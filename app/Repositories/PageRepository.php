<?php

namespace App\Repositories;

use App\Models\Page;

class PageRepository extends Repository
{
    /**
     * @param  integer $slug
     * @return mixed
     */
    public function findById($id)
    {
        return Page::whereId($id);
    }
}
