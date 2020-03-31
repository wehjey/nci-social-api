<?php

namespace App\Libraries;

/**
 * Payment integration library for paystack
 */
class Payment
{

    /**
     * Initialize payment
     *
     * @return array
     */
    public static function make($data)
    {
        $curl = curl_init();
        $sk = config('app.ps_secret'); // Paystack secret key
        $url = config('app.ps_url'); // Paystack payment url

        curl_setopt_array($curl, 
            [
              CURLOPT_URL => "{$url}/transaction/initialize",
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_CUSTOMREQUEST => "POST",
              CURLOPT_POSTFIELDS => json_encode([
                  'amount' => $data['amount'].'00', // Fix kobo by adding 00
                  'email' => $data['email'],
                  'metadata' => $data['metadata']
              ]),
              CURLOPT_HTTPHEADER => [
                  "authorization: Bearer {$sk}", //replace this with your own test key
                  "content-type: application/json",
                  "cache-control: no-cache"
              ],
            ]
        );

        $response = curl_exec($curl);
        $err = curl_error($curl);

        if ($err) {
            // there was an error contacting the Paystack API
            return [
              'status' => false,
              'error' => $err
            ];
        }

        $tranx = json_decode($response, true);

        if (!$tranx['status']) {
            // there was an error from the API
            return [
              'status' => false,
              'error' => $tranx['message']
            ];
        }

        return [
          'status' => true,
          'payment_url' => $tranx['data']['authorization_url']
        ];
    }

    /**
     * Handle gateway callback to verify transaction
     *
     * @param [type] $reference
     * @return void
     */
    public static function handleGatewayCallback($reference)
    {
        $curl = curl_init();
        $sk = config('app.ps_secret'); // Paystack secret key
        $url = config('app.ps_url'); // Paystack payment url

        curl_setopt_array($curl, 
            [
              CURLOPT_URL => "{$url}/transaction/verify/" . rawurlencode($reference),
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_HTTPHEADER => [
                  "accept: application/json",
                  "authorization: Bearer {$sk}",
                  "cache-control: no-cache"
              ],
            ]
        );

        $response = curl_exec($curl);
        $err = curl_error($curl);

        if ($err) {
            // there was an error contacting thereturn [
            return [
              'status' => false,
              'error' => $err
            ];
        }

        $tranx = json_decode($response);

        if (!$tranx->status) {
            // there was an error from the API
            return [
                'status' => false,
                'error' => $tranx->message
            ];
        }

        if ('success' == $tranx->data->status) {
            // transaction was successful...
            // please check other things like whether you already gave value for this ref
            // if the email matches the customer who owns the product etc
            // Give value

            $transaction_ref = $tranx->data->metadata->transaction_ref;
            return [
                'status' => true,
                'transaction_ref' => $transaction_ref,
                'payment_reference' => $reference
            ];
        }
    }
}
