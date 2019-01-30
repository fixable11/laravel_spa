<?php

namespace App\Http\Controllers;

use App\Model\Like;
use Illuminate\Http\Request;
use App\Models\Reply;
use App\Models\Question;
use App\Events\LikeEvent;

class LikeController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('jwt');
    }
    
    /**
     * Likes specific reply
     *
     * @param Question $question
     * @param Reply $reply
     * @return void
     */
    public function like(Question $question, Reply $reply)
    {
        $reply->likes()->create([
            'user_id' => auth()->id()
        ]);

        broadcast(new LikeEvent($reply->id, 1))->toOthers();
    }

    /**
     * Unlikes specific reply
     *
     * @param Question $question
     * @param Reply $reply
     * @return void
     */
    public function unlike(Question $question, Reply $reply)
    {
        $reply->likes()->where([
            'user_id' => auth()->id()
        ])->first()
          ->delete();
        
        broadcast(new LikeEvent($reply->id, 0))->toOthers();
    }
}
