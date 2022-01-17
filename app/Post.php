<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'website_id', 'title', 'description',
    ];

    public function website()
    {
        return $this->belongsTo('App\Website', 'website_id');
    }

    public function post_email()
    {
        return $this->hasOne('App\PostEmail', 'post_id', 'id');
    }
}
