<?php

namespace App\Http\Controllers;

use App\Author;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class AuthorController extends Controller
{    


/**
     * GET|POST /admin/add-author
     * Mirrors addProduct() pattern
     */


    public function addAuthor(Request $request)
{
    if ($request->isMethod('post')) {
        $data = $request->all();

        $author = new Author;
        $author->name        = $data['name'];
        $author->email       = $data['email'] ?? null;
        $author->bio         = $data['bio'] ?? null;
        $author->is_featured = !empty($data['is_featured']) ? 1 : 0;

        // Image upload handling
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            if ($file->isValid()) {
                $extension = $file->getClientOriginalExtension();
                $filename = time() . '.' . $extension;
                $path = public_path('images/backend_images/authors');
                $file->move($path, $filename);
                $author->image = $filename;
            }
        }

        $author->save();

        return redirect()->back()->with('flash_message_success', 'Author has been added successfully');
    }

    return view('admin.authors.add_author');
}



    public function editAuthor(Request $request, $id)
    {
        $author = Author::findOrFail($id);

        // GET: show form
        if ($request->isMethod('get')) {
            return view('admin.authors.edit', compact('author'));
        }

        // POST: update author
        $data = $request->all();

        // Basic fields
        $author->name        = $data['name'] ?? $author->name;
        $author->email       = $data['email'] ?? null;
        $author->slug        = $data['slug'] ?? ($author->slug ?: Str::slug($author->name));
        $author->bio         = $data['bio'] ?? null;
        $author->is_featured = $request->filled('is_featured') ? 1 : 0;

        // Image upload (matches your blade: name="image", hidden "current_image")
        if ($request->hasFile('image')) {
            $file = $request->file('image');

            if ($file->isValid()) {
                $folder = public_path('images/backend_images/authors');

                // create folder if missing
                if (!File::exists($folder)) {
                    File::makeDirectory($folder, 0755, true);
                }

                $ext      = $file->getClientOriginalExtension();
                $filename = 'author_'.time().'_'.Str::random(6).'.'.$ext;

                // move new file
                $file->move($folder, $filename);

                // delete old file if present
                if (!empty($author->image)) {
                    $oldPath = $folder.DIRECTORY_SEPARATOR.$author->image;
                    if (File::exists($oldPath)) {
                        File::delete($oldPath);
                    }
                }

                // save new filename
                $author->image = $filename;
            }
        } else {
            // if no new upload was provided, keep current_image if set
            if (!empty($data['current_image'])) {
                // do nothing, keep existing $author->image
            } else {
                // no current and no new -> clear
                $author->image = null;
            }
        }

        $author->save();

        return redirect(url('/admin/view-authors'))
            ->with('flash_message_success', 'Author updated successfully.');

    }


    public function viewAuthors()
    {
        $authors = Author::orderBy('id', 'desc')->get();

        // Use your existing admin layout/views if you have them
        // e.g. return view('admin.authors.view_authors', compact('authors'));
        return view()->exists('admin.authors.view_authors')
            ? view('admin.authors.view_authors', compact('authors'))
            : view('admin._authors_index_fallback', compact('authors'));
    }



    /**
     * GET|POST /admin/delete-author/{id}
     * Mirrors deleteProduct() pattern
     */
    public function deleteAuthor(Request $request, $id)
    {
        $author = Author::findOrFail($id);

        // If your products delete uses GET to confirm and POST to delete, we support both:
        if ($request->isMethod('post')) {
            $author->delete();
            return redirect()->back()->with('flash_message_success', 'Author has been deleted successfully');
        }

        // GET: quick confirm page (only if you use it)
        if (view()->exists('admin.authors.delete_author')) {
            return view('admin.authors.delete_author', compact('author'));
        }

        // Default behavior if you don’t keep a confirm screen
        $author->delete();
        return redirect()->back()->with('flash_message_success', 'Author has been deleted successfully');

    }z
}
