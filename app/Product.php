<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\ProductImage;

class Product extends Model
{

    public $fillable = [
        'name', 'description', 'price', 'quantity', 'category_id', 'user_id', 'status'
    ];

    protected $with = [
        'images'
    ];

    /**
     * A product belongs to a user
     *
     * @return object
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * A product belongs to a category
     *
     * @return object
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Product has many images
     *
     * @return object
     */
    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    /**
     * Create new product
     *
     * @param [type] $data
     * @return void
     */
    public static function addNew($data)
    {
        $product = self::create(
            [
                'name' => $data['name'],
                'description' => $data['description'],
                'price' => $data['price'],
                'quantity' => $data['quantity'],
                'category_id' => $data['category_id'],
                'user_id' => auth()->id()
            ]
        );
        // Save images if user uploaded
        if (isset($data['images'])) {
            self::saveImages($data, $product);
        }
        return $product;
    }

    /**
     * Save product images to cloudinary API
     * 
     * @param array  $data  Request data
     * @param object $product Newly created product object
     *
     * @return void
     */
    public static function saveImages($data, $product)
    {
        foreach ($data['images'] as $image ) {
            ProductImage::create(
                [
                    'image_url' => uploadSingleImage($image),
                    'product_id' => $product->id,
                ]
            );
        }
    }
}
