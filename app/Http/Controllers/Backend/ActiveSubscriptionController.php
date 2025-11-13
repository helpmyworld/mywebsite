<?php

namespace App\Http\Controllers\Backend;

use App\Administrator;
use App\Benefit;
use App\ElectronicSubscriptionDocument;
use App\Http\Controllers\UsersController;
use App\ManuscriptOrder;
use App\Members;
use App\Order;
use App\Services\PayfastAPI;
use App\Subscription;
use App\SubscriptionCategory;
use App\SubscriptionIndustry;
use App\User;
use App\Role;
use App\UserSubscription;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;


class ActiveSubscriptionController extends Controller
{

    public function __construct() {
        $this->middleware('adminlogin');
    }

    public function index(Request $request)
    {
        $subscriptions = UserSubscription::all();

        return view('admin.subscription.authors_subscription',compact('subscriptions'));
    }

    public function destroy(Request $request)
    {

        $user_sub = UserSubscription::where('id',$request->id)->first();
        $payfast = new PayfastAPI(ManuscriptOrder::findOrFail($user_sub->order_id)->payfast_subscription_token);
        $response_obj = json_decode($payfast->cancel()->getBody()->getContents());

        if($response_obj->status == 'success'){
            $user_sub->status = 'Cancelled';
            $user_sub->save();
            return redirect()->route('admin.subscription.authors.index');
        }
        else{
            return redirect()->back()->with('message','Error occurred while cancelling your subscription. Please try again or contact Admin.');
        }

    }


}
