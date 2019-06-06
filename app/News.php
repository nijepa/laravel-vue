<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class News extends Model
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'body',
        'news_date',
        'pic_id'
    ];

    /**
     * Relationship to cities
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function news_det()
    {
        return $this->hasMany(News_det::class);
    }
}
