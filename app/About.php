<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class About extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'body'
    ];

    /**
     * Relationship to about details
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function aboutdets()
    {
        return $this->hasMany(AboutDet::class);
    }
}
