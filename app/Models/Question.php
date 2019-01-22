<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{

    /**
     * Question belongs to user
     *
     * @return App\Models\User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Question has many replies
     *
     * @return App\Models\Reply
     */
    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    /**
     * Question belongs to category
     *
     * @return App\Models\Category
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
