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

        Sort::when($page->getParent(), function($query) use ($book, $page) {
            $query->where('scope', 'book#' . $book->id)
                ->where('sortable_type', get_class($page->getParent()))
                ->where('sortable_id', $page->getParent()->id);
        }, function($query) use ($book) {
            $query->where('scope', 'book#' . $book->id)
                ->where('sortable_type', get_class($book));
        })->first()
            ->appendNode($child);

        $chunks = explode('</p>', $page->content);
        foreach ($chunks as $chunk) {
            if (starts_with($chunk, '<p class="col-12 col-md-6" style="text-align: right;">')) {
                $paragraph = str_replace('<p class="col-12 col-md-6" style="text-align: right;">', '', $chunk);
                $page->paragraphs()->create([
                    'content' => $paragraph,
                    'type' => 'App\Types\TowColumns',
                ]);
            } else if (starts_with($chunk, '<p class="t col-12 col-md-6" style="text-align: right;">')) {
                $paragraph = str_replace('<p class="t col-12 col-md-6" style="text-align: right;">', '', $chunk);
                $page->paragraphs()->create([
                    'content' => $paragraph,
                    'type' => 'App\Types\TowColumns',
                ]);
            } else if (starts_with($chunk, '<p class="t col-12" style="text-align: right;">')) {
                $paragraph = str_replace('<p class="t col-12" style="text-align: right;">', '', $chunk);
                $page->paragraphs()->create([
                    'content' => $paragraph,
                    'type' => 'App\Types\OneColumn',
                ]);
            } else {
                $page->paragraphs()->create([
                    'content' => $chunk,
                    'type' => 'App\Types\Plain',
                ]);
            }
        }
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
