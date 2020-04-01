<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderMail extends Mailable
{
    use Queueable, SerializesModels;

    public $product;
    public $transaction;
    public $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($product,$transaction,$user)
    {
        $this->product = $product;
        $this->transaction = $transaction;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.order')
                    ->subject('Order completed');
    }
}
