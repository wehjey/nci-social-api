<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\CommentImage;

class Comment extends Model
{
    public $fillable = [
        'description', 'topic_id', 'user_id'
    ];

    protected $with = [
        'images'
    ];

    /**
     * Comment belongs to a topic
     *
     * @return object
     */
    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }

    /**
     * Comment belongs to a user
     *
     * @return object
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Comment can have many images
     *
     * @return object
     */
    public function images()
    {
        return $this->hasMany(CommentImage::class);
    }

    /**
     * Add new comment for topic
     *
     * @param array  $data  'description'
     * @param object $topic Topic for comment
     * 
     * @return void
     */
    public static function addNew($data, $topic)
    {
        $comment = self::create(
            [
                'description' => $data['description'],
                'topic_id' => $topic->id,
                'user_id' => auth()->id()
            ]
        );

        // Save images if user uploaded
        if (isset($data['images'])) {
            self::saveImages($data, $comment);
        }
        return $comment;
    }

    /**
     * Save comment images to cloudinary API
     * 
     * @param array  $data    Request data
     * @param object $comment Newly created topic object
     *
     * @return void
     */
    public static function saveImages($data, $comment)
    {
        foreach ($data['images'] as $image ) {
            CommentImage::create(
                [
                    'image_url' => uploadSingleImage($image),
                    'comment_id' => $comment->id,
                ]
            );
        }
    }
}
