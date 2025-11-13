<?php

namespace App\Http\Controllers;


use App\Review;


use App\Product;
use Session;
use Illuminate\Http\Request;

class ReviewsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => 'store']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $product_id)
    {
        $this->validate($request, array(
            'name'      =>  'required|max:255',
            'email'     =>  'required|email|max:255',
            'review'   =>  'required|min:5|max:2000'
        ));

        $product= Product::find($product_id);

        $review = new Review();
        $review->name = $request->name;
        $review->email = $request->email;
        $review->review = $request->review;
        $review->approved = true;
        $review->product()->associate($product);

        $review->save();

        Session::flash('success', 'Review was added');

        return redirect()->back()->with('success', 'Record deleted successfully');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $review = Review::find($id);
        return view('admin.reviews.edit')->withReview($review);
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
        $reveiw = Review::find($id);

        $this->validate($request, array('review' => 'required'));

        $review->review = $request->review;
        $review->save();

        Session::flash('success', 'Review updated');

        return redirect()->route('product.index', $review->product->id);
    }

    public function delete($id)
    {
        $review = Review::find($id);
        return view('admin.reviews.delete')->withReview($review);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $review = Review::find($id);
        $product_id = $review->product->id;
        $review->delete();

        Session::flash('success', 'Deleted Review');

        return redirect()->route('product.index', $product_id);
    }
}
