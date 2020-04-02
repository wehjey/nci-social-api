<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;
use App\Http\Requests\OrderRequest;
use App\Product;
use App\Transaction;
use App\Libraries\Payment;

class ProductController extends Controller
{

    /**
     * Get all products
     *
     * @return json
     */
    public function index()
    {
        $products = Product::query();

        // Check if filter exists to list products by created user only
        if (request()->has('type') && request()['type'] == 'owner') {
            $products->where('user_id', auth()->id());
        } else {
            $products->where('quantity', '>', 0);
        }

        $products = $products->orderBy('id', 'desc')->with('category')->withCount('transactions')->paginate(perPage());
        return resourceResponse($products, 'Products returned successfully', 200);
    }

    /**
     * Create product
     *
     * @param ProductRequest $request
     * @return json
     */
    public function create(ProductRequest $request)
    {
        $topic = Product::addNew($request->only(['name', 'description', 'price', 'quantity', 'category_id', 'images']));
        return resourceCreatedResponse($topic, 'Product created successfully', 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return resourceCreatedResponse($product->load('category'), 'Product returned successfully', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        if ($product->user_id != auth()->id()) {
            return errorResponse(401, 'Permission denied');
        }
        $product->delete();
        return resourceCreatedResponse([], 'Product deleted successfully', 200);
    }

    /**
     * Prodct orders
     *
     * @return void
     */
    public function order(OrderRequest $request)
    {
        $transaction = Transaction::addNew($request->only('product_id', 'quantity'));

        $data = [
            'amount' => $transaction->price,
            'email' => auth()->user()->email,
            'metadata' => [
                'transaction_ref' => $transaction->reference
            ]
        ];

        // Make API call to get payment url
        $response = Payment::make($data);

        if (!$response['status']) {
            return errorResponse(500, $request['error']);
        }

        return resourceCreatedResponse($response['payment_url'], 'Payment URL for purchase', 200);
    }

    /**
     * Get all products bought
     *
     * @return void
     */
    public function myOrders()
    {
        $trans = Transaction::where('buyer_id', auth()->id())
        ->where('status', 'paid')
        ->orderBy('id', 'desc')
        ->with('product')
        ->with('user')
        ->get();
        return resourceCreatedResponse($trans, 'Orders return successfully', 200);
    }

    /**
     * Get all products sold
     *
     * @return void
     */
    public function mySales()
    {
        $trans = Transaction::where('user_id', auth()->id())
        ->where('status', 'paid')
        ->orderBy('id', 'desc')
        ->with('buyer')
        ->with('product')->get();
        return resourceCreatedResponse($trans, 'Sales return successfully', 200);
    }

    public function getCategoryProducts($category_id)
    {
        if(!isset($category_id)) {
            return errorResponse(404, 'Please select category');
        }

        $products = Product::where('quantity', '>', 0)
        ->where('category_id', $category_id)
        ->orderBy('id', 'desc')
        ->with('category')->withCount('transactions')->paginate(perPage());
        return resourceResponse($products, 'Products returned successfully', 200);
    }
}
