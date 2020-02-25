<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Topic;
use Illuminate\Http\Request;
use App\Http\Requests\CommentRequest;

class CommentController extends Controller
{

    /**
     * Returns all comments for a topic
     *
     * @param Topic $topic
     * 
     * @return \Illuminate\Http\Response
     */
    public function index(Topic $topic)
    {
        $comments = Comment::where('topic_id', $topic->id)->paginate(perPage());
        return resourceResponse($comments, 'Comments returned successfully', 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CommentRequest $request, Topic $topic)
    {
        $comment = Comment::addNew($request->only(['description', 'images']), $topic);
        return resourceCreatedResponse($comment, 'Comment created successfully', 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function show(Comment $comment)
    {
        return resourceCreatedResponse($comment, 'Comment returned successfully', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
        if ($comment->user_id != auth()->id()) {
            return errorResponse(401, 'Permission denied');
        }

        $comment->delete();

        return resourceCreatedResponse([], 'Comment deleted successfully', 200);
    }
}
