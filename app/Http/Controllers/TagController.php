<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use App\Models\Tag; // or App\Tag; adjust to your app

use Illuminate\Support\Facades\DB;
use App\Tag;
use App\Post;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use App\Providers\Paginator;


class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $tags=Tag::orderBy('created_at', 'desc')->paginate(5);
        return view('admin.tags.index', compact('tags'));
    }


    public function create()
    {
        return view('admin.tags.create');
    }
    public function store(Request $request)
    {
        $request->validate(['name' => 'required']);
        $tag = new tag();
        $tag->name = $request->name;
        $tag->save();

        return redirect()->route('tags.index')->with('success', 'tag added!');
    }

    public function show(tag $tag)
    {
        return view('admin.tags.show', compact('tag'));
    }

    public function edit(tag $tag)
    {
        return view('admin.tags.edit', compact('tag'));
    }

    public function update(Request $request, tag $tag)
    {
        $request->validate(['name' => 'required']);
        $tag->update(['name' => $request->name]);

        return redirect()->route('tags.index')->with('success', 'tag updated!');
    }

    

    


     // =========================
    // NEW: Bulk hard delete
    // NEW: Bulk hard delete (exact mirror of bulkDeleteUsers)
    // =========================
    public function bulkDeleteTags(Request $request)
    {
        $ids = $request->input('ids', []);
        if (!is_array($ids) || count($ids) === 0) {
            return redirect()->back()->with('flash_message_error', 'No tags selected.');
        }

        try {
            DB::beginTransaction();

            // Hard delete in bulk — mirror of Users bulk delete
            Tag::whereIn('id', $ids)->delete();

            DB::commit();
            return redirect()->back()->with('flash_message_success', 'Selected tags have been deleted successfully.');
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->back()->with('flash_message_error', $e->getMessage());
        }
    }
   


}
