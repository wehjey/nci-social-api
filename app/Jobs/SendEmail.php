<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\User;
use App\Mail\OrderMail;
use App\Mail\NotifySeller;

class SendEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $product;
    public $transaction;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($product,$transaction)
    {
        $this->product = $product;
        $this->transaction = $transaction;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $user = User::find($this->transaction->buyer_id);
        $seller = User::find($this->transaction->user_id);
        Mail::to($user->email)->send(new OrderMail($this->product, $this->transaction, $user));
        Mail::to($seller->email)->send(new NotifySeller($this->product, $this->transaction, $seller, $buyer));
    }
}
