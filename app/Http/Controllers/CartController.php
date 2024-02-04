<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCart;
use Illuminate\Http\Request;
use App\Helper\ResponseHelper;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user_id = $request->header('id');
        $data = ProductCart::where('user_id', $user_id)->with('product')->get();
        return ResponseHelper::Out('success', $data, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user_id = $request->header('id');
        $product_id = $request->product_id;
        $color = $request->color;
        $size = $request->size;
        $qty = $request->qty;
        $unitPrice = 0;

        $product = Product::where('id', $product_id)->first();
        if ($product->discount == 1) {
            $unitPrice = $product->discount_price;
        } else {
            $unitPrice = $product->price;
        }

        $totalPrice = $qty * $unitPrice;

        $data = ProductCart::updateOrCreate(
            ['user_id' => $user_id, 'product_id' => $request->product_id],
            [
                'user_id' => $user_id,
                'product_id' => $request->product_id,
                'color' => $color,
                'size' => $size,
                'qty' => $qty,
                'price' => $totalPrice,
            ],
        );
        return ResponseHelper::Out('success', $data, 200);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $user_id = $request->header('id');
        $data = ProductCart::where(['user_id' => $user_id, 'product_id' => $request->input('product_id')])->delete();
        return ResponseHelper::Out('success', $data, 200);
    }
}
