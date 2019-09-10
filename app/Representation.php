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
        'slug',
        'email',
        'address',
        'phone',
        'mobile',
        'website',
        'short_desc',
        'description',
        'photo_id',
        'logo_id',
        'logo_small_id',
        'city_id',
        'category_id',
        'isRepresentation'
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

    /**
     * Relationship to city
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function city()
    {
        return $this->belongsTo(City::class);
    }

    /**
     * Relationship to projects
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function projects()
    {
        return $this->hasMany(Project::class);
    }

}
