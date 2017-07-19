<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    public static function batchInsert($content, $book_id)
    {
        $content = json_decode($content);
        if (isset($content->type) && $content->type == 'collection') {
            $content = $content->collection;
            $i = 1;
            foreach($content as $name => $c) {
                $content_id = Content::insertGetId([
                                'key' => $i++, 
                                'value' => $name, 
                                'type' => 'section', 
                                'book_id' => $book_id
                            ]);
                $j = 1;
                foreach ($c as $sh) {
                    Content::insertGetId([
                        'key' => $j++, 
                        'value' => json_encode($sh), 
                        'type' => 'poem', 
                        'book_id' => $book_id, 
                        'content_id' => $content_id,
                    ]);
                }
            }
        }
    }

    /**
     * Get the  value.
     *
     * @param  string  $value
     * @return string
     */
    public function getValueAttribute($value)
    {
        return ($value);
    }
}
