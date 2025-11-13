<?php

namespace App\Http\Controllers\Author;

use App\Administrator;
use App\Benefit;
use App\ElectronicSubscriptionDocument;
use App\ManuscriptOrder;
use App\Services\PayfastAPI;
use App\Order;
use App\OrderProduct;
use App\Subscription;
use App\SubscriptionCategory;
use App\SubscriptionIndustry;
use App\User;
use App\Role;
use App\UserSubscription;
use Carbon\Carbon;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;


class SubscriptionController extends Controller
{
    public $imageUploader;

    public function __construct() {
        $this->middleware('auth')->except(['itn']);
    }

    public function browse(Request $request)
    {
        $subscriptions = Subscription::all();
        $benefits = Benefit::all();

        return view('author.subscription.browse',compact('subscriptions','benefits'));
    }

    public function index(Request $request)
    {
        $subscriptions = UserSubscription::where('user_id',auth()->id())->get();

        return view('author.subscription.index',compact('subscriptions'));
    }

    public function billing(Request $request)
    {

        return view('author.subscription.billing');
    }

    public function success(Request $request)
    {

        return view('author.subscription.success');
    }

    public function cancel(Request $request)
    {

        return view('author.subscription.cancel');
    }

    public function store(Request $request)
    {

        $user = auth()->user();

        $subscription = Subscription::findOrFail($request->subscription_id);

        $order = new ManuscriptOrder();
        $order->user_id = $user->id;
        $order->subscription_id = $subscription->id;

        //$order->payment_method = $request->input('payment_method');
        $order->date_purchased = date("Y-m-d H:i:s");
        $order->order_type = 'Subscription';
        $order->order_cost = $subscription->price;
        $order->subscription_start_date = date("Y-m-d");

        $order->save();

        $data = new \stdClass();
        $data->order_id = $order->id;
        $data->order_cost = $order->order_cost;
        $data->item_name = $subscription->title;
        $data->subscription_id = $request->subscription_id;
        $data->next_subscription_billing_date = $order->start_date;

        return response()->json($data);
    }

    public function itn(Request $request)
    {

        header( 'HTTP/1.0 200 OK' );

        ob_flush();
        flush();

        //dd($request);
        Storage::disk('public')->put('test.html', (string)$request);
        $order = ManuscriptOrder::findOrFail($request->m_payment_id);

        $output = 'Error:';

        define( 'SANDBOX_MODE', false );
        $pfHost = SANDBOX_MODE ? 'sandbox.payfast.co.za' : 'www.payfast.co.za';

       // dd($pfHost);
        // Posted vdariables from ITN
        $pfData = $request->all();

        // Strip any slashes in data
        foreach( $pfData as $key => $val )
        {
            $pfData[$key] = stripslashes( $val );
        }


        // Construct variables
        $pfParamString = '';
        foreach( $pfData as $key => $val )
        {
            if( $key != 'signature' )
            {
                $pfParamString .= $key .'='. urlencode( $val ) .'&';
            }
        }

        // Remove the last '&' from the parameter string
        $pfParamString = substr( $pfParamString, 0, -1 );
        $pfTempParamString = $pfParamString;
        // Passphrase stored in website database
        $passPhrase = env('PAYFAST_SUBSCRIPTION_PASSPHRASE');

        if( !empty( $passPhrase ) )
        {
            $pfTempParamString .= '&passphrase='.urlencode( $passPhrase );
        }
        $signature = md5( $pfTempParamString );

        if($signature!=$pfData['signature'])
        {
            $output .= 'Invalid Signature';
        }


        // Variable initialization
        $validHosts = array(
            'www.payfast.co.za',
            'sandbox.payfast.co.za',
            'w1w.payfast.co.za',
            'w2w.payfast.co.za',
        );

        $validIps = array();

        foreach( $validHosts as $pfHostname )
        {
            $ips = gethostbynamel( $pfHostname );
            if( $ips !== false )
            {
                $validIps = array_merge( $validIps, $ips );
            }
        }

        // Remove duplicates
        $validIps = array_unique( $validIps );

        if( !in_array( $_SERVER['REMOTE_ADDR'], $validIps ) )
        {
            $output .= 'Source IP not Valid';
        }

        $cartTotal = $order->order_cost; // This amount needs to be sourced from your application
        if( abs( floatval( $cartTotal ) - floatval( $pfData['amount_gross'] ) ) > 0.01 )
        {
            $output .= 'Amounts Mismatch';
        }

        // Variable initialization
        $url = 'https://'. $pfHost .'/eng/query/validate';

        // Create default cURL object
        $ch = curl_init();

        // Set cURL options - Use curl_setopt for greater PHP compatibility
        // Base settings
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch, CURLOPT_HEADER, false );
        curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, 2 );
        curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, 1 );

        // Standard settings
        curl_setopt( $ch, CURLOPT_URL, $url );
        curl_setopt( $ch, CURLOPT_POST, true );
        curl_setopt( $ch, CURLOPT_POSTFIELDS, $pfParamString );

        // Execute CURL
        $response = curl_exec( $ch );
        curl_close( $ch );

        Storage::disk('public')->put('curltest.html', $response);

        $lines = explode( "\r\n", $response );
        $verifyResult = trim( $lines[0] );

        if( strcasecmp( $verifyResult, 'VALID' ) != 0 )
        {
            $output .= 'Data not valid';
        }

        $pfPaymentId = $pfData['pf_payment_id'];

        switch( $pfData['payment_status'] )
        {

            case 'COMPLETE':
                $order->order_status = 'COMPLETE';
                $order->transaction_status = 'COMPLETE';
                $order->gateway_payment_id = $pfPaymentId;
                $order->payfast_subscription_token = $pfData['token'];
                $order->paid = true;

                //Add subscription to user
                UserSubscription::create([
                    'user_id' => $order->user_id,
                    'order_id' => $order->id,
                    'subscription_id' => $pfData['custom_int1'],
                    'subscription_name' => $pfData['item_name'],
                    'start_date' => $order->subscription_start_date,
                    'status' => 'Active',
                ]);
                break;
            default:
                // If unknown status, do nothing (which is the safest course of action)
                break;
        }

        $order->save();

        Storage::disk('public')->put('test.html', $output);


    }





    public function updateSubscription(Request $request)
    {


    }

    public function pauseSubscriptionFile(Request $request)
    {


        return redirect()->back()->with('message', 'Update successful');
    }

    public function cancelSubscription(Request $request)
    {
        $user_sub = UserSubscription::where('id',$request->id)->first();

        $payfast = new PayfastAPI(Order::findOrFail($user_sub->order_id)->payfast_subscription_token);
        $response_obj = json_decode($payfast->cancel()->getBody()->getContents());

        if($response_obj->status == 'success'){
            $user_sub->status = 'Cancelled';
            $user_sub->save();
            return redirect()->route('shop.subscription-cancel-url');
        }
        else{
            return redirect()->back()->with('message','Error occurred while cancelling your subscription. Please try again or contact Admin.');
        }

    }


}
