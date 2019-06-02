<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AboutDet extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'about_id',
        'caption',
        'description'
    ];

    /**
     * Relationship to about
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function about()
    {
        return $this->belongsTo(About::class);
    }
}
