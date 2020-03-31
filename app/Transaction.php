<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Product;

class Transaction extends Model
{

    public $fillable = [
        'user_id', 'product_id', 'buyer_id', 'price', 'unit_price', 'quantity', 'reference', 'payment_reference', 'status'
    ];

    /**
     * Belongs to a user
     *
     * @return object
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Belongs to a buyer also a user
     *
     * @return object
     */
    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }

    /**
     * Belongs to a product
     *
     * @return object
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Create new transaction for product
     *
     * @param array $data
     * @return object
     */
    public static function addNew($data)
    {
        $product = Product::find($data['product_id']);

        return self::create(
            [
                'buyer_id' => auth()->id(), // Logged in user making order
                'user_id' => $product->user_id,
                'product_id' => $product->id,
                'price' => $product->price * $data['quantity'],
                'unit_price' => $product->price,
                'quantity' => $data['quantity'],
                'reference' => generateRandomString(6).date('YmdHisu'),
                'status' => 'pending'
            ]
        );
    }
}
