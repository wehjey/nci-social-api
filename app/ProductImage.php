<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    public $fillable = [
        'image_url', 'product_id'
    ];

    /**
     * Image belongs to product
     *
     * @return object
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
