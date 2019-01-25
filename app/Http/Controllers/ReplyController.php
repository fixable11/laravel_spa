<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reply;
use App\Models\Question;
use App\Http\Resources\ReplyResource;

class ReplyController extends Controller
{

    public function __construct()
    {
        $this->middleware('jwt')->except(['index', 'show']);
    }

    /**
     * Display a listing of the resource.
     * 
     * @param  App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function index(Question $question)
    {
        return ReplyResource::collection($question->replies);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Models\Question  $question
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Question $question, Request $request)
    {
        $reply = $question->replies()->create($request->all());

        return response([
            'reply' => new ReplyResource($reply),
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  App\Models\Question  $question
     * @param  App\Models\Reply  $reply
     * @return \Illuminate\Http\Response
     */
    public function show(Question $question, Reply $reply)
    {
        $reply = $question
            ->replies()
            ->where('question_id', $reply->question_id)
            ->first();
        
        return new ReplyResource($reply);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Models\Question  $question
     * @param  App\Models\Reply  $reply
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Question $question, Reply $reply, Request $request)
    {
        $reply = $reply->where([
            'question_id' => $question->id,
            'id' => $reply->id
        ])->first();
        
        $reply->update($request->all());

        return response([
            'reply' => new ReplyResource($reply)
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  App\Models\Question  $question
     * @param  App\Models\Reply  $reply
     * @return \Illuminate\Http\Response
     */
    public function destroy(Question $question, Reply $reply)
    {
        $question->replies()->where('id', $reply->id)->delete();
        
        return response(null, 204);
    }
}
