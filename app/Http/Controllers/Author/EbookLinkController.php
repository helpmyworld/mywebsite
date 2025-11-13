<?php

namespace App\Http\Controllers\Author;

use App\Http\Controllers\Controller;
use App\Services\EbookLinkService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EbookLinkController extends Controller
{
    public function send($id, Request $request, EbookLinkService $svc)
    {
        // $id = orders_products.id (from your existing route)
        $row = DB::table('orders_products as op')
            ->join('orders as o', 'o.id', '=', 'op.order_id')
            ->join('products as p', 'p.id', '=', 'op.product_id')
            ->where('op.id', $id)
            ->select('op.id as op_id','op.order_id','op.product_id','o.user_id as buyer_id','p.id as pid','p.ebook_file as ebook_file','p.user_id as author_id','o.id as oid')
            ->first();

        if (!$row) return back()->with('error','Order item not found.');

        // Secure: ensure the author owns this product
        if ((int)$row->author_id !== (int)$request->user()->id) {
            abort(403);
        }

        // Determine file path column used by your products table
        $filePath = $row->ebook_file ?? null; // adjust if your column is different
        if (!$filePath) return back()->with('error','No e-book file on this product.');

        $link = $svc->createLink((int)$row->order_id, (int)$row->op_id, (int)$row->product_id, (int)$row->buyer_id, $filePath);

        // Email buyer
        $buyer = \App\User::find($row->buyer_id);
        if ($buyer) {
            $svc->sendEmail($buyer->email, $buyer->name ?? 'Reader', $link);
        }

        return back()->with('success','Download link sent to buyer.');
    }
}
