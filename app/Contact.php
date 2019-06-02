<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'photo_id',
        'email',
        'facebook',
        'twitter',
        'whatsapp',
        'phone',
        'viber',
        'skype'
    ];
}
