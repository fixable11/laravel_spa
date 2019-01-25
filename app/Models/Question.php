<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function($question){
            $question->slug = str_slug($question->title);
        });
    }

    /**
     * Attributes for mass assignment
     *
     * @var array
     */
    protected $fillable = ['title', 'slug', 'body', 'category_id', 'user_id'];

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

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
     * Question belongs to a category
     *
     * @return App\Models\Category
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function getPathAttribute()
    {
        return "/questions/$this->slug";
    }
}
