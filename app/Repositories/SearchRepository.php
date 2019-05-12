<?php

namespace App\Repositories;

use Elasticsearch;
use Illuminate\Support\Str;

class SearchRepository extends Repository
{
    public function autocomplete($query, $fields)
    {
        $params = [
            'body'  => [
                ['index' => 'paragraphs'],
                [
                    'size' => 3,
                    'query' => [
                        'multi_match' => [
                            'query' => $query,
                            'fields' => [
                                'content^3'
                            ]
                        ]
                    ],
                    'highlight' => [
                        'fragment_size' => 100,
                        'fields' => [
                            'content' => [
                                'pre_tags' => '<span class="border-b border-b-1 border-sweet-brown">',
                                'post_tags' => '</span>',
                            ]
                        ]
                    ]
                ],
                ['index' => 'books'],
                [
                    'size' => 2,
                    'query' => [
                        'multi_match' => [
                            'query' => $query,
                            'fields' => [
                                'title^3', 'description'
                            ]
                        ]
                    ],
                    'highlight' => [
                        'fragment_size' => 100,
                        'fields' => [
                            'title' => [
                                'pre_tags' => '<span class="border-b border-b-1 border-sweet-brown">',
                                'post_tags' => '</span>',
                            ],
                            'description' => [
                                'pre_tags' => '<span class="border-b border-b-1 border-sweet-brown">',
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
                            'query' => $query,
                            'fields' => [
                                'name^3', 'username^3', 'bio^2'
                            ]
                        ]
                    ],
                    'highlight' => [
                        'fragment_size' => 100,
                        'fields' => [
                            'name' => [
                                'pre_tags' => '<span class="border-b border-b-1 border-sweet-brown">',
                                'post_tags' => '</span>',
                            ],
                            'username' => [
                                'pre_tags' => '<span class="border-b border-b-1 border-sweet-brown">',
                                'post_tags' => '</span>',
                            ],
                            'bio' => [
                                'pre_tags' => '<span class="border-b border-b-1 border-sweet-brown">',
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

                    if ($res['__typename'] == 'Book' && array_key_exists('collaborators', $fields['books'])) {
                        $res['collaborators'] = \App\Models\Book::find($res['id'])->collaborators;
                    }

                    if ($res['__typename'] == 'Paragraph' && array_key_exists('page', $fields['paragraphs'])) {
                        $res['page'] = [\App\Models\Paragraph::find($res['id'])->page];
                    }

                    if ($res['__typename'] == 'Paragraph') {
                        $res['book'] = [\App\Models\Paragraph::find($res['id'])->page->book];
                    }

                    if ($res['__typename'] == 'Paragraph') {
                        $res['collaborators'] = \App\Models\Paragraph::find($res['id'])->page->book->collaborators;
                    }

                    $return[$hit['_index']][] = $res;
                }
            }
        }

        return $return;
    }
}
