<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'photo_id',
        'description',
        'body'
    ];

    /**
     * Relationship to product details
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function productdets()
    {
        return $this->hasMany(ProductDet::class);
    }
}
