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

Route::get('/', function () {
    $params = [
        'body'  => [
            ['index' => 'paragraphs'],
            [
                'query' => [
                    'match' => [
                        'content' => 'با من صنما دل دل'
                    ]
                ],
            ],
            ['index' => 'books'],
            [
                'query' => [
                    'match' => [
                        'title' => 'صنما'
                    ]
                ]
            ],
            ['index' => 'users'],
            [
                'query' => [
                    'multi_match' => [
                        'query' => 'میلادی',
                        'fields' => [
                            'name^3', 'username^3', 'website', 'bio^2'
                        ],
                        'type' => 'phrase_prefix'
                    ],
                ]
            ]
        ],
    ];
    return Elasticsearch::msearch($params);
});

Route::get('{path}', function () {
    return view('index');
})->where('path', '(.*)');
