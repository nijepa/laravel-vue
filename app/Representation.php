<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class Representation extends Model
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'address',
        'website',
        'short_desc',
        'description',
        'photo_id',
        'logo_id',
        'logo_small_id'
    ];

    /**
     * Relationship to representation details
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function repdets()
    {
        return $this->hasMany(RepDet::class);
    }

}
