<?php

namespace App\Http\ViewComposers;

use App\Models\Slider;
use Illuminate\View\View;
use App\Repositories\UserRepository;

class CarouselComposer
{
    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('sliders', Slider::orderBy('updated_at', 'desc')
                                    ->limit(config('admin.sliders'))
                                    ->get());
    }
}