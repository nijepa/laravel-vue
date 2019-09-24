<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ToDo extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'priority', 'completed', 'user_id'
    ];

    /**
     * Relationship to user
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
