<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 9/10/18
 * Time: 3:35 PM
 */

namespace App\Services;

use GuzzleHttp\Client;

class PayfastAPI
{
    public $client;
    public $merchant_id;
    public $merchant_key;
    public $subscription_passphrase;
    public $domain;
    public $token;
    public function __construct($token)
    {
        $this->merchant_id = env('PAYFAST_MERCHANT_ID');
        $this->merchant_key = env('PAYFAST_MERCHANT_KEY');
        $this->subscription_passphrase = env('PAYFAST_SUBSCRIPTION_PASSPHRASE');
        $this->client = new Client(['verify' => true]);
        $this->domain = 'https://api.payfast.co.za';
        $this->token = $token;
    }


    public function getHeader()
    {
        $hashArray = array(
            'merchant-id' => $this->merchant_id,
            'version' => 'v1',
            'timestamp' => date('Y-m-d') . 'T' . date('H:i:s')
        );

        $pfData = $hashArray;

        //construct variables
        foreach ($pfData as $key => $val) {
            $pfData[$key] = stripslashes(trim($val));
        }
        //Add passphrase
        $pfData['passphrase'] = stripslashes(trim($this->subscription_passphrase));

        ksort($pfData);

        //conver pData to url parameter
        $pfParamString = '';
        foreach ($pfData as $key => $val) {
            $pfParamString .= $key . '=' . urlencode($val) . '&';
        }

        //remove last &
        $pfParamString = substr($pfParamString, 0, -1);

        //generate md5 signature
        $signature = md5($pfParamString);

        $hashArray['signature'] = $signature;

        return $hashArray;
    }

    public function test()
    {
        //ssdd($this->getHeader());
        //return $this->getEndpoint().'lists';
        $response = $this->client->get($this->domain.'/ping?testing=true', [
            'headers' => $this->getHeader(),
        ]);

        return $response;
    }

    public function cancel()
    {

        //return $this->getEndpoint().'lists';
        $response = $this->client->put($this->getEndpoint().'/cancel?testing=true', [
            'headers' => $this->getHeader(),
        ]);

        return $response;
    }


    public function getEndpoint()
    {
        $string = $this->domain.'/subscriptions/'.$this->token;
        return $string;

    }                                             

}