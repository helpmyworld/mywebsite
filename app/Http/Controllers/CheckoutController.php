<?php

namespace App\Http\Controllers;
error_reporting(E_ALL);
use App\Order;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use DateTime;

use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;


/** All Paypal Details class **/
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;
use Redirect;
use Session;
use URL;


class CheckoutController extends Controller
{
    private $_api_context;
//    public function step1()
//    {
//        if (Auth::check()) {
//            return redirect()->route('checkout.shipping');
//        }
//
//        return redirect('login');
//    }

//    public function shipping()
//    {
//        if(Cart::count()==0)
//        {
//            return redirect()->route('home1');
//        }
//        return view('front.shipping-info');
//    }
//
//    public function payment()
//    {
//        if(Cart::count()==0)
//        {
//            return redirect()->route('home1');
//        }
//        else
//        {
//            //$ad = DB::table('addresses')->where('user_id', 5)->orderBy('id','DESC')->first();
//            $add=Auth::user()->address()->orderBy('id','DESC')->first();
//            $cartItems=Cart::content();
//            return view('front.payment',compact('cartItems'))->with('address',$add);
//        }
//
//    }
    public function __construct()
    {

        /** PayPal api context **/
        $paypal_conf = \Config::get('paypal');
        $this->_api_context = new ApiContext(new OAuthTokenCredential(
                $paypal_conf['client_id'],
                $paypal_conf['secret'])
        );
        $this->_api_context->setConfig($paypal_conf['settings']);

    }

    public function storePayment(Request $request)
    {

        require 'App/start.php';
//        $product="Rorisang-book-purchase";
//        $price=1.5;

        $payer = new Payer();
        $payer->setPaymentMethod('paypal');

        $item_1 = new Item();

        $item_1->setName('Item 1') /** item name **/
        ->setCurrency('USD')
            ->setQuantity(1)
            ->setPrice($request->get('amount')); /** unit price **/

        $item_list = new ItemList();
        $item_list->setItems(array($item_1));

        $amount = new Amount();
        $amount->setCurrency('USD')
            ->setTotal($request->get('amount'));

        $transaction = new Transaction();
        $transaction->setAmount($amount)
            ->setItemList($item_list)
            ->setDescription('Your transaction description');

        $redirect_urls = new RedirectUrls();
        $redirect_urls->setReturnUrl(URL::to('status')) /** Specify return URL **/
        ->setCancelUrl(URL::to('status'));

        $payment = new Payment();
        $payment->setIntent('Sale')
            ->setPayer($payer)
            ->setRedirectUrls($redirect_urls)
            ->setTransactions(array($transaction));
        /** dd($payment->create($this->_api_context));exit; **/
        try {

            $payment->create($this->_api_context);

        } catch (\PayPal\Exception\PPConnectionException $ex) {

            if (\Config::get('app.debug')) {

                \Session::put('error', 'Connection timeout');
                return Redirect::to('/');

            } else {

                \Session::put('error', 'Some error occur, sorry for inconvenient');
                return Redirect::to('/');

            }

        }

        foreach ($payment->getLinks() as $link) {

            if ($link->getRel() == 'approval_url') {

                $redirect_url = $link->getHref();
                break;

            }

        }

        /** add payment ID to session **/
        Session::put('paypal_payment_id', $payment->getId());

        if (isset($redirect_url)) {

            /** redirect to paypal **/
            return Redirect::away($redirect_url);

        }

        \Session::put('error', 'Unknown error occurred');
        return Redirect::to('/');

    }
    public function processPaypalResult(Request $request)
    {
        if(Cart::count()==0)
        {
            return redirect()->route('home1');
        }
        $success=$request['success'];

        if(strcmp($success,"true")==0)
        {
            require 'app/start.php';
            $paymentId=$request['paymentId'];
            $payerId=$request['PayerID'];
            $payment=  \PayPal\Api\Payment::get($paymentId,$paypal);
            $execute=new \PayPal\Api\PaymentExecution();
            $execute->setPayerId($payerId);

            try
            {
                $result=$payment->execute($execute,$paypal);
                Order::createOrder();
                Cart::destroy();
                //echo "Payment successful, thanks<br/>";
                return view('cart.paytrue')->with('msg','Payment successful, thanks.');
            }
            catch (Exception $exc)
            {
                return view('cart.payfalse')->with('msg','Payment failed.');
            }
        }
        else
        {
            return view('cart.payfalse')->with('msg','Payment failed.');
        }
    }

    public function order_cancel()
    {
        $add=Auth::user()->address()->orderBy('id','DESC')->first();
        $add->delete();
        Cart::destroy();
        return redirect()->route('home1');
    }

    private function convertCurrency($inCurrency,$amnt,$outCurrency)
    {
        $endpoint = 'live';
        $access_key = 'e33cb8bce07f8b977bdb2ca2fff7771c';

        $inCode="USD".$inCurrency;
        $outCode="USD".$outCurrency;

        $inRow = DB::table('currencies')->where('code', $inCode)->first();
        $outRow = DB::table('currencies')->where('code', $outCode)->first();

        $USD_value=$amnt/$inRow->USDconversion;
        $converted_value=$USD_value*$outRow->USDconversion;

        //echo "Converted amount is:".number_format( $converted_value, 2)."<br/>";
        return number_format( $converted_value, 2);
    }


    private function checkAndUpdateCurrencies()
    {
        $testRow = DB::table('currencies')->where('code', 'USDZAR')->first();      //no reason for USDZAR,any code could have worked.
        if(is_null($testRow))
        {
            while(is_null($testRow))
            {
                $this->loadCurrenciesOnce();
                $testRow = DB::table('currencies')->where('code', 'USDZAR')->first();      //no reason for USDZAR,any code could have worked.
            }
        }

        $testRowTime = strtotime($testRow->updated_at);

        $dt = new DateTime();
        $currentTime=$dt->getTimestamp();

        $difference=$currentTime-$testRowTime;

        //echo "<br/>testRowTime:".$testRowTime."<br/>";
        //echo "Now:".$currentTime."<br/>";
        //echo "Difference:".$difference."<br/>";

        if($difference>=3600)
        {
            $this->updateCurrencies();
        }
        //read USDZAR row
        //check if we got it from the database,if not then call loadCurrenciesOnce()
        //compare its time and now
        //if now() time is greater than old time by one hour
        //call updateCurrencies

    }

    private function updateCurrencies()
    {
        $endpoint = 'live';
        $access_key = 'e33cb8bce07f8b977bdb2ca2fff7771c';

        do
        {
            echo "Transferring you to PayPal, please ensure that you have a working internet connection.<br/>";
            $ch = curl_init('http://apilayer.net/api/'.$endpoint.'?access_key='.$access_key.'');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $json = curl_exec($ch);
            curl_close($ch);

            $exchangeRates = json_decode($json, true);
            if(!is_null($exchangeRates))
            {
                try
                {
                    foreach ($exchangeRates['quotes'] as $code=>$val)
                    {
                        $dt = new DateTime();
                        DB::table('currencies')
                            ->where('code', $code)
                            ->update(['USDconversion' => $val,'updated_at'=>$dt->format('Y-m-d H:i:s')]);
                    }
                }
                catch(Exception $e)
                {
                    //
                }
            }
        }
        while (is_null($exchangeRates));


    }

    private function loadCurrenciesOnce()
    {
        $endpoint = 'live';
        $access_key = 'e33cb8bce07f8b977bdb2ca2fff7771c';

        do
        {
            echo "Transferring you to PayPal, please ensure that you have a working internet connection.<br/>";
            $ch = curl_init('http://apilayer.net/api/'.$endpoint.'?access_key='.$access_key.'');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $json = curl_exec($ch);
            curl_close($ch);

            $exchangeRates = json_decode($json, true);
            if(!is_null($exchangeRates))
            {
                try
                {
                    foreach ($exchangeRates['quotes'] as $code=>$val)
                    {
                        $dt = new DateTime();
                        $id = DB::table('currencies')->insertGetId(
                            ['code' => $code, 'USDconversion' => $val,'created_at'=>$dt->format('Y-m-d H:i:s'),'updated_at'=>$dt->format('Y-m-d H:i:s')]
                        );
                    }
                }
                catch(Exception $e)
                {
                    //
                }
            }
        }
        while (is_null($exchangeRates));
    }
}
