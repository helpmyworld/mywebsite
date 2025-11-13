<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TypeController extends Controller
{
    public function addType(Request $request){
    	if($request->isMethod('post')){
    		$data = $request->all();
    		//echo "<pre>"; print_r($data); die;

            if(empty($data['status'])){
                $status='0';
            }else{
                $status='1';
            }

    		$type = new Type;
    		$type->name = $data['type_name'];
            $type->parent_id = $data['parent_id'];
    		$type->url = $data['url'];
            $type->status = $status;
            $type->meta_title =$data['meta_title'];
            $type->meta_description =$data['meta_description'];
            $type->meta_keywords =$data['meta_keywords'];
    		$type->save();
    		return redirect()->back()->with('flash_message_success', 'Book Type has been added successfully');
    	}

        $levels = Type::where(['parent_id'=>0])->get();
    	return view('admin.type.add_type')->with(compact('levels'));
    }

    public function editType(Request $request,$id=null){

        if($request->isMethod('post')){
            $data = $request->all();
            /*echo "<pre>"; print_r($data); */

            if(empty($data['status'])){
                $status='0';
            }else{
                $status='1';
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

            Type::where(['id'=>$id])->update(['status'=>$status,'name'=>$data['type_name'],'parent_id'=>$data['parent_id'],
                'description'=>$data['description'],'url'=>$data['url'], 'meta_title'=>$data['meta_title'],
                'meta_description'=>$data['meta_description'],'meta_keywords'=>$data['meta_keywords']]);
            return redirect()->back()->with('flash_message_success', 'Type has been updated successfully');
        }

        $typeDetails = Type::where(['id'=>$id])->first();
        $levels = Type::where(['parent_id'=>0])->get();
        return view('admin.type.edit_type')->with(compact('typeDetails','levels'));
    }

    public function deleteType($id = null){
        Type::where(['id'=>$id])->delete();
        return redirect()->back()->with('flash_message_success', 'Book type has been deleted successfully');
    }

    public function viewType(){ 

        $categories = category::get();
        return view('admin.type.view_type')->with(compact('type'));
    }
}
