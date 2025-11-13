<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Banner;
use Image;

class BannersController extends Controller
{
    public function addBanner(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();

            $banner = new Banner;
            // keep your existing fields
            $banner->title = $data['title'] ?? '';
            $banner->link  = $data['link']  ?? '';
            // NEW: description
            $banner->description = $data['description'] ?? '';

            $status = !empty($data['status']) ? '1' : '0';

            // Upload Image (standardized to large/medium/small like products & users)
            if($request->hasFile('image')){
                $image_tmp = $request->file('image');
                if ($image_tmp->isValid()) {
                    $extension = $image_tmp->getClientOriginalExtension();
                    $fileName  = rand(111,99999).'.'.$extension;

                    // target folders
                    $large_path  = 'images/frontend_images/banners/large/'.$fileName;
                    $medium_path = 'images/frontend_images/banners/medium/'.$fileName;
                    $small_path  = 'images/frontend_images/banners/small/'.$fileName;

                    // ensure directories exist (idempotent)
                    @mkdir(public_path('images/frontend_images/banners/large'), 0775, true);
                    @mkdir(public_path('images/frontend_images/banners/medium'), 0775, true);
                    @mkdir(public_path('images/frontend_images/banners/small'), 0775, true);

                    // create sizes (keep your original 1146x441 as "large")
                    Image::make($image_tmp)->resize(770, 494)->save(public_path($large_path));
                    Image::make($image_tmp)->resize(770, 494)->save(public_path($medium_path));
                    Image::make($image_tmp)->resize(770, 494)->save(public_path($small_path));

                    // store filename in DB (consistent with products/users)
                    $banner->image = $fileName;
                }
            }

            $banner->status = $status;
            $banner->save();

            return redirect()->back()->with('flash_message_success', 'Banner has been added successfully');
        }

        return view('admin.banners.add_banner');
    }

    public function editBanner(Request $request, $id=null){
        if($request->isMethod('post')){
            $data = $request->all();

            $status = !empty($data['status']) ? '1' : '0';
            if(empty($data['title'])){ $data['title'] = ''; }
            if(empty($data['link'])){  $data['link']  = ''; }
            // NEW: description default
            if(empty($data['description'])){ $data['description'] = ''; }

            // Upload Image (standardized sizes)
            if($request->hasFile('image')){
                $image_tmp = $request->file('image');
                if ($image_tmp->isValid()) {
                    $extension = $image_tmp->getClientOriginalExtension();
                    $fileName  = rand(111,99999).'.'.$extension;

                    $large_path  = 'images/frontend_images/banners/large/'.$fileName;
                    $medium_path = 'images/frontend_images/banners/medium/'.$fileName;
                    $small_path  = 'images/frontend_images/banners/small/'.$fileName;

                    @mkdir(public_path('images/frontend_images/banners/large'), 0775, true);
                    @mkdir(public_path('images/frontend_images/banners/medium'), 0775, true);
                    @mkdir(public_path('images/frontend_images/banners/small'), 0775, true);

                    Image::make($image_tmp)->resize(770, 494)->save(public_path($large_path));
                    Image::make($image_tmp)->resize(770, 494)->save(public_path($medium_path));
                    Image::make($image_tmp)->resize(770, 494)->save(public_path($small_path));
                }
            } elseif(!empty($data['current_image'])){
                $fileName = $data['current_image'];
            } else {
                $fileName = '';
            }

            Banner::where('id',$id)->update([
                'status'      => $status,
                'title'       => $data['title'],
                'link'        => $data['link'],
                // NEW: description
                'description' => $data['description'],
                'image'       => $fileName
            ]);

            return redirect()->back()->with('flash_message_success','Banner has been edited Successfully');
        }

        $bannerDetails = Banner::where('id',$id)->first();
        return view('admin.banners.edit_banner')->with(compact('bannerDetails'));
    }

    public function viewBanners(){
        $banners = Banner::get();
        return view('admin.banners.view_banners')->with(compact('banners'));
    }

    public function deleteBanner($id = null){
        Banner::where(['id'=>$id])->delete();
        return redirect()->back()->with('flash_message_success', 'Banner has been deleted successfully');
    }
}
