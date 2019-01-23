<?php

namespace App\Http\Controllers;

use App\Model\Like;
use Illuminate\Http\Request;
use App\Models\Reply;

class LikeController extends Controller
{

    public function __construct()
    {
        $this->middleware('jwt');
    }

    public function like(Reply $reply)
    {
        $reply->like()->create([
            //'user_id' => auth()->id()
            'user_id' => 1
        ]);
    }

    public function unlike(Reply $reply)
    {
        $reply->like()->where([
            //'user_id' => auth()->id()
            'user_id' => 1,
        ])->first()
          ->delete();
            
    }
}
