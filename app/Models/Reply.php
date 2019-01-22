<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{   

    /**
     * Reply belongs to question
     *
     * @return App\Models\Question
     */
    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    /**
     * Reply belongs to user
     *
     * @return App\Models\User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Reply has many likes
     *
     * @return App\Models\Like
     */
    public function like()
    {
        return $this->hasMany(Like::class);
    }
}
