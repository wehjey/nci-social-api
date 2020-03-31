<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /**
     * A category has many products
     *
     * @return collection
     */
    public function products() 
    {
        return $this->hasMany(Product::class);
    }
}
