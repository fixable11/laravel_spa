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

    public function like(Question $question, Reply $reply)
    {
        $reply->like()->create([
            'user_id' => auth()->id()
        ]);

        broadcast(new LikeEvent($reply->id, 1))->toOthers();
    }

    public function unlike(Question $question, Reply $reply)
    {
        $reply->like()->where([
            'user_id' => auth()->id()
        ])->first()
          ->delete();
        
        broadcast(new LikeEvent($reply->id, 0))->toOthers();
    }
}
