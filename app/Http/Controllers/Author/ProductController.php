<?php

namespace App\Http\Controllers\Author;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Auth;
use Illuminate\Support\Facades\Storage;
use Session;
use Image;
use App\Category;
use App\Product;
use App\ProductsAttribute;
use App\ProductsImage;
use App\Coupon;
use App\User;
use App\Country;
use App\DeliveryAddress;
use App\Order;
use App\OrdersProduct;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::where('user_id',auth()->id())->get();
        foreach ($products as $key => $val) {
            $category_name = Category::where(['id' => $val->category_id])->first();
            $products[$key]->category_name = $category_name->name;
        }


        return view('author.product.index', compact('products'));
    }

    public function show($id)
    {

        $product = Product::findOrFail($id);
        return response()->json($product);
    }

    public function edit($id)
    {

        $categories = Category::all();
        $product = Product::findOrFail($id);
        return view('author.product.edit')->with(compact('categories', 'product'));
    }

    public function create()
    {

        $categories = Category::all();
        return view('author.product.create')->with(compact('categories'));
    }

    public function store(Request $request)
    {

        if ($request->isMethod('post')) {
            $data = $request->all();
            //echo "<pre>"; print_r($data); die;

            $product = new Product;
            $product->user_id = $data['user_id'];
            $product->category_id = $data['category_id'];
            $product->product_name = $data['product_name'];
            $product->product_code = $data['product_code'];
            $product->product_color = $data['product_color'];
            $product->type = $data['product_type'];
            $product->product_isbn = $data['product_isbn'];
            $product->product_author = $data['product_author'];
            if (!empty($data['description'])) {
                $product->description = $data['description'];
            } else {
                $product->description = '';
            }
            if (!empty($data['care'])) {
                $product->care = $data['care'];
            } else {
                $product->care = '';
            }
            if (empty($data['status'])) {
                $status = '0';
            } else {
                $status = '1';
            }

            $product->price = $data['price'];

            // Upload Image
            if ($request->hasFile('image')) {
                $image_tmp = $request->file('image');
                if ($image_tmp->isValid()) {
                    // Upload Images after Resize
                    $extension = $image_tmp->getClientOriginalExtension();
                    $fileName = rand(111, 99999) . '.' . $extension;
                    $large_image_path = 'images/backend_images/product/large' . '/' . $fileName;
                    $medium_image_path = 'images/backend_images/product/medium' . '/' . $fileName;
                    $small_image_path = 'images/backend_images/product/small' . '/' . $fileName;

                    Image::make($image_tmp)->save($large_image_path);
                    Image::make($image_tmp)->resize(600, 600)->save($medium_image_path);
                    Image::make($image_tmp)->resize(300, 300)->save($small_image_path);

                    $product->image = $fileName;

                }
            }

            if ($request->hasFile('book')) {
                $file = $request->file('book');
                $name = time() . $file->getClientOriginalName();

                $filePath = 'uploads/ebooks/' . $name;
                Storage::disk('s3')->put($filePath, file_get_contents($file));
                $product->book_path = $name;

            }

            $product->status = $status;
            $product->save();

            //Add attribute
            if ($request->has('size')){

                foreach ($request->size as $key=>$value){
                    $member_data[$key]['size'] = $value;
                    $member_data[$key]['product_id'] = $product->id;
                }

                foreach ($request->stock as $key=>$value){
                    $member_data[$key]['stock'] = $value;
                }

                foreach ($request->price_a as $key=>$value){
                    $member_data[$key]['price'] = $value;
                }

                DB::table('products_attributes')->insert($member_data);
            }

            // Mail::send([], [], function ($message) {
            //     $message->to('rorisang@helpmyworld.co.za')
            //         ->subject('New Product Posted by an Author')
            //         // here comes what you want
            //         ->setBody('<p>A new product has been added by an author</p>', 'text/html'); // for HTML rich messages
            // });
            return redirect()->route('author.products.index')->with('message', 'Product has been added successfully');
        }
    }

    public function update(Request $request, $id)
    {

        $data = $request->all();
        //echo "<pre>"; print_r($data); die;

        if (empty($data['status'])) {
            $status = '0';
        } else {
            $status = '1';
        }

        if (empty($data['description'])) {
            $data['description'] = '';
        }

        if (empty($data['care'])) {
            $data['care'] = '';
        }
        if (empty($data['product_isbn'])) {
            $data['product_isbn'] = '';
        }
        if (empty($data['product_author'])) {
            $data['product_author'] = '';
        }

        Product::where(['id' => $id])->update(['status' => $status, 'category_id' => $data['category_id'], 'product_name' => $data['product_name'],
            'product_author' => $data['product_author'], 'product_isbn' => $data['product_isbn'], 'product_code' => $data['product_code'], 'product_color' => $data['product_color'],
            'description' => $data['description'], 'care' => $data['care'], 'price' => $data['price']]);

        return redirect()->route('author.products.index')->with('message', 'Product has been edited successfully');

    }

    public function updateAttribute(Request $request, $id)
    {

        $product = Product::findOrFail($id);

        //Add attribute
        if ($request->has('size')){

            foreach ($request->size as $key=>$value){
                $member_data[$key]['size'] = $value;
                $member_data[$key]['product_id'] = $product->id;
            }

            foreach ($request->stock as $key=>$value){
                $member_data[$key]['stock'] = $value;
            }

            foreach ($request->price_a as $key=>$value){
                $member_data[$key]['price'] = $value;
            }

            DB::table('products_attributes')->insert($member_data);
        }

        return redirect()->route('author.products.index')->with('message', 'Product has been edited successfully');

    }

    public function updateImage(Request $request, $id)
    {

        // Upload Image
        if ($request->hasFile('image')) {
            $image_tmp = $request->file('image');
            if ($image_tmp->isValid()) {
                // Upload Images after Resize
                $extension = $image_tmp->getClientOriginalExtension();
                $fileName = rand(111, 99999) . '.' . $extension;
                $large_image_path = 'images/backend_images/product/large' . '/' . $fileName;
                $medium_image_path = 'images/backend_images/product/medium' . '/' . $fileName;
                $small_image_path = 'images/backend_images/product/small' . '/' . $fileName;

                Image::make($image_tmp)->save($large_image_path);
                Image::make($image_tmp)->resize(600, 600)->save($medium_image_path);
                Image::make($image_tmp)->resize(300, 300)->save($small_image_path);

                Product::where(['id' => $id])->update(['image' => $fileName]);

            }
        }

        return redirect()->route('author.products.index')->with('message', 'Product has been edited successfully');
    }

    public function updateEbook(Request $request, $id)
    {

        // Upload Image
        if ($request->hasFile('ebook')) {
            $file = $request->file('ebook');
            $name = time() . $file->getClientOriginalName();

            $filePath = 'uploads/ebooks/' . $name;
            Storage::disk('s3')->put($filePath, file_get_contents($file));

            Product::where(['id' => $id])->update(['book_path' => $name]);
        }

        return redirect()->route('author.products.index')->with('message', 'Product has been edited successfully');
    }

    public function deleteAttribute($id)
    {
        ProductsAttribute::where(['id' => $id])->delete();
        return response()->json(true);
    }

    public function deleteProductImage($id = null)
    {

        // Get Product Image
        $productImage = Product::where('id', $id)->first();

        // Get Product Image Paths
        $large_image_path = 'images/backend_images/product/large/';
        $medium_image_path = 'images/backend_images/product/medium/';
        $small_image_path = 'images/backend_images/product/small/';

        // Delete Large Image if not exists in Folder
        if (file_exists($large_image_path . $productImage->image)) {
            unlink($large_image_path . $productImage->image);
        }

        // Delete Medium Image if not exists in Folder
        if (file_exists($medium_image_path . $productImage->image)) {
            unlink($medium_image_path . $productImage->image);
        }

        // Delete Small Image if not exists in Folder
        if (file_exists($small_image_path . $productImage->image)) {
            unlink($small_image_path . $productImage->image);
        }

        // Delete Image from Products table
        Product::where(['id' => $id])->update(['image' => '']);

        return redirect()->back()->with('flash_message_success', 'Product image has been deleted successfully');
    }


    public function deleteProduct($id = null)
    {
        Product::where(['id' => $id])->delete();
        return redirect()->back()->with('flash_message_success', 'Product has been deleted successfully');
    }


    public function orderReview()
    {
        $user_id = Auth::user()->id;
        $user_email = Auth::user()->email;
        $userDetails = User::where('id', $user_id)->first();
        $shippingDetails = DeliveryAddress::where('user_id', $user_id)->first();
        $shippingDetails = json_decode(json_encode($shippingDetails));
        $userCart = DB::table('cart')->where(['user_email' => $user_email])->get();
        foreach ($userCart as $key => $product) {
            $productDetails = Product::where('id', $product->product_id)->first();
            $userCart[$key]->image = $productDetails->image;
        }

        //Fetch Shipping Charges
        $shippingCharges = Product::getShippingCharges($shippingDetails->country);

        /*echo "<pre>"; print_r($userCart); die;*/
        $meta_title = "Checkout - Publishing books";
        return view('products.order_review')->with(compact('userDetails', 'shippingDetails', 'userCart', 'meta_title', 'shippingCharges'));
    }




}
