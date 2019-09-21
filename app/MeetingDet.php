<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Spatie\Activitylog\Traits\CausesActivity;
use Spatie\Activitylog\Traits\LogsActivity;

class MeetingDet extends Model
{
    use Notifiable, LogsActivity, CausesActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'caption',
        'meeting_id',
        'representation_id',
        'date_added',
        'user_id',
        'note',
        'doc_id',
        'finished'
    ];

    protected static $logFillable = true;

    /**
     * Relationship to project
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function meeting()
    {
        return $this->belongsTo(Meeting::class);
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
