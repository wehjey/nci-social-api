<?php

namespace App\Http\Controllers;

use App\Topic;
use App\Http\Requests\TopicRequest;

class TopicController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $topics = Topic::query();
        // Check if filter exists to list topics by created user only
        if (request()->has('type') && request()['type'] == 'owner') {
            $topics->where('user_id', auth()->id());
        }
        $topics = $topics->orderBy('id', 'desc')->with('user')->withCount('comments')->paginate(perPage());
        return resourceResponse($topics, 'Topics returned successfully', 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TopicRequest $request)
    {
        $topic = Topic::addNew($request->only(['title', 'description', 'images']));
        return resourceCreatedResponse($topic, 'Topic created successfully', 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Topic  $topic
     * @return \Illuminate\Http\Response
     */
    public function show(Topic $topic)
    {
        return resourceCreatedResponse($topic->load('user')->loadCount('comments'), 'Topic returned successfully', 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Topic  $topic
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Topic $topic)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Topic  $topic
     * @return \Illuminate\Http\Response
     */
    public function destroy(Topic $topic)
    {
        if ($topic->user_id != auth()->id()) {
            return errorResponse(401, 'Permission denied');
        }

        $topic->delete();

        return resourceCreatedResponse([], 'Topic deleted successfully', 200);
    }
}
