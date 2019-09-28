<?php

namespace App;

use App\Notifications\UserRegistered;
use Illuminate\Support\Facades\Notification;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Foundation\Auth\RegistersUsers;
use Spatie\Activitylog\Traits\CausesActivity;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Permission\Traits\HasRoles;


class User extends Authenticatable
{
    use HasApiTokens, Notifiable, HasRoles, LogsActivity, CausesActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'type', 'bio', 'photo'
    ];

    protected static $logFillable = true;

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Relationship to projects
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    /**
     * Relationship to projects details
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function projectdets()
    {
        return $this->hasMany(ProjectDet::class);
    }

    /**
     * Relationship to projects
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function meetings()
    {
        return $this->hasMany(Meeting::class);
    }

    /**
     * Relationship to projects details
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function meetingdets()
    {
        return $this->hasMany(MeetingDet::class);
    }
    /**
     * Relationship to projects details
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function todos()
    {
        return $this->hasMany(ToDo::class);
    }
}
