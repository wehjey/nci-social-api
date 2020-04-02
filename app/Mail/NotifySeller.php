<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NotifySeller extends Mailable
{
    use Queueable, SerializesModels;

    public $product;
    public $transaction;
    public $seller;
    public $buyer;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($product,$transaction, $seller, $buyer)
    {
        $this->product = $product;
        $this->transaction = $transaction;
        $this->seller = $seller;
        $this->buyer = $buyer;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.seller')
                    ->subject('Product');
    }
}
