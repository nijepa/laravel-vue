<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RepDet extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'rep_id',
        'title',
        'doc_id'
    ];

    /**
     * Relationship to representation
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function representation()
    {
        return $this->belongsTo(Representation::class);
    }
}
