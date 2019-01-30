<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{   

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();
    }

    /**
     * Attributes for mass assignment
     *
     * @var array
     */
    protected $fillable = ['body', 'user_id'];

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
    public function likes()
    {
        return $this->hasMany(Like::class);
    }
}
