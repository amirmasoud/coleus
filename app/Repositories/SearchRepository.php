<?php

namespace App\Repositories;

use Elasticsearch;
use Illuminate\Support\Str;

class SearchRepository extends Repository
{
    public function autocomplete($query)
    {
        $params = [
            'body'  => [
                ['index' => 'paragraphs'],
                [
                    'size' => 5,
                    'query' => [
                        'multi_match' => [
                            'query' => 'صنما',
                            'fields' => [
                                'content^3'
                            ]
                        ]
                    ],
                    'highlight' => [
                        'fragment_size' => 100,
                        'fields' => [
                            'content' => [
                                'pre_tags' => '<span class="border-b border-b-1 border-dashed border-teal pb-1">',
                                'post_tags' => '</span>',
                            ]
                        ]
                    ]
                ],
                ['index' => 'books'],
                [
                    'size' => 3,
                    'query' => [
                        'multi_match' => [
                            'query' => 'دیوان',
                            'fields' => [
                                'title^3', 'description'
                            ]
                        ]
                    ],
                    'highlight' => [
                        'fragment_size' => 100,
                        'fields' => [
                            'title' => [
                                'pre_tags' => '<span class="bg-teal-lightest text-teal-dark">',
                                'post_tags' => '</span>',
                            ],
                            'description' => [
                                'pre_tags' => '<span class="border-b border-b-1 border-dashed border-teal pb-1">',
                                'post_tags' => '</span>',
                            ]
                        ]
                    ]
                ],
                ['index' => 'users'],
                [
                    'size' => 2,
                    'query' => [
                        'multi_match' => [
                            'query' => 'hafez',
                            'fields' => [
                                'name^3', 'username^3', 'bio^2'
                            ]
                        ]
                    ],
                    'highlight' => [
                        'fragment_size' => 100,
                        'fields' => [
                            'name' => [
                                'pre_tags' => '<span class="bg-teal-lightest text-teal-dark">',
                                'post_tags' => '</span>',
                            ],
                            'username' => [
                                'pre_tags' => '<span class="border-b border-b-1 border-dashed border-teal pb-1">',
                                'post_tags' => '</span>',
                            ],
                            'bio' => [
                                'pre_tags' => '<span class="border-b border-b-1 border-dashed border-teal pb-1">',
                                'post_tags' => '</span>',
                            ]
                        ]
                    ]
                ]
            ],
        ];

        $results = Elasticsearch::msearch($params);
        $return = [];

        foreach ($results['responses'] as $result) {
            if (!$result['timed_out'] && count($result['hits']) && count($result['hits']['hits'])) {
                foreach ($result['hits']['hits'] as $hit) {
                    $res = $hit['_source'];
                    $res['highlight'] = [$hit['highlight']];
                    $res['__typename'] = ucfirst(Str::singular($hit['_index']));
                    $return[$hit['_index']][] = $res;
                }
            }
        }

        return $return;
    }
}
