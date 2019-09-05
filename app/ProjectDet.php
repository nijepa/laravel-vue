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
        'title',
        'company_id',
        'caption',
        'project_added',
        'user_id',
        'note',
        'user_id'
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
}
