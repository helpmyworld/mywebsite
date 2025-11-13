<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Poster;
use Image;

class PostersController extends Controller
{
    public function addPoster(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();
            //echo "<pre>"; print_r($data); die;

            $poster = new Poster;
            $poster->title = $data['title'];
            $poster->link = $data['link'];

            if(empty($data['status'])){
                $status='0';
            }else{
                $status='1';
            }

            // Upload Image
            if($request->hasFile('image')){
                $image_tmp = Input::file('image');
                if ($image_tmp->isValid()) {
                    // Upload Images after Resize
                    $extension = $image_tmp->getClientOriginalExtension();
                    $fileName = rand(111,99999).'.'.$extension;
                    $poster_path = 'images/frontend_images/posters/'.$fileName;
                    Image::make($image_tmp)->resize(1140, 200)->save($poster_path);
                    $poster->image = $fileName;
                }
            }

            $poster->status = $status;
            $poster->save();
            return redirect()->back()->with('flash_message_success', 'Poster has been added successfully');
        }

        return view('admin.posters.add_poster');
    }

    public function editPoster(Request $request, $id=null){
        if($request->isMethod('post')){
            $data = $request->all();
            /*echo "<pre>"; print_r($data); die;*/

            if(empty($data['status'])){
                $status='0';
            }else{
                $status='1';
            }

            if(empty($data['title'])){
                $data['title'] = '';
            }

            if(empty($data['link'])){
                $data['link'] = '';
            }

            // Upload Image
            if($request->hasFile('image')){
                $image_tmp = Input::file('image');
                if ($image_tmp->isValid()) {
                    // Upload Images after Resize
                    $extension = $image_tmp->getClientOriginalExtension();
                    $fileName = rand(111,99999).'.'.$extension;
                    $poster_path = 'images/frontend_images/posters/'.$fileName;
                    Image::make($image_tmp)->resize(1140, 200)->save($poster_path);
                }
            }else if(!empty($data['current_image'])){
                $fileName = $data['current_image'];
            }else{
                $fileName = '';
            }


            Poster::where('id',$id)->update(['status'=>$status,'title'=>$data['title'],'link'=>$data['link'],'image'=>$fileName]);
            return redirect()->back()->with('flash_message_success','Poster has been edited Successfully');

        }
        $posterDetails = Poster::where('id',$id)->first();
        return view('admin.posters.edit_poster')->with(compact('posterDetails'));
    }

    public function viewposters(){
        $posters = Poster::get();
        return view('admin.posters.view_posters')->with(compact('posters'));
    }

    public function deletePoster($id = null){
        Poster::where(['id'=>$id])->delete();
        return redirect()->back()->with('flash_message_success', 'Poster has been deleted successfully');
    }


}
