<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Spatie\Activitylog\Traits\CausesActivity;
use Spatie\Activitylog\Traits\LogsActivity;

class Meeting extends Model
{
    use Notifiable, LogsActivity, CausesActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
        'meeting_started',
        'user_id',
        'doc_id',
        'representation_id',
        'city_id',
        'finished'
    ];

    protected static $logFillable = true;

    /**
     * Relationship to project details
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function meetingdets()
    {
        return $this->hasMany(MeetingDet::class);
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

    /**
     * Relationship to company
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function city()
    {
        return $this->belongsTo(City::class);
    }
}
