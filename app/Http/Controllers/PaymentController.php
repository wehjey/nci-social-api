<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Libraries\Payment;
use App\Transaction;
use App\Product;

class PaymentController extends Controller
{
    /**
     * Handle callback from payment gateway
     *
     * @return void
     */
    public function gatewayCallback()
    {
        $reference = isset(request()['reference']) ? request()['reference'] : '';

        if (!$reference) {
            return errorResponse(200, 'No reference code from payment gateway');
        }

        $response = Payment::handleGatewayCallback($reference);

        if (!$response['status']) {
            return errorResponse(200, $response['error']);
        }

        $transaction = Transaction::where('reference', $response['transaction_ref'])->where('status', 'pending')->first();

        if (!$transaction) {
            return errorResponse(404, 'Transaction not found');
        }

        // Update transaction to paid
        // Add payment reference
        $transaction->status = 'paid';
        $transaction->payment_reference = $response['payment_reference'];
        $transaction->save();
        
        // Reduce product quantity
        $product = Product::find($transaction->product_id);
        $product->quantity = $product->quantity - $transaction->quantity;
        $product->save();

        return resourceCreatedResponse([], 'Order completed successfully', 200);
    }

}
