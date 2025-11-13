<?php

namespace App\Http\Controllers;


use App\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;
use Auth;
use phpDocumentor\Reflection\DocBlock\Tags\Uses;
use Session;
use Image;
use App\Category;
use App\Product;
use App\Http\Requests;
use App\ProductsAttribute;
use App\ProductsImage;
use App\Coupon;
use App\User;
use App\Country;
use App\DeliveryAddress;
use App\Order;
use App\OrdersProduct;
use DB;

class EbookController extends Controller
{
     public function ebook()

    {
        // Get all Products
        $productsAll = Product::inRandomOrder()->where('type','ebook')->where('status',1)->where('approved',true)->get();
        $productsAll = json_decode(json_encode($productsAll));
        /*dump($productsAll);*/
        /*echo "<pre>"; print_r($productsAll);die;*/

        // Get All Categories and Sub Categories
        $categories_menu = "";
        $categories = Category::with('categories')->where(['parent_id' => 0])->get();
        $categories = json_decode(json_encode($categories));
        /*echo "<pre>"; print_r($categories); die;*/
        foreach($categories as $cat){
            $categories_menu .= "
			<div class='panel-heading'>
				<h4 class='panel-title'>
					<a data-toggle='collapse' data-parent='#accordian' href='#".$cat->id."'>
						<span class='badge pull-right'><i class='fa fa-plus'></i></span>
						".$cat->name."
					</a>
				</h4>
			</div>
			<div id='".$cat->id."' class='panel-collapse collapse'>
				<div class='panel-body'>
					<ul>";
            $sub_categories = Category::where(['parent_id' => $cat->id])->get();
            foreach($sub_categories as $sub_cat){
                $categories_menu .= "<li><a href='#'>".$sub_cat->name." </a></li>";
            }
            $categories_menu .= "</ul>
				</div>
			</div>
			";
        }

      
        //Meta tags
        $meta_title = "Helpmyworld";
        $meta_description = "Publishers for Authors";
        $meta_keywords = "Books to ready, Buy books online, South African Authors, Best books, books, Books to buy, Buy books online south africa";

        return view('ebook.index')->with(compact('productsAll','categories_menu','categories', 'meta_title','meta_description', 'meta_keywords'));
    }

}
