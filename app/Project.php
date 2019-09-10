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
        'description',
        'project_started',
        'user_id',
        'doc_id',
        'representation_id',
        'finished'
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

    /**
     * Relationship to company
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function representation()
    {
        return $this->belongsTo(Representation::class);
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
