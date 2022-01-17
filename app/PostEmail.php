<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostEmail extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'post_id', 'status',
    ];

    public function post()
    {
        return $this->belongsTo('App\Post', 'post_id');
    }
}
