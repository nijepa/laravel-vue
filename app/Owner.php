<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Owner extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'photo_id',
        'logo_id',
        'address',
        'email',
        'facebook',
        'twitter',
        'whatsapp',
        'phone',
        'viber',
        'skype',
        'fax',
        'linkedin'
    ];
}
