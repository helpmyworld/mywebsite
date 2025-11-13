<?php

namespace App\Http\Controllers;

use App\Benefit;
use App\Capacity;
use App\Host;
use App\Post;
use App\Ebook;
use App\Category;
use App\Product;
use App\Promotion;
use App\Subscription;
use App\Work;

use App\Website;
use Mail;
use Session;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class FrontController extends Controller
{
//    public function index()
//    {
//        //i need to just show single result on my home page.
//        $books=Product::all();
//        // latest books
//        $book = $books->last();
//
//        $items=Promotion::all();
//        // latest promoted books
//        $item = $items->last();
//
//        $ebooks=Ebook::all();
//        // latest promoted books
//        $ebook = $ebooks->last();
//
//        $posts=Post::orderBy('id', 'desc')->get();
//        $books=Product::orderBy('id', 'desc')->get();
//        $ebooks=Ebook::orderBy('id', 'desc')->get();
//        return view('front.home',compact('books','book','posts', 'post','ebook','ebooks','items','item'));
//
//    }
    public function promotion ()
    {
        $subscriptions = Subscription::all();
        $benefits = Benefit::all();
        return view('front.promotion',compact('subscriptions','benefits'));
    }
    public function webdev ()
    {
        $websites = Website::all();
        $works = Work::all();


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
        return view('front.software-app-development',compact('websites','works','categories_menu','categories'));
    }

    public function hosting ()
    {
        $hosts = Host::all();
        $capacities = Capacity::all();

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
        return view('front.hosting-internet',compact('hosts','capacities','categories_menu','categories'));
    }
    public function submission ()
    {
//        $subscriptions = Subscription::all();
//        $benefits = Benefit::all();

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
        return view('front.manuscript-submissions')->with(compact('categories_menu','categories'));
    }

    public function about()
    {
    
        return view('front.about');
    }
    
    public function getContact()
    {
        return view('front.contact');
    }
      public function postContact(Request $request) {
        $this->validate($request, [
            'email' => 'required|email',
            'subject' => 'min:3',
            'g-recaptcha-response' => 'required|captcha',
            'message' => 'min:10']);


        $data = array(
            'email' => $request->email,
            'subject' => $request->subject,
            'bodyMessage' => $request->message
        );

        Mail::send('emails.contact', $data, function($message) use ($data){
            $message->from($data['email']);
            $message->to('rorisang@helpmyworld.co.za');
            $message->subject($data['subject']);
        });

        $token = $request->input('g-recaptcha-response');
//        dd($token);

        if ($token) {
            $client = new Client();
            $response = $client->post('https://www.google.com/recaptcha/api/siteverify', [
                'form_params' => array(
                    'secret'    => '6LcXhZEUAAAAAKvNzqppgGoc4CmL_A9hRuolwJ5e',
                    'response'  => $token
                )
            ]);
            $results = json_decode($response->getBody()->getContents());

            if ($results->success) {
                Session::flash('success', 'Yes we know you are human');
                return view('email')->withEmail($email)->withSubject($subject);
            } else {
                Session::flash('error', 'You are probably a robot!');
                return redirect('/contact');
            }
            # we know it was submitted
        } else {
            return redirect('/');
        }



        Session::flash('success', 'Your Email was Sent!');

        return redirect('/');
    }

    public function services()
    {
        return view('front.services');
    }
//    public function author()
//    {
//        return view('front.author',compact('author'));
//    }
//
//
//    public function career()
//    {
//        return view('front.career',compact('career'));
//    }
//    public function support()
//    {
//        return view('front.support',compact('support'));
//    }
//
//    public function privacy()
//    {
//        return view('front.privacy-policy',compact('privacy-policy'));
//    }
//
//    public function terms()
//    {
//        return view('front.terms-and-conditions',compact('terms-and-conditions'));
//    }
//
//    public function shipping()
//    {
//        return view('front.shipping-policy',compact('shipping-policy'));
//    }
//    public function cancellation()
//    {
//        return view('front.cancellation-refund',compact('cancellation-refund'));
//    }
}
