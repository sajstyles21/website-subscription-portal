<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserWebsite extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'website_id', 'user_id',
    ];

    public function website()
    {
        return $this->belongsTo('App\Website', 'website_id');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
}
