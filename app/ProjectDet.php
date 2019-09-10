<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProjectDet extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'caption',
        'project_id',
        'date_added',
        'user_id',
        'note',
        'doc_id',
        'finished'
    ];

    /**
     * Relationship to project
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

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
