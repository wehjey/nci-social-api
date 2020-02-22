<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TopicImage extends Model
{

    public $fillable = [
        'image_url', 'topic_id'
    ];

    /**
     * Topic image belongs to a topic
     *
     * @return object
     */
    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }
}
