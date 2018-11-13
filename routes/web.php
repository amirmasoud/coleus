<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

Route::get('test', function() {
    $hafez = Storage::disk('dataset')->allFiles('ganjoor/hafez/ghaside');
    foreach ($hafez as $poem) {
        if (Str::endsWith($poem, '.json')) {
            $file = json_decode(Storage::disk('dataset')->get($poem));
            $title = '';
            $content = '';
            foreach ($file->text as $key => $part) {
                if (! $key) { // First item - Generate title of page
                    $title = $part->m1;
                }
                $content .= '<p class="col-12 col-md-6" style="text-align: right;">' . $part->m1 . '</p>';
                $content .= '<p class="col-12 col-md-6" style="text-align: right;">' . $part->m2 . '</p>';
            }
            \App\Models\Book::find(41)
                ->pages()
                ->create([
                    'title' => $title,
                    'content' => $content
                ]);
        }
    }
});

Route::get('{path}', function () {
    return view('index');
})->where('path', '(.*)');
