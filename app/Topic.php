<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\TopicImage;

class Topic extends Model
{

    public $fillable = [
        'title', 'description', 'hashtag', 'user_id'
    ];

    protected $with = [
        'images'
    ];

    /**
     * Topic belongs to a user
     *
     * @return object
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Undocumented function
     *
     * @return object
     */
    public function images()
    {
        return $this->hasMany(TopicImage::class);
    }

    /**
     * Undocumented function
     *
     * @param array $data Request data
     * 
     * @return object
     */
    public static function addNew($data)
    {
        $topic = self::create(
            [
                'title' => $data['title'],
                'hashtag' => '#'. str_replace(' ', '', ucwords($data['title'])),
                'description' => $data['description'],
                'user_id' => auth()->id()
            ]
        );

        // Save images if user uploaded
        if (isset($data['images'])) {
            self::saveImages($data, $topic);
        }

        return $topic;
    }

    /**
     * Save topic images to cloudinary API
     * 
     * @param array  $data  Request data
     * @param object $topic Newly created topic object
     *
     * @return void
     */
    public static function saveImages($data, $topic)
    {
        foreach ($data['images'] as $image ) {
            TopicImage::create(
                [
                    'image_url' => uploadSingleImage($image),
                    'topic_id' => $topic->id,
                ]
            );
        }
    }
}
