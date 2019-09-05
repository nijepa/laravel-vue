<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'company_id',
        'description',
        'project_started',
        'user_id'
    ];

    /**
     * Relationship to project details
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function projectdets()
    {
        return $this->hasMany(ProjectDet::class);
    }
}
