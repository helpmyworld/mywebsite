<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Category;
use App\Product;
use App\User;
use App\Post;
use App\Banner;
use App\Poster;
use Validator;
use Mail;
use Session;
use GuzzleHttp\Client;
use Spatie\Newsletter\Newsletter;


class IndexController extends Controller
{
  
    public function index()
    {
        // Get all Products
        $productsAll = Product::where('type', 'Physical Book')->where('status',  1)->where('approved',true)->orderBy("id","desc")->paginate(6);
        $ebooksAll = Product::where('type', 'ebook')->where('status',  1)->where('approved',true)->orderBy("id","desc")->paginate(3);

       // $productsAll = Product::where('type', 'physical')->where('status', 1)->where('approved',true)->orwhere('feature_item', 1)->paginate(6);
       // $productsAll = json_decode(json_encode($productsAll))->paginate(6);
        /*dump($productsAll);*/
       // echo "<pre>"; print_r($productsAll);die;



        // Get All Categories and Sub Categories
        $categories_menu = "";
        $categories = Category::with('categories')->where(['parent_id' => 0])->get();
        $categories = json_decode(json_encode($categories));
        /*echo "<pre>"; print_r($categories); die;*/
        foreach ($categories as $cat) {
            $categories_menu .= "
			<div class='panel-heading'>
				<h4 class='panel-title'>
					<a data-toggle='collapse' data-parent='#accordian' href='#" . $cat->id . "'>
						<span class='badge pull-right'><i class='fa fa-plus'></i></span>
						" . $cat->name . "
					</a>
				</h4>
			</div>
			<div id='" . $cat->id . "' class='panel-collapse collapse'>
				<div class='panel-body'>
					<ul>";
            $sub_categories = Category::where(['parent_id' => $cat->id])->get();
            foreach ($sub_categories as $sub_cat) {
                $categories_menu .= "<li><a href='#'>" . $sub_cat->name . " </a></li>";
            }
            $categories_menu .= "</ul>
				</div>
			</div>
			";
        }

            $featuredAuthors = User::select('id','name','bio','profile_image as image','slug')
            ->where('type', 'Author')
            ->where('status', 1)
            ->where('featured_author', 1)
            ->latest('created_at')
            ->take(4)
            ->get();


                // Featured Products (existing)
        $featuredProducts = Product::where('status', 1)
            ->where('is_featured', 1)
            ->take(4)
            ->get();

        // New Arrivals (exactly 4)
        $newArrivals = Product::where('status', 1)
            ->where('is_new_arrival', 1)
            ->orderBy('id', 'desc')
            ->take(4)
            ->get();


          // SPECIAL OFFERS
            $specialOffers = \App\Product::where('status', 1)
                ->where('is_special_offer', 1)
                ->orderBy('id', 'desc')
                ->take(4)
                ->get();


        // NOVELS (category by name)
        $novelsCategoryId = Category::where('name', 'Novels')->value('id');

        $novelBooks = $novelsCategoryId
            ? Product::where('status', 1)
                ->where('category_id', $novelsCategoryId)
                ->orderBy('id', 'desc')
                ->take(12)
                ->get()
            : collect(); // empty if category not found



        // Best Sellers (you can change the number)
        $bestSellers = Product::where('status', 1)
            ->where('is_best_seller', 1)
            ->orderBy('id', 'desc')
            ->take(4)
            ->get();


             // ✅ CHILDREN’S BOOKS (fetching by category name only)
        $childrenBooks = collect();
        $childrenCategory = Category::whereRaw('LOWER(name) = ?', ['children'])->first();

        if ($childrenCategory) {
            // Get this category + its subcategories
            $childrenCategoryIds = Category::where('parent_id', $childrenCategory->id)
                ->pluck('id')
                ->push($childrenCategory->id);

            $childrenBooks = Product::where('status', 1)
                ->whereIn('category_id', $childrenCategoryIds)
                ->orderBy('id', 'desc')
                ->take(12)
                ->get();
        }


        // BIOGRAPHIES BOOKS (only products under the "Biographies" category)
$biographyBooks = collect();
$biographyCategory = Category::whereRaw('LOWER(name) = ?', ['biographies'])->first();

if ($biographyCategory) {
    $biographyCategoryIds = Category::where('parent_id', $biographyCategory->id)
        ->pluck('id')
        ->push($biographyCategory->id);

    $biographyBooks = Product::where('status', 1)
        ->whereIn('category_id', $biographyCategoryIds)
        ->orderBy('id', 'desc')
        ->take(12)
        ->get();
}



        $banners = Banner::where('status', '1')->get();
        $posters = Poster::where('status', '1')->get();
        $posts = Post::orderBy('created_at', 'desc')->paginate(6);

        //Meta tags
        $meta_title = "Helpmyworld Publishing";
        $meta_description = "Book Publishers passionate about the life-changing power of the communities. we stock the largest variety of south african products";
        $meta_keywords = "best local south african books, jonanthan ball, my first book of southern african birds : vol 2, field guide to south african mushrooms,louis botha. karoo ii, becoming him a trans memoir of triumph pdf, pdf books, freed books, exclusive books, download books best books, pdf books download,
         books online, richest families in south africa, online books, pdf download, wits press, download free books, zemk inkomo magwalandini, bullet in the heart, books to read, free books pdf, jacana media, vernon head. on that wave of gulls, bargain books, bible books, free pdf books download,
          reading books, romance books, story books, google books, amazon books, takealot books, reading books online, kids books, kindle, kindle books, loot.co.za books, 
          robert greene books pdfdrive.com books, cover for books, dark romance books, wordsworth books, atomic habits, 
        where to download books for free, cum books centurion mall, sarah j maas books, kindle unlimited cum books bloemfontein, south africa, books south africa, books, 
        kindle direct publishing, publishing companies, publishing companies in south africa, what is publishing, cheapest printers in south africa, printers in pretoria";
        return view('index')->with(compact('productsAll','ebooksAll', 'categories_menu', 'categories', 'banners', 'posts', 'posters',
            'meta_title','meta_description', 'meta_keywords',  'featuredAuthors', 'newArrivals', 'bestSellers', 'featuredProducts', 'childrenBooks', 'biographyBooks',  'specialOffers', 'novelBooks'));


    }

    public function products()

    {
        // Get all Products
        $productsAll = Product::inRandomOrder()->where('status',1)->get();
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

//        $banners = Banner::where('status','1')->get();

        return view('products.index')->with(compact('productsAll','categories_menu','categories','banners'));
    }






    public function support()
    {
        return view('front.support',compact('support'));
    }

    public function privacy()
    {
        return view('front.privacy-policy',compact('privacy-policy'));
    }

    public function terms()
    {
        return view('front.terms-and-conditions',compact('terms-and-conditions'));
    }

    public function shipping()
    {
        return view('front.shipping-policy',compact('shipping-policy'));
    }
    public function cancellation()
    {
        return view('front.cancellation-refund',compact('cancellation-refund'));
    }
}
