<?php

namespace App\Http\Controllers\Author;

use App\Manuscript;
use App\ManuscriptOrder;
use Illuminate\Http\Request;
use App\User;
use App\Country;
use Auth;
use Illuminate\Support\Facades\Storage;
use Session;
use DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;

class ManuscriptPaymentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['itn']);
    }

    public function index(){
        $manuscripts = Manuscript::all();
        return view('author.manuscript.index',compact('manuscripts'));
    }


    public function  show($id){
        $manuscript = Manuscript::findOrFail($id);
        return view('author.manuscript.payment.show',compact('manuscript'));
    }

    public function success(Request $request)
    {

        return view('author.manuscript.payment.success');
    }

    public function cancel(Request $request)
    {

        return view('author.manuscript.payment.cancel');
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
                //set invoice paid=true and save
                $order->order_status = 'COMPLETE';
                $order->transaction_status = 'COMPLETE';
                $order->gateway_payment_id = $pfPaymentId;
                $order->paid = true;
                break;
            default:
                // If unknown status, do nothing (which is the safest course of action)
                break;
        }

        $order->save();


        Storage::disk('public')->put('test.html', $output);


    }

    public function store(Request $request)
    {

        $user = auth()->user();

        $manuscript = Manuscript::findOrFail($request->manuscript_id);

        $order = new ManuscriptOrder();
        $order->user_id = $user->id;
        $order->manuscript_id = $manuscript->id;

        //$order->payment_method = $request->input('payment_method');
        $order->date_purchased = date("Y-m-d H:i:s");
        $order->order_type = 'Manuscript';
        $order->order_cost = $manuscript->cost;

        $order->save();

        $data = new \stdClass();
        $data->order_id = $order->id;

        return response()->json($data);
    }


}
