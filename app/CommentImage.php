<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CommentImage extends Model
{
    public $fillable = [
        'image_url', 'comment_id'
    ];

    /**
     * CommentImage belongs to a comment
     *
     * @return object
     */
    public function comment()
    {
        return $this->belongsTo(Comment::class);
    }
}
