<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public function orders(){
    	return $this->hasMany('App\OrdersProduct','order_id');
    }

    public static function getOrderDetails($order_id){
    	$getOrderDetails = Order::where('id',$order_id)->first();
    	return $getOrderDetails;
    }

    public static function getCountryCode($country){
    	$getCountryCode = Country::where('country_name',$country)->first();
    	return $getCountryCode;	
    }

    public static function get_product_id($order_id){
        $product_id = OrdersProduct::where('order_id',$order_id)->value('product_id');
        return $product_id;
    }
    public static function get_product_qty($order_id){
        $product_qty = OrdersProduct::where('order_id',$order_id)->value('product_qty');
        return $product_qty;
    }
}
