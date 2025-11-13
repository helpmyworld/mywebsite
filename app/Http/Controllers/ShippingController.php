<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ShippingCharge;

class ShippingController extends Controller
{
    public function viewShipping(){
        $shipping_charges = ShippingCharge::get();
//        $shipping_charges = json_decode(json_encode($shipping_charges));
//        echo "<pre>"; print_r($shipping_charges); die;
        return view('admin.shipping.shipping_charges')->with(compact('shipping_charges'));
    }


    public function editShipping($id, Request $request){
        if($request->isMethod('post')){
            $data = $request->all();
//            dd($id);
//          echo "<pre>"; print_r($data); die;

            ShippingCharge::where('id',$id)->update(['shipping_charges'=>$data['shipping_charges']
            ]);
//            ShippingCharge::where(['id'=>$id])->first()->update(['shipping_charges'=>$data['shipping_charges']]);
            return redirect()->back()->with('flash_message_success',
                'Shipping Charges updated Successfully');
        }
        $shippingDetails = ShippingCharge::where('id', $id)->first();
//        $shipping_charges = json_decode(json_encode($shipping_charges));
//        echo "<pre>"; print_r($shipping_charges); die;
        return view('admin.shipping.edit_shipping')->with(compact('shippingDetails'));
    }
}
