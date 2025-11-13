<?php

namespace App\Http\Controllers;

use App\CmsPage;
use App\Category;
//use App\Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class CmsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function addCmsPage(Request $request)
    {
        if($request->isMethod('post')){
            $data = $request->all();
//            echo "<pre>"; print_r($data); die;
            if(empty($data['meta_title'])){
                $data['meta_title'] = "";
            }
            if(empty($data['meta_description'])){
                $data['meta_description'] = "";
            }
            if(empty($data['meta_keywords'])){
                $data['meta_keywords'] = "";
            }
            $cmspage = new CmsPage;
            $cmspage->title = $data['title'];
            $cmspage->url =$data['url'];
            $cmspage->description =$data['description'];
            $cmspage->meta_title =$data['meta_title'];
            $cmspage->meta_description =$data['meta_description'];
            $cmspage->meta_keywords =$data['meta_keywords'];
            if(empty($data['status'])){
                $status='0';
            }else{
                $status='1';
            }
            $cmspage->status = $status;
            $cmspage->save();
            return redirect()->back()->with('flash_message_success', 'CMS Page has been added successfully');
        }
        return view('admin.pages.add_cms_page');

    }

    public function viewCmsPages(){

        $cmsPages = CmsPage::get();
        $cmsPages = json_decode(json_encode($cmsPages));
//        echo "<pre>"; print_r($cmsPages); die;
        return view('admin.pages.view_cms_pages')->with(compact('cmsPages'));

    }

    public function editCmsPage(Request $request,$id){
        if($request->isMethod('post')){
            $data = $request->all();
//            $cmsPage = json_decode(json_encode($cmsPage));
//            echo "<pre>"; print_r($data); die;

            if(empty($data['status'])){
                $status = '0';
            }else{
                $status = '1';
            }
            if(empty($data['meta_title'])){
                $data['meta_title'] = "";
            }
            if(empty($data['meta_description'])){
                $data['meta_description'] = "";
            }
            if(empty($data['meta_keywords'])){
                $data['meta_keywords'] = "";
            }
            CmsPage::where(['id'=>$id])->first()->update(['status'=>$status,'title'=>$data['title'], 'url'=>$data['url'],'description'=>$data['description'],
                'meta_title'=>$data['meta_title'],'meta_description'=>$data['meta_description'],'meta_keywords'=>$data['meta_keywords']]);
            return redirect()->back()->with('flash_message_success', 'CMS Page has been updated successfully');
        }
        $cmsPage = CmsPage::where('id',$id)->first();
        return view('admin.pages.edit_cms_page')->with(compact('cmsPage'));
    }

    public function deleteCmsPage($id){
        CmsPage::where('id',$id)->delete();
        return redirect('/admin/view-cms-pages')->with('flash_message_success', 'CMS Page has been deleted successfully');
    }

    public function cmsPage($url){

         CmsPage::find(['url', $url, 'status'=>1])->count();
         // Get All CMS Page details
        $cmsPageDetails = CmsPage::where('url', $url)->first();
        //Meta tags
        $meta_title = $cmsPageDetails->meta_title;
        $meta_description = $cmsPageDetails->meta_description;
        $meta_keywords = $cmsPageDetails->meta_keywords;

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

        return view ('pages.cms_pages')->with(compact('cmsPageDetails','categories_menu', 'categories', 'meta_title','meta_description', 'meta_keywords' ));
    }
    public function contact(Request $request)
    {
        if($request->isMethod('post')){
            $data = $request->all();

            $email = "rorisang@helpmyworld.co.za";
            $messageData = [
                'name' =>$data['name'],
                'email' =>$data['email'],
                'subject' =>$data['subject'],
                'comment' =>$data['message']
            ];
            Mail::send('emails.enquiry', $messageData,function ($message)use($email){
                $message->to($email)->subject('Enquiry from Helpmyworld Publishing');
            });

            return redirect()->back()->with('flash_message_success', 'Thanks for your enquiry. We will get 
            back to you soon');
        }

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
//Meta tags
        $meta_title = "Helpmyworld";
        $meta_description = "Publishers for Authors";
        $meta_keywords = "Printing books, Publish books, Book design, Book printing";
        return view('pages.contact')->with(compact('categories_menu', 'categories', 'meta_title','meta_description', 'meta_keywords'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

}
