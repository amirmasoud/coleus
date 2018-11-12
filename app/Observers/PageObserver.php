<?php

namespace App\Observers;

use App\Models\Page;
use App\Models\Sort;

class PageObserver
{
    /**
     * Handle the page "created" event.
     *
     * @param  \App\Models\Page  $page
     * @return void
     */
    public function created(Page $page)
    {
        $book = $page->book;

        $child = Sort::create([
            'sortable_type' => get_class($page),
            'sortable_id' => $page->id,
            'scope' => 'book#' . $book->id
        ]);

        Sort::where('scope', 'book#' . $book->id)
            ->where('sortable_type', get_class($book))
            ->first() // Parent
            ->appendNode($child);
    }

    /**
     * Handle the page "updated" event.
     *
     * @param  \App\Models\Page  $page
     * @return void
     */
    public function updated(Page $page)
    {
        //
    }

    /**
     * Handle the page "deleted" event.
     *
     * @param  \App\Models\Page  $page
     * @return void
     */
    public function deleted(Page $page)
    {
        //
    }

    /**
     * Handle the page "restored" event.
     *
     * @param  \App\Models\Page  $page
     * @return void
     */
    public function restored(Page $page)
    {
        //
    }

    /**
     * Handle the page "force deleted" event.
     *
     * @param  \App\Models\Page  $page
     * @return void
     */
    public function forceDeleted(Page $page)
    {
        //
    }
}
