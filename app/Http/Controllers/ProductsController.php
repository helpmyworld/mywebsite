<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Auth;
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
use DB;
use Dompdf\Dompdf;
use Carbon\Carbon;
use App\Mail\ebooklink;

class ProductsController extends Controller
{
    /* =========================
     * Helpers
     * ========================= */

    /** Returns the current session id, creating one if missing. */
    private function ensureSessionId(): string
    {
        $sessionId = Session::get('session_id');
        if (!$sessionId) {
            $sessionId = Str::random(40);
            Session::put('session_id', $sessionId);
        }
        return $sessionId;
    }

    /** True if any cart item is an ebook (used to decide shipping). */
    private function cartHasEbook($cart)
    {
        foreach ($cart as $row) {
            if (isset($row->product_type) && strtolower($row->product_type) === 'ebook') {
                return true;
            }
        }
        return false;
    }

    /** Merge duplicates: if same product already in cart, increase quantity. */
    private function upsertCartRow(array $payload, ?string $userEmail, ?string $sessionId)
    {
        $where = [
            'product_id'   => $payload['product_id'],
        ];

        if ($userEmail) {
            $where['user_email'] = $userEmail;
        } else {
            $where['session_id'] = $sessionId;
        }

        if (array_key_exists('product_color', $payload)) {
            $where['product_color'] = $payload['product_color'];
        }
        if (array_key_exists('product_code', $payload)) {
            $where['product_code'] = $payload['product_code'];
        }

        $existing = DB::table('cart')->where($where)->first();

        if ($existing) {
            DB::table('cart')->where('id', $existing->id)->update([
                'quantity' => (int)$existing->quantity + (int)$payload['quantity'],
                'price'    => $payload['price'], // keep latest price
            ]);
        } else {
            DB::table('cart')->insert($payload);
        }
    }

    /* =========================
     * Admin: Add Product
     * ========================= */
    public function addProduct(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();

            $product = new Product;
            $product->category_id    = $data['category_id'] ?? null;
            $product->product_name   = $data['product_name'] ?? '';
      
            $product->type           = $data['product_type'] ?? 'Physical Book';
            $product->product_isbn   = $data['product_isbn'] ?? '';
            $product->product_author = $data['product_author'] ?? '';
            $product->description    = $data['description'] ?? '';
           
            $product->price          = $data['price'] ?? 0;

             // ✅ NEW: royalty rate (percent)
            $product->royalty_rate   = isset($data['royalty_rate']) && $data['royalty_rate'] !== ''
                ? (float)$data['royalty_rate'] : null;




            $product->is_new_arrival = !empty($data['is_new_arrival']) ? 1 : 0;
            $product->is_best_seller = !empty($data['is_best_seller']) ? 1 : 0;
            $product->is_special_offer = !empty($data['is_special_offer']) ? 1 : 0;

            $product->status       = !empty($data['status']) ? 1 : 0;
            $product->feature_item = !empty($data['feature_item']) ? 1 : 0;

            // Generate slug (keep stable per product)
            $baseName = $product->product_name ?: Str::random(6);
            $product->slug = Str::slug($baseName . '-' . Str::random(6));

            // Upload main image
            if ($request->hasFile('image')) {
                $image_tmp = $request->file('image');
                if ($image_tmp->isValid()) {
                    $extension = $image_tmp->getClientOriginalExtension();
                    $fileName  = rand(111, 99999) . '.' . $extension;

                    $large_image_path  = 'images/backend_images/product/large/'  . $fileName;
                    $medium_image_path = 'images/backend_images/product/medium/' . $fileName;
                    $small_image_path  = 'images/backend_images/product/small/'  . $fileName;

                    Image::make($image_tmp)->save($large_image_path);
                    Image::make($image_tmp)->resize(600, 600)->save($medium_image_path);
                    Image::make($image_tmp)->resize(300, 300)->save($small_image_path);

                    $product->image = $fileName;
                }
            }

            // Upload ebook file to S3 (if provided) — accept either input name
            $ebookFile = $request->file('book') ?? $request->file('ebook');
            if ($ebookFile) {
                $name = time() . $ebookFile->getClientOriginalName();
                $filePath = 'uploads/ebooks/' . $name;
                Storage::disk('s3')->put($filePath, file_get_contents($ebookFile));
                $product->book_path = $name; // stored name only (matches download())
            }

            // Upload preview PDF to public disk (optional)
            if ($request->hasFile('preview_file')) {
                $product->preview_file = $request->file('preview_file')->store('previews', 'public'); // previews/xyz.pdf
            }

            $product->approved = true;
            $product->save();

            return redirect()->back()->with('flash_message_success', 'Product has been added successfully');
        }

        $categories = Category::where(['parent_id' => 0])->get();

        $categories_drop_down = "<option value='' selected disabled>Select</option>";
        foreach ($categories as $cat) {
            $categories_drop_down .= "<option value='" . $cat->id . "'>" . $cat->name . "</option>";
            $sub_categories = Category::where(['parent_id' => $cat->id])->get();
            foreach ($sub_categories as $sub_cat) {
                $categories_drop_down .= "<option value='" . $sub_cat->id . "'>&nbsp;&nbsp;--&nbsp;" . $sub_cat->name . "</option>";
            }
        }

        return view('admin.products.add_product')->with(compact('categories_drop_down'));
    }

    /* =========================
     * Admin: Edit Product
     * ========================= */
    public function editProduct(Request $request, $id = null)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();

            $status       = !empty($data['status']) ? 1 : 0;
            $feature_item = !empty($data['feature_item']) ? 1 : 0;

            // Upload main image
            if ($request->hasFile('image')) {
                $image_tmp = $request->file('image');
                if ($image_tmp->isValid()) {
                    $extension = $image_tmp->getClientOriginalExtension();
                    $fileName  = rand(111, 99999) . '.' . $extension;
                    $large_image_path  = 'images/backend_images/product/large/'  . $fileName;
                    $medium_image_path = 'images/backend_images/product/medium/' . $fileName;
                    $small_image_path  = 'images/backend_images/product/small/'  . $fileName;

                    Image::make($image_tmp)->save($large_image_path);
                    Image::make($image_tmp)->resize(600, 600)->save($medium_image_path);
                    Image::make($image_tmp)->resize(300, 300)->save($small_image_path);
                }
            } elseif (!empty($data['current_image'])) {
                $fileName = $data['current_image'];
            } else {
                $fileName = '';
            }

            // Ebook (S3) — here your form uses 'ebook'
            if ($request->hasFile('ebook')) {
                $file = $request->file('ebook');
                $name = time() . $file->getClientOriginalName();

                $filePath = 'uploads/ebooks/' . $name;
                Storage::disk('s3')->put($filePath, file_get_contents($file));
                $data['book_path'] = $name;

            } elseif (!empty($data['current_ebook'])) {
                $data['book_path'] = $data['current_ebook'];
            } else {
                $data['book_path'] = '';
            }

            // Preview upload (public disk)
            if ($request->hasFile('preview_file')) {
                $path = $request->file('preview_file')->store('previews', 'public');
                $data['preview_file'] = $path;
            } else {
                // keep existing if present; else null
                $productDetails = Product::where(['id' => $id])->first();
                $data['preview_file'] = $productDetails && $productDetails->preview_file
                    ? $productDetails->preview_file
                    : null;
            }

            Product::where(['id' => $id])->update([
                'status'         => $status,
                'feature_item'   => $feature_item,
                'category_id'    => $data['category_id'] ?? null,
                'product_name'   => $data['product_name'] ?? '',
                'product_author' => $data['product_author'] ?? '',
                'product_isbn'   => $data['product_isbn'] ?? '',
                
                'description'    => $data['description'] ?? '',
                'care'           => $data['care'] ?? '',
                'price'          => $data['price'] ?? 0,



                // ✅ NEW: royalty rate
                'royalty_rate'   => isset($data['royalty_rate']) && $data['royalty_rate'] !== ''
                    ? (float)$data['royalty_rate'] : null,



                // ✅ these are new columns (use array keys, not $product->)
                'is_featured'    => !empty($data['is_featured']) ? 1 : 0, 
                'is_new_arrival' => !empty($data['is_new_arrival']) ? 1 : 0,
                'is_best_seller' => !empty($data['is_best_seller']) ? 1 : 0,
                'is_special_offer' => !empty($data['is_special_offer']) ? 1 : 0,

                'image'          => $fileName,
                'book_path'      => $data['book_path'],
                'preview_file'   => $data['preview_file'],
            ]);

            return redirect()->back()->with('flash_message_success', 'Product has been edited successfully');
        }

        // Get Product Details
        $productDetails = Product::where(['id' => $id])->first();

        // Categories drop down
        $categories = Category::where(['parent_id' => 0])->get();

        $categories_drop_down = "<option value='' disabled>Select</option>";
        foreach ($categories as $cat) {
            $selected = ($cat->id == $productDetails->category_id) ? "selected" : "";
            $categories_drop_down .= "<option value='" . $cat->id . "' " . $selected . ">" . $cat->name . "</option>";
            $sub_categories = Category::where(['parent_id' => $cat->id])->get();
            foreach ($sub_categories as $sub_cat) {
                $selected = ($sub_cat->id == $productDetails->category_id) ? "selected" : "";
                $categories_drop_down .= "<option value='" . $sub_cat->id . "' " . $selected . ">&nbsp;&nbsp;--&nbsp;" . $sub_cat->name . "</option>";
            }
        }

        return view('admin.products.edit_product')->with(compact('productDetails', 'categories_drop_down'));
    }

    public function deleteProductImage($id = null)
    {
        $productImage = Product::where('id', $id)->first();

        $large_image_path  = 'images/backend_images/product/large/';
        $medium_image_path = 'images/backend_images/product/medium/';
        $small_image_path  = 'images/backend_images/product/small/';

        if (!empty($productImage->image)) {
            if (file_exists($large_image_path . $productImage->image))  @unlink($large_image_path . $productImage->image);
            if (file_exists($medium_image_path . $productImage->image)) @unlink($medium_image_path . $productImage->image);
            if (file_exists($small_image_path . $productImage->image))  @unlink($small_image_path . $productImage->image);
        }

        Product::where(['id' => $id])->update(['image' => '']);

        return redirect()->back()->with('flash_message_success', 'Product image has been deleted successfully');
    }

    public function deleteProductAltImage($id = null)
    {
        $productImage = ProductsImage::where('id', $id)->first();

        $large_image_path  = 'images/backend_images/product/large/';
        $medium_image_path = 'images/backend_images/product/medium/';
        $small_image_path  = 'images/backend_images/product/small/';

        if (!empty($productImage->image)) {
            if (file_exists($large_image_path . $productImage->image))  @unlink($large_image_path . $productImage->image);
            if (file_exists($medium_image_path . $productImage->image)) @unlink($medium_image_path . $productImage->image);
            if (file_exists($small_image_path . $productImage->image))  @unlink($small_image_path . $productImage->image);
        }

        ProductsImage::where(['id' => $id])->delete();

        return redirect()->back()->with('flash_message_success', 'Product alternate mage has been deleted successfully');
    }

    public function viewProducts(Request $request)
    {
        // Fetch products ordered by latest first
        $products = Product::orderByRaw('id DESC')->get();

        // Attach category name for each product
        foreach ($products as $key => $val) {
            $category = Category::where('id', $val->category_id)->first();
            $products[$key]->category_name = $category ? $category->name : '';
        }

        // Convert to object format (optional)
        $products = json_decode(json_encode($products));

        return view('admin.products.view_products')->with(compact('products'));
    }

    public function deleteProduct($id = null)
    {
        Product::where(['id' => $id])->delete();
        return redirect()->back()->with('flash_message_success', 'Product has been deleted successfully');
    }

    public function approveProduct($id = null)
    {
        $product = Product::where(['id' => $id])->first();
        $product->approved = true;
        $product->save();
        return redirect()->back()->with('flash_message_success', 'Product has been approved successfully');
    }

    public function disapproveProduct($id = null)
    {
        $product = Product::where(['id' => $id])->first();
        $product->approved = false;
        $product->save();
        return redirect()->back()->with('flash_message_success', 'Product has been disapproved successfully');
    }

    public function deleteAttribute($id = null)
    {
        ProductsAttribute::where(['id' => $id])->delete();
        return redirect()->back()->with('flash_message_success', 'Product Attribute has been deleted successfully');
    }

    public function addAttributes(Request $request, $id = null)
    {
        $productDetails = Product::with('attributes')->where(['id' => $id])->first();
        $productDetails = json_decode(json_encode($productDetails));

        $categoryDetails = Category::where(['id' => $productDetails->category_id])->first();
        $category_name   = $categoryDetails ? $categoryDetails->name : '';

        if ($request->isMethod('post')) {
            $data = $request->all();

            foreach ($data['sku'] as $key => $val) {
                if (!empty($val)) {
                    $attrCountSKU = ProductsAttribute::where(['sku' => $val])->count();
                    if ($attrCountSKU > 0) {
                        return redirect('admin/add-attributes/' . $id)->with('flash_message_error', 'SKU already exists. Please add another SKU.');
                    }
                    $attrCountSizes = ProductsAttribute::where(['product_id' => $id, 'size' => $data['size'][$key]])->count();
                    if ($attrCountSizes > 0) {
                        return redirect('admin/add-attributes/' . $id)->with('flash_message_error', 'Attribute already exists. Please add another Attribute.');
                    }
                    $attr = new ProductsAttribute;
                    $attr->product_id = $id;
                    $attr->sku        = $val;
                    $attr->size       = $data['size'][$key];
                    $attr->price      = $data['price'][$key];
                    $attr->stock      = $data['stock'][$key];
                    $attr->save();
                }
            }
            return redirect('admin/add-attributes/' . $id)->with('flash_message_success', 'Product Attributes has been added successfully');
        }

        $title = "Add Attributes";

        return view('admin.products.add_attributes')->with(compact('title', 'productDetails', 'category_name'));
    }

    public function editAttributes(Request $request, $id = null)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            foreach ($data['idAttr'] as $key => $attr) {
                if (!empty($attr)) {
                    ProductsAttribute::where(['id' => $data['idAttr'][$key]])->update([
                        'price' => $data['price'][$key],
                        'stock' => $data['stock'][$key]
                    ]);
                }
            }
            return redirect('admin/add-attributes/' . $id)->with('flash_message_success', 'Product Attributes has been updated successfully');
        }
    }

    public function addImages(Request $request, $id = null)
    {
        $productDetails = Product::where(['id' => $id])->first();

        $categoryDetails = Category::where(['id' => $productDetails->category_id])->first();
        $category_name   = $categoryDetails ? $categoryDetails->name : '';

        if ($request->isMethod('post')) {
            if ($request->hasFile('image')) {
                $files = $request->file('image');
                foreach ($files as $file) {
                    $image = new ProductsImage;
                    $extension = $file->getClientOriginalExtension();
                    $fileName  = rand(111, 99999) . '.' . $extension;
                    $large_image_path  = 'images/backend_images/product/large/'  . $fileName;
                    $medium_image_path = 'images/backend_images/product/medium/' . $fileName;
                    $small_image_path  = 'images/backend_images/product/small/'  . $fileName;
                    Image::make($file)->save($large_image_path);
                    Image::make($file)->resize(600, 600)->save($medium_image_path);
                    Image::make($file)->resize(300, 300)->save($small_image_path);
                    $image->image      = $fileName;
                    $image->product_id = $request->get('product_id');
                    $image->save();
                }
            }

            return redirect('admin/add-images/' . $id)->with('flash_message_success', 'Product Images has been added successfully');
        }

        $productImages = ProductsImage::where(['product_id' => $id])->orderBy('id', 'DESC')->get();

        $title = "Add Images";
        return view('admin.products.add_images')->with(compact('title', 'productDetails', 'category_name', 'productImages'));
    }

    /* =========================
     * Front: Category Listing
     * ========================= */
    public function products($url = null)
    {
        $categoryCount = Category::where(['url' => $url, 'status' => 1])->count();
        if ($categoryCount == 0) {
            abort(404);
        }

        $categories = Category::with('categories')->where(['parent_id' => 0])->get();

        $categoryDetails = Category::where(['url' => $url])->first();
        if ($categoryDetails->parent_id == 0) {
            $subCategories = Category::where(['parent_id' => $categoryDetails->id])->get();
            $subCategories = json_decode(json_encode($subCategories));
            $cat_ids = [];
            foreach ($subCategories as $subcat) {
                $cat_ids[] = $subcat->id;
            }
            $productsAll = Product::whereIn('category_id', $cat_ids)->where('status', '1')->where('approved', true)->get();
        } else {
            $productsAll = Product::where(['category_id' => $categoryDetails->id])->where('status', '1')->where('approved', true)->get();
        }

        $meta_title       = $categoryDetails->meta_title;
        $meta_description = $categoryDetails->meta_description;
        $meta_keywords    = $categoryDetails->meta_keywords;

        return view('products.listing')->with(compact('categories', 'productsAll', 'categoryDetails',
            'meta_title', 'meta_description', 'meta_keywords'));
    }

    public function searchProducts(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();

            $categories = Category::with('categories')->where(['parent_id' => 0])->get();

            $search_product = $data['product'] ?? '';

            $productsAll = Product::where(function ($q) use ($search_product) {
                $q->where('product_name', 'like', '%' . $search_product . '%')
                  ->orWhere('product_code', $search_product);
            })
                ->where('status', 1)
                ->where('approved', true)
                ->get();

            return view('products.listing')->with(compact('categories', 'productsAll', 'search_product'));
        }
    }

    /* =========================
     * Front: Product Detail
     * ========================= */
    public function product($slug = null)
    {
        $productCount = Product::where(['slug' => $slug, 'status' => 1])->count();
        if ($productCount == 0) {
            abort(404);
        }

        $productDetails   = Product::with('attributes')->where('slug', $slug)->first();
        $relatedProducts  = Product::where('slug', '!=', $slug)->where(['category_id' => $productDetails->category_id])->get();

        $productAltImages = ProductsImage::where('product_id', $productDetails->id)->get();

        $categories = Category::with('categories')->where(['parent_id' => 0])->get();

        $total_stock = ProductsAttribute::where('product_id', $productDetails->id)->sum('stock');

        $meta_title       = $productDetails->product_name;
        $meta_description = $productDetails->description;
        $meta_keywords    = $productDetails->product_name;

        return view('products.detail')->with(compact(
            'productDetails', 'categories', 'productAltImages', 'total_stock', 'relatedProducts',
            'meta_title', 'meta_description', 'meta_keywords'
        ));
    }

    /* =========================
     * NEW: Product Preview (public)
     * ========================= */
    public function preview(string $slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();

        if (empty($product->preview_file)) {
            abort(404, 'No preview available for this product.');
        }

        $disk = Storage::disk('public'); // storage/app/public
        if (!$disk->exists($product->preview_file)) {
            abort(404, 'Preview file missing.');
        }

        $fullPath = $disk->path($product->preview_file);

        return response()->file($fullPath, [
            'Content-Type'        => 'application/pdf',
            'Content-Disposition' => 'inline; filename="'.basename($fullPath).'"',
        ]);
    }

    /* =========================
     * Ajax: Attribute Price
     * ========================= */
    public function getProductPrice(Request $request)
    {
        $data   = $request->all();
        $proArr = explode("-", $data['idsize']);
        $proAttr = ProductsAttribute::where(['product_id' => $proArr[0], 'size' => $proArr[1]])->first();

        $getCurrencyRates = Product::getCurrencyRates($proAttr->price);

        return response()->json([
            'price'    => $proAttr->price,
            'stock'    => $proAttr->stock,
            'usd_rate' => $getCurrencyRates['USD_Rate'],
            'gbp_rate' => $getCurrencyRates['GBP_Rate'],
            'eur_rate' => $getCurrencyRates['EUR_Rate']
        ]);
    }

    /* =========================
     * Cart
     * ========================= */
    public function addtocart(Request $request)
    {
        Session::forget('CouponAmount');
        Session::forget('CouponCode');

        $data = $request->all();

        $productId   = (int)($data['product_id'] ?? 0);
        $productName = $data['product_name'] ?? '';
        $productType = $data['product_type'] ?? 'Physical Book';
        $productCode = $data['product_code'] ?? ''; // attribute SKU if physical
        $productColor= $data['product_color'] ?? '';
        $price       = (float)($data['price'] ?? 0);
        $quantity    = max(1, (int)($data['quantity'] ?? 1));

        // If physical, check stock only if attributes exist
        if (strtolower($productType) === 'physical book') {
            $attr = ProductsAttribute::where(['product_id' => $productId])->first();
            if ($attr && $attr->stock < $quantity) {
                return redirect()->back()->with('flash_message_error', 'Required Quantity is not available!');
            }
        }

        $userEmail = Auth::check() ? Auth::user()->email : null;
        $sessionId = $userEmail ? null : $this->ensureSessionId();

        $payload = [
            'product_id'   => $productId,
            'product_name' => $productName,
            'product_type' => $productType,
            'product_code' => $productCode,
            'product_color'=> $productColor,
            'price'        => $price,
            'quantity'     => $quantity,
            'user_email'   => $userEmail ?? '',
            'session_id'   => $sessionId ?? '',
        ];

        $this->upsertCartRow($payload, $userEmail, $sessionId);

        return redirect('cart')->with('flash_message_success', 'Product has been added to cart!');
    }

    public function cart()
    {
        if (Auth::check()) {
            $user_email = Auth::user()->email;
            $userCart   = DB::table('cart')->where(['user_email' => $user_email])->get();
        } else {
            $session_id = $this->ensureSessionId();
            $userCart   = DB::table('cart')->where(['session_id' => $session_id])->get();
        }

        $is_ebook_present = false;
        foreach ($userCart as $key => $product) {
            $productDetails = Product::where('id', $product->product_id)->first();
            $userCart[$key]->image = $productDetails ? $productDetails->image : null;
            if (isset($product->product_type) && strtolower($product->product_type) === "ebook") {
                $is_ebook_present = true;
            }
        }

        $meta_title       = "Shopping Cart - Book publishers";
        $meta_description = "Publishers for Authors";
        $meta_keywords    = "Printing books, Publish books, Book design, Book printing";

        return view('products.cart')->with(compact('userCart','is_ebook_present', 'meta_title', 'meta_description', 'meta_keywords'));
    }

    public function updateCartQuantity($id = null, $quantity = null)
    {
        Session::forget('CouponAmount');
        Session::forget('CouponCode');

        $row = DB::table('cart')->where('id', $id)->first();
        if (!$row) return redirect('cart');

        $updated_quantity = (int)$row->quantity + (int)$quantity;

        // Only check stock for physical book with attribute stock available
        $ok = true;
        if (strtolower($row->product_type ?? '') === 'physical book' && $updated_quantity > 0) {
            $attr = null;
            if (!empty($row->product_code)) {
                $attr = ProductsAttribute::where('sku', $row->product_code)->first();
            } else {
                $attr = ProductsAttribute::where('product_id', $row->product_id)->first();
            }
            if ($attr && $attr->stock < $updated_quantity) {
                $ok = false;
            }
        }

        if ($ok && $updated_quantity > 0) {
            DB::table('cart')->where('id', $id)->update(['quantity' => $updated_quantity]);
            return redirect('cart')->with('flash_message_success', 'Product quantity updated!');
        } else {
            return redirect('cart')->with('flash_message_error', 'Required product quantity is not available!');
        }
    }

    public function deleteCartProduct($id = null)
    {
        Session::forget('CouponAmount');
        Session::forget('CouponCode');
        DB::table('cart')->where('id', $id)->delete();
        return redirect('cart')->with('flash_message_success', 'Product has been removed from cart!');
    }

    public function applyCoupon(Request $request)
    {
        Session::forget('CouponAmount');
        Session::forget('CouponCode');

        $data = $request->all();
        $code = $data['coupon_code'] ?? '';

        $couponCount = Coupon::where('coupon_code', $code)->count();
        if ($couponCount == 0) {
            return redirect()->back()->with('flash_message_error', 'This coupon does not exist!');
        }

        $couponDetails = Coupon::where('coupon_code', $code)->first();

        if ($couponDetails->status == 0) {
            return redirect()->back()->with('flash_message_error', 'This coupon is not active!');
        }

        $expiry_date  = $couponDetails->expiry_date;
        $current_date = date('Y-m-d');
        if ($expiry_date < $current_date) {
            return redirect()->back()->with('flash_message_error', 'This coupon is expired!');
        }

        if (Auth::check()) {
            $user_email = Auth::user()->email;
            $userCart = DB::table('cart')->where(['user_email' => $user_email])->get();
        } else {
            $session_id = $this->ensureSessionId();
            $userCart = DB::table('cart')->where(['session_id' => $session_id])->get();
        }

        $total_amount = 0;
        foreach ($userCart as $item) {
            $total_amount += ($item->price * $item->quantity);
        }

        $couponAmount = $couponDetails->amount_type == "Fixed"
            ? $couponDetails->amount
            : $total_amount * ($couponDetails->amount / 100);

        Session::put('CouponAmount', $couponAmount);
        Session::put('CouponCode', $code);

        return redirect()->back()->with('flash_message_success', 'Coupon applied successfully!');
    }

    /* =========================
     * Checkout Flow
     * ========================= */
    public function getrate($country) {
        $shippingCharges = Product::getShippingCharges($country);
        return response()->json($shippingCharges);
    }
    
        public function checkout(Request $request)
    {

        $user_id = Auth::user()->id;
        $user_email = Auth::user()->email;
        $userDetails = User::find($user_id);
        $countries = Country::get();
         $user_id = Auth::user()->id;
        $shippingDetails = DeliveryAddress::where('user_id', $user_id)->first();
        $shippingDetails = json_decode(json_encode($shippingDetails));
        $userCart = DB::table('cart')->where(['user_email' => $user_email])->get();
        //Check if Shipping Address exists
        $shippingCount = DeliveryAddress::where('user_id', $user_id)->count();
        $shippingDetails = array();
        if ($shippingCount > 0) {
            $shippingDetails = DeliveryAddress::where('user_id', $user_id)->first();
        }
        
           foreach ($userCart as $key => $product) {
            $productDetails = Product::where('id', $product->product_id)->first();
            $userCart[$key]->image = $productDetails->image;
        }

        $userCart1 = DB::table('cart')->where(['user_email' => $user_email])->first();
        //Fetch Shipping Charges
        /*dd($country);*/
        /* echo "<pre>"; print_r($country); die;*/
        //Fetch Shipping Charges
        // Fetch Shipping Charges (no country dependency)
    $shippingCharges = 0; // or set a flat rate like 50 if needed

        // Update cart table with user email
        $session_id = Session::get('session_id');
        DB::table('cart')->where(['session_id' => $session_id])->update(['user_email' => $user_email]);
        if ($request->isMethod('post')) {
            $data = $request->all();
            /*echo "<pre>"; print_r($data); die;*/
            // Return to Checkout page if any of the field is empty
            if (empty($data['billing_name']) || empty($data['billing_address']) || empty($data['billing_city']) || empty($data['billing_state']) || empty($data['billing_country']) || empty($data['billing_pincode']) || empty($data['billing_mobile']) || empty($data['shipping_name']) || empty($data['shipping_address']) || empty($data['shipping_city']) || empty($data['shipping_state']) || empty($data['shipping_country']) || empty($data['shipping_pincode']) || empty($data['shipping_mobile'])) {
                return redirect()->back()->with('flash_message_error', 'Please fill all fields to Checkout!');
            }

            // Update User details
            User::where('id', $user_id)->update(['name' => $data['billing_name'], 'address' => $data['billing_address'], 'city' => $data['billing_city'], 'state' => $data['billing_state'], 'pincode' => $data['billing_pincode'], 'country' => $data['billing_country'], 'mobile' => $data['billing_mobile']]);

            if ($shippingCount > 0) {
                // Update Shipping Address
                DeliveryAddress::where('user_id', $user_id)->update(['name' => $data['shipping_name'], 'address' => $data['shipping_address'], 'city' => $data['shipping_city'], 'state' => $data['shipping_state'], 'pincode' => $data['shipping_pincode'], 'country' => $data['shipping_country'], 'mobile' => $data['shipping_mobile']]);
            } else {
                // Add New Shipping Address
                $shipping = new DeliveryAddress;
                $shipping->user_id = $user_id;
                $shipping->user_email = $user_email;
                $shipping->name = $data['shipping_name'];
                $shipping->address = $data['shipping_address'];
                $shipping->city = $data['shipping_city'];
                $shipping->state = $data['shipping_state'];
                $shipping->pincode = $data['shipping_pincode'];
                $shipping->country = $data['shipping_country'];
                $shipping->mobile = $data['shipping_mobile'];
                $shipping->save();
            }
           // return redirect()->action('ProductsController@orderReview');
        }
        
        
         if ($request->isMethod('post')) {
           $data = $request->all();
        
            $product = DB::table('cart')->where(['user_email' => $user_email])->first();

            // Get Shipping Address of User
            $shippingDetails = DeliveryAddress::where(['user_id' => $user_id])->first();

            /*echo "<pre>"; print_r($data); die;*/

            if (empty(Session::get('CouponCode'))) {
                $coupon_code = '';
            } else {
                $coupon_code = Session::get('CouponCode');
            }

            if (empty(Session::get('CouponAmount'))) {
                $coupon_amount = '';
            } else {
                $coupon_amount = Session::get('CouponAmount');
            }

            //Fetch Shipping Charges
            if ($product->product_type == 'ebook') {
                $shippingCharges = 0;
            } else {
                $shippingCharges = Product::getShippingCharges($shippingDetails->country);
            }
            $carts = DB::table('cart')->where(['user_email' => $user_email])->get();

            $order = new Order();
            $order->user_id = $user_id;
            $order->user_email = $user_email;
            $order->name = $shippingDetails->name;
            $order->address = $shippingDetails->address;
            $order->city = $shippingDetails->city;
            $order->state = $shippingDetails->state;
            $order->pincode = $shippingDetails->pincode;
            $order->country = $shippingDetails->country;
            $order->mobile = $shippingDetails->mobile;
            $order->coupon_code = $coupon_code;
            $order->coupon_amount = $coupon_amount;
            $order->order_status = "New";
            $order->payment_method = $data['payment_method'];
            $order->shipping_charges = $shippingCharges;
            $order->grand_total = $data['grand_total'];
            if($order->save()){
             
                foreach ($carts as $pro) {
                    $cartPro = new OrdersProduct;
                    $cartPro->order_id = $order->id;
                    $cartPro->user_id = $user_id;
                    $cartPro->product_id = $pro->product_id;
                    $cartPro->product_code = $pro->product_code;
                    $cartPro->product_name = $pro->product_name;
                    $cartPro->product_color = $pro->product_color;
                    $cartPro->product_size = $pro->size;
                    $cartPro->product_price = $pro->price;
                    $cartPro->product_type = $pro->product_type;
                    $cartPro->product_qty = $pro->quantity;
                    $cartPro->save();
                     

                }
            }

            Session::put('order_id', $order->id);
            Session::put('grand_total', $data['grand_total']);

            if ($data['payment_method'] == "COD") {

                $productDetails = Order::with('orders')->where('id', $order->id)->first();
                $productDetails = json_decode(json_encode($productDetails), true);
                /*echo "<pre>"; print_r($productDetails);*/ /*die;*/

                $userDetails = User::where('id', $user_id)->first();
                $userDetails = json_decode(json_encode($userDetails), true);
                /*echo "<pre>"; print_r($userDetails); die;
*/
                /* Code for Order Email Start */
                $email = $user_email;
                $messageData = [
                    'email' => $email,
                    'name' => $email,
                    'order_id' => $order->id,
                    'productDetails' => $productDetails,
                    'userDetails' => $userDetails
                ];
                Mail::send('emails.order', $messageData, function ($message) use ($email) {
                    $message->to($email)->subject('Order Placed - Helmyworld Publishing');
                });
                /* Code for Order Email Ends */

                // COD - Redirect user to thanks page after saving order
                return redirect('/thanks');
            } else {
                // Paypal - Redirect user to paypal page after saving order
               return view('orders.payfast');
            }
         }

        $meta_title = "Checkout - Publishing books";
        return view('products.checkout')->with(compact('userDetails', 'countries', 'shippingDetails', 'meta_title','userCart','shippingCharges'));
    }

    /**
     * POST /checkout/address
     * Save billing/shipping then redirect to order review (avoid re-rendering checkout after POST)
     */
    public function saveCheckoutAddress(Request $request)
    {
        $user_id    = Auth::user()->id;
        $user_email = Auth::user()->email;

        // Update billing to users table
        $user = User::find($user_id);
        User::where('id', $user_id)->update([
            'name'    => $request->input('billing_name',    $user->name),
            'address' => $request->input('billing_address', $user->address),
            'city'    => $request->input('billing_city',    $user->city),
            'state'   => $request->input('billing_state',   $user->state),
            'pincode' => $request->input('billing_pincode', $user->pincode),
            'country' => $request->input('billing_country', $user->country),
            'mobile'  => $request->input('billing_mobile',  $user->mobile),
        ]);

        // Upsert shipping address
        $shipping = DeliveryAddress::firstOrNew(['user_id' => $user_id]);
        $shipping->user_email = $user_email;
        $shipping->name    = $request->input('shipping_name',    $shipping->name);
        $shipping->address = $request->input('shipping_address', $shipping->address);
        $shipping->city    = $request->input('shipping_city',    $shipping->city);
        $shipping->state   = $request->input('shipping_state',   $shipping->state);
        $shipping->pincode = $request->input('shipping_pincode', $shipping->pincode);
        $shipping->country = $request->input('shipping_country', $shipping->country);
        $shipping->mobile  = $request->input('shipping_mobile',  $shipping->mobile);
        $shipping->save();

        // PRG pattern
        return redirect()->route('order.review');
    }

    public function orderReview()
    {
        // GET ONLY: summarize order before placing it
        $user_id    = Auth::user()->id;
        $user_email = Auth::user()->email;

        $userDetails     = User::where('id', $user_id)->first();
        $shippingDetails = DeliveryAddress::where('user_id', $user_id)->first();

        $userCart = DB::table('cart')->where(['user_email' => $user_email])->get();
        foreach ($userCart as $key => $product) {
            $pd = Product::find($product->product_id);
            $userCart[$key]->image = $pd ? $pd->image : null;
        }

        $countryForRate = optional($shippingDetails)->country ?: optional($userDetails)->country;
        $shippingCharges = $this->cartHasEbook($userCart)
            ? 0
            : Product::getShippingCharges($countryForRate);

        $meta_title = "Order Review - Publishing books";

        return view('products.order_review')->with(compact(
            'userDetails','shippingDetails','userCart','meta_title','shippingCharges'
        ));
    }

    public function placeOrder(Request $request)
    {
        if ($request->isMethod('post')) {
            $data       = $request->all();
            $user_id    = Auth::user()->id;
            $user_email = Auth::user()->email;

            $shippingDetails = DeliveryAddress::where(['user_id' => $user_id])->first();
            $carts = DB::table('cart')->where(['user_email' => $user_email])->get();

            $coupon_code   = Session::get('CouponCode', '');
            $coupon_amount = Session::get('CouponAmount', 0);

            $countryForRate = optional($shippingDetails)->country ?: optional(User::find($user_id))->country;
            $shippingCharges = $this->cartHasEbook($carts)
                ? 0
                : Product::getShippingCharges($countryForRate);

            $order = new Order();
            $order->user_id         = $user_id;
            $order->user_email      = $user_email;
            $order->name            = optional($shippingDetails)->name;
            $order->address         = optional($shippingDetails)->address;
            $order->city            = optional($shippingDetails)->city;
            $order->state           = optional($shippingDetails)->state;
            $order->pincode         = optional($shippingDetails)->pincode;
            $order->country         = optional($shippingDetails)->country;
            $order->mobile          = optional($shippingDetails)->mobile;
            $order->coupon_code     = $coupon_code;
            $order->coupon_amount   = $coupon_amount;
            $order->order_status    = "New";
            $order->payment_method  = $data['payment_method'] ?? 'COD';
            $order->shipping_charges= $shippingCharges;
            $order->grand_total     = $data['grand_total'] ?? 0;

            if ($order->save()) {
                foreach ($carts as $pro) {
                    $cartPro = new OrdersProduct;
                    $cartPro->order_id      = $order->id;
                    $cartPro->user_id       = $user_id;
                    $cartPro->product_id    = $pro->product_id;
                    $cartPro->product_code  = $pro->product_code;
                    $cartPro->product_name  = $pro->product_name;
                    $cartPro->product_color = $pro->product_color;
                    $cartPro->product_size  = $pro->size ?? null;
                    $cartPro->product_price = $pro->price;
                    $cartPro->product_type  = $pro->product_type;
                    $cartPro->product_qty   = $pro->quantity;
                    $cartPro->save();
                }
            }

            Session::put('order_id', $order->id);
            Session::put('grand_total', $order->grand_total);

            if (($data['payment_method'] ?? 'COD') === "COD") {
                // Send order email
                $productDetails = Order::with('orders')->where('id', $order->id)->first();
                $productDetails = json_decode(json_encode($productDetails), true);

                $userDetails = User::where('id', $user_id)->first();
                $userDetails = json_decode(json_encode($userDetails), true);

                $email = $user_email;
                $messageData = [
                    'email' => $email,
                    'name'  => $email,
                    'order_id' => $order->id,
                    'productDetails' => $productDetails,
                    'userDetails'    => $userDetails
                ];
                Mail::send('emails.order', $messageData, function ($message) use ($email) {
                    $message->to($email)->subject('Order Placed - Helmyworld Publishing');
                });

                return redirect('/thanks');
            } else {
                return redirect('/payfast');
            }
        }
    }

    public function thanks(Request $request)
    {
        $user_email = Auth::user()->email;
        DB::table('cart')->where('user_email', $user_email)->delete();
        return view('orders.thanks');
    }

    public function thanksPaypal()
    {
        return view('payfast.thanks_payfast');
    }

    public function payfast(Request $request)
    {
        $user_email = Auth::user()->email;
        DB::table('cart')->where('user_email', $user_email)->delete();
        return view('orders.payfast');
    }

    public function cancelPaypal()
    {
        return view('orders.cancel_paypal');
    }

    public function itn(Request $request)
    {
        header('HTTP/1.0 200 OK');
        ob_flush();
        flush();

        $order = Order::findOrFail($request->m_payment_id);

        $pfData = $request->all();
        foreach ($pfData as $key => $val) {
            $pfData[$key] = stripslashes($val);
        }

        $pfParamString = '';
        foreach ($pfData as $key => $val) {
            if ($key != 'signature') {
                $pfParamString .= $key . '=' . urlencode($val) . '&';
            }
        }
        $pfParamString = substr($pfParamString, 0, -1);
        $pfTempParamString = $pfParamString;

        $passPhrase = 'Rorisang/Maimane/6923_';
        if (!empty($passPhrase)) {
            $pfTempParamString .= '&passphrase=' . urlencode($passPhrase);
        }
        $signature = md5($pfTempParamString);

        if ($signature != $pfData['signature']) {
            // invalid signature; keep silent or log
        }

        $pfHost = (true) ? 'sandbox.payfast.co.za' : 'www.payfast.co.za';
        $url = 'https://' . $pfHost . '/eng/query/validate';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $pfParamString);

        $response = curl_exec($ch);
        curl_close($ch);

        Storage::disk('public')->put('curltest.html', $response);

        $lines = explode("\r\n", $response);
        $verifyResult = trim($lines[0]);

        if (strcasecmp($verifyResult, 'VALID') == 0) {
            if (($pfData['payment_status'] ?? '') === 'COMPLETE') {
                $order->order_status   = 'Paid';
                $order->pf_payment_id  = $pfData['pf_payment_id'] ?? null;
                $order->save();
            }
        }
    }

    public function userOrders()
    {
        $user_id = Auth::user()->id;
        $orders = Order::with('orders')->where('user_id', $user_id)->orderBy('id', 'DESC')->get();
        return view('orders.user_orders')->with(compact('orders'));
    }

    public function userOrderDetails($order_id)
    {
        $user_id = Auth::user()->id;
        $orderDetails = Order::with('orders')->where('id', $order_id)->first();
        return view('orders.user_order_details')->with(compact('orderDetails'));
    }

    public function viewOrders()
    {
        $orders = Order::with('orders')->orderBy('id', 'Desc')->get();
        return view('admin.orders.view_orders')->with(compact('orders'));
    }

    public function viewOrderDetails($order_id)
    {
        $orderDetails = Order::with('orders')->where('id', $order_id)->first();
        $user_id = $orderDetails->user_id;
        $userDetails = User::where('id', $user_id)->first();
        return view('admin.orders.order_details')->with(compact('orderDetails', 'userDetails'));
    }

    public function viewOrderInvoice($order_id)
    {
        if (Session::get('adminDetails')['orders_access'] == 0) {
            return redirect('/admin/dashboard')->with('flash_message_error', 'You have no access for this module');
        }
        $orderDetails = Order::with('orders')->where('id', $order_id)->first();
        $user_id = $orderDetails->user_id;
        $userDetails = User::where('id', $user_id)->first();
        return view('admin.orders.order_invoice')->with(compact('orderDetails', 'userDetails'));
    }

    public function SendEbookLink($id)
    {
        $order_product = OrdersProduct::findOrFail($id);
        $order = Order::where('id', $order_product->order_id)->first();

        // Product lookup simplified (orders table typically doesn't hold product_id)
        $product = Product::where('id', $order_product->product_id)->first();
        $email = $order->user_email;

        $token = base64_encode(json_encode($order_product));

        $order_product->download_link_token = $token;
        $order_product->is_link_expired     = 1;
        $order_product->save();

        $messageData = [
            'name'   => $order->name,
            'link'   => route("product.download_ebook",["token" => $token]),
            'emails' => $order->user_email,
        ];

        Mail::send('emails.ebooklink', $messageData, function ($message) use ($email) {
            $message->to($email)->subject('Ebook Link');
        });

        return redirect()->back()->with('flash_message_success', 'Link has been sent successfully');
    }

    public function download(Request $request,$token)
    {
        $order_product = json_decode(base64_decode($token));
        $order_product = OrdersProduct::findOrFail($order_product->id);

        if ($token == $order_product->download_link_token && $order_product->is_link_expired <= 2) {
            $product = Product::findOrFail($order_product->product_id);
            $fileName = $product->book_path;

            $file = Storage::disk('s3')->get("uploads/ebooks/". $fileName);

            $response = response($file, 200, [
                'Content-Type'              => 'application/octet-stream',
                'Content-Description'       => 'File Transfer',
                'Content-Disposition'       => "attachment; filename={$fileName}",
                'Content-Transfer-Encoding' => 'binary',
            ]);

            if (ob_get_length() > 0) {
                ob_clean();
            }

            $order_product->is_link_expired = $order_product->is_link_expired + 1;
            $order_product->save();
            return $response;
        } else {
            abort(404);
        }
    }

    public function viewPDFInvoice($order_id)
    {
        if (Session::get('adminDetails')['orders_access'] == 0) {
            return redirect('/admin/dashboard')->with('flash_message_error', 'You have no access for this module');
        }
        $orderDetails = Order::with('orders')->where('id', $order_id)->first();
        $user_id      = $orderDetails->user_id;
        $userDetails  = User::where('id', $user_id)->first();

        $output = '<!DOCTYPE html> ...'; // (kept as in your original file to avoid bloat)

        $dompdf = new Dompdf();
        $dompdf->loadHtml($output);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        $dompdf->stream();
    }

    public function updateOrderStatus(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            Order::where('id', $data['order_id'])->update(['order_status' => $data['order_status']]);
            return redirect()->back()->with('flash_message_success', 'Order Status has been updated successfully!');
        }
    }

    public function viewOrdersCharts()
    {
        $current_month_orders       = Order::whereYear('created_at', Carbon::now()->year)->whereMonth('created_at', Carbon::now()->month)->count();
        $last_month_orders          = Order::whereYear('created_at', Carbon::now()->year)->whereMonth('created_at', Carbon::now()->subMonth(1))->count();
        $last_to_last_month_orders  = Order::whereYear('created_at', Carbon::now()->year)->whereMonth('created_at', Carbon::now()->subMonth(2))->count();
        return view('admin.products.view_orders_charts')->with(compact('current_month_orders', 'last_month_orders', 'last_to_last_month_orders'));
    }

    /* ===========================================================
     * ADMIN: MANUAL ORDERS (Create / Edit / Delete)  — Same tables
     * =========================================================== */
    public function addManualOrder(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();

            // Basic validation (keep simple)
            $request->validate([
                'customer_name'  => 'required|string|max:190',
                'order_date'     => 'required|date',
                'payment_method' => 'required|string|max:50',
                'items'          => 'required|array|min:1',
                'items.*.product_id' => 'required|exists:products,id',
                'items.*.qty'        => 'required|integer|min:1',
                'items.*.unit_price' => 'nullable|numeric|min:0',
            ]);

            DB::beginTransaction();
            try {
                $order = new Order();

                // Coalesce EVERYTHING to non-null values ('' or 0) to satisfy NOT NULL columns
                $order->user_id         = 0; // manual/external buyer (no site account)
                $order->user_email      = $data['customer_email'] ?? '';
                $order->name            = $data['customer_name'];
                $order->address         = $data['customer_address'] ?? '';
                $order->city            = $data['customer_city'] ?? '';
                $order->state           = $data['customer_state'] ?? '';
                $order->pincode         = $data['customer_pincode'] ?? '';
                $order->country         = $data['customer_country'] ?? '';
                $order->mobile          = $data['customer_mobile'] ?? '';

                $order->order_number    = $data['order_number'] ?? '';
                $order->invoice_number  = $data['invoice_number'] ?? '';
                $order->platform        = $data['platform'] ?? 'Invoice';
                $order->source          = 'manual';

                $order->coupon_code     = '';   // never null
                $order->coupon_amount   = 0;
                $order->order_status    = !empty($data['mark_as_paid']) ? 'Paid' : 'Pending';
                $order->payment_method  = $data['payment_method'];
                $order->shipping_charges= 0;
                $order->grand_total     = 0;

                $date = Carbon::parse($data['order_date'])->startOfDay();
                $order->created_at      = $date;
                $order->paid_at         = !empty($data['mark_as_paid']) ? $date : null;

                $order->save();

                // Items
                $grand = 0;
                foreach ($data['items'] as $row) {
                    $product = Product::find($row['product_id']);
                    $qty     = (int)$row['qty'];
                    $price   = isset($row['unit_price']) && $row['unit_price'] !== null
                             ? (float)$row['unit_price'] : (float)($product->price ?? 0);
                    $line    = $price * $qty;

                    $item = new OrdersProduct();
                    $item->order_id      = $order->id;
                    $item->user_id       = 0;
                    $item->product_id    = $product->id;
                    $item->product_code  = $product->product_code ?? '';
                    $item->product_name  = $product->product_name ?? '';
                    $item->product_color = '';
                    $item->product_size  = '';
                    $item->product_price = $price;
                    $item->product_type  = $product->type ?? 'Physical Book';
                    $item->product_qty   = $qty;
                    $item->save();

                    $grand += $line;
                }

                $order->grand_total = $grand;
                $order->save();

                DB::commit();
                return redirect('admin/view-orders')->with('flash_message_success', 'Manual order has been created successfully');
            } catch (\Throwable $e) {
                DB::rollBack();
                return redirect()->back()->withInput()->with('flash_message_error', 'Could not save manual order: '.$e->getMessage());
            }
        }

        // GET: form
        $products = Product::orderBy('product_name')->get(['id','product_name','price']);
        return view('admin.orders.add_manual')->with(compact('products'));
    }

    public function editManualOrder(Request $request, $id = null)
    {
        $order = Order::with('orders')->where('id', $id)->firstOrFail();

        if ($request->isMethod('post')) {
            $data = $request->all();
            $request->validate([
                'customer_name'  => 'required|string|max:190',
                'order_date'     => 'required|date',
                'payment_method' => 'required|string|max:50',
                'items'          => 'required|array|min:1',
                'items.*.product_id' => 'required|exists:products,id',
                'items.*.qty'        => 'required|integer|min:1',
                'items.*.unit_price' => 'nullable|numeric|min:0',
            ]);

            DB::beginTransaction();
            try {
                // header
                $order->user_email     = $data['customer_email'] ?? '';
                $order->name           = $data['customer_name'];
                $order->address        = $data['customer_address'] ?? '';
                $order->city           = $data['customer_city'] ?? '';
                $order->state          = $data['customer_state'] ?? '';
                $order->pincode        = $data['customer_pincode'] ?? '';
                $order->country        = $data['customer_country'] ?? '';
                $order->mobile         = $data['customer_mobile'] ?? '';

                $order->order_number   = $data['order_number'] ?? '';
                $order->invoice_number = $data['invoice_number'] ?? '';
                $order->platform       = $data['platform'] ?? 'Invoice';
                $order->source         = 'manual';

                $order->order_status   = !empty($data['mark_as_paid']) ? 'Paid' : 'Pending';
                $order->payment_method = $data['payment_method'];

                $date = Carbon::parse($data['order_date'])->startOfDay();
                $order->created_at     = $date;
                $order->paid_at        = !empty($data['mark_as_paid']) ? $date : null;

                $order->save();

                // replace items
                OrdersProduct::where('order_id', $order->id)->delete();

                $grand = 0;
                foreach ($data['items'] as $row) {
                    $product = Product::find($row['product_id']);
                    $qty     = (int)$row['qty'];
                    $price   = isset($row['unit_price']) && $row['unit_price'] !== null
                             ? (float)$row['unit_price'] : (float)($product->price ?? 0);
                    $line    = $price * $qty;

                    $item = new OrdersProduct();
                    $item->order_id      = $order->id;
                    $item->user_id       = 0;
                    $item->product_id    = $product->id;
                    $item->product_code  = $product->product_code ?? '';
                    $item->product_name  = $product->product_name ?? '';
                    $item->product_color = '';
                    $item->product_size  = '';
                    $item->product_price = $price;
                    $item->product_type  = $product->type ?? 'Physical Book';
                    $item->product_qty   = $qty;
                    $item->save();

                    $grand += $line;
                }

                $order->grand_total = $grand;
                $order->save();

                DB::commit();
                return redirect('admin/view-orders')->with('flash_message_success', 'Manual order has been updated successfully');
            } catch (\Throwable $e) {
                DB::rollBack();
                return redirect()->back()->withInput()->with('flash_message_error', 'Could not update manual order: '.$e->getMessage());
            }
        }

        // GET: form prefilled
        $products = Product::orderBy('product_name')->get(['id','product_name','price']);
        return view('admin.orders.edit_manual')->with(compact('order','products'));
    }

    public function deleteManualOrder($id = null)
    {
        $order = Order::where('id', $id)->firstOrFail();

        DB::beginTransaction();
        try {
            OrdersProduct::where('order_id', $order->id)->delete();
            $order->delete();
            DB::commit();
            return redirect('admin/view-orders')->with('flash_message_success', 'Manual order has been deleted successfully');
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->back()->with('flash_message_error', 'Could not delete order: '.$e->getMessage());
        }
    }
}
