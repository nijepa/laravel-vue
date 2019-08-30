<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductDet extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'photo_id',
        'description'
    ];

    /**
     * Relationship to product
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
