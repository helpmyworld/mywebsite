<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Cat;
use App\Providers\Paginator;

class CatController extends Controller
{
    public function index()
{
    // Instead of ->get(), use ->paginate()
    $cats = Cat::orderBy('created_at', 'desc')->paginate(10);

    return view('admin.cats.index', compact('cats'));
}

    public function create()
    {
        return view('admin.cats.create');
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required']);
        $cat = new Cat();
        $cat->name = $request->name;
        $cat->save();

        return redirect()->route('cats.index')->with('success', 'Category added!');
    }

    public function show(Cat $cat)
    {
        return view('admin.cats.show', compact('cat'));
    }

    public function edit(Cat $cat)
    {
        return view('admin.cats.edit', compact('cat'));
    }

    public function update(Request $request, Cat $cat)
    {
        $request->validate(['name' => 'required']);
        $cat->update(['name' => $request->name]);

        return redirect()->route('cats.index')->with('success', 'Category updated!');
    }

    public function destroy(Cat $cat)
    {
        $cat->delete();
        return redirect()->route('cats.index')->with('success', 'Category deleted!');
    }


   // NEW: Bulk hard delete (exact mirror of bulkDeleteUsers / bulkDeleteTags)

   public function bulkDeleteCats(Request $request)
{
    $ids = $request->input('ids', []);
    if (!is_array($ids) || count($ids) === 0) {
        return redirect()->back()->with('flash_message_error', 'No categories selected.');
    }

    try {
        DB::beginTransaction();

        // Hard delete in bulk — identical pattern
        Cat::whereIn('id', $ids)->delete();

        DB::commit();
        return redirect()->back()->with('flash_message_success', 'Selected categories have been deleted successfully.');
    } catch (\Throwable $e) {
        DB::rollBack();
        return redirect()->back()->with('flash_message_error', $e->getMessage());
    }
}

}
