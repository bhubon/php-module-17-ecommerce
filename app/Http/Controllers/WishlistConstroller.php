<?php

namespace App\Http\Controllers;

use App\Helper\ResponseHelper;
use App\Models\ProductWishes;
use Illuminate\Http\Request;

class WishlistConstroller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user_id = $request->header('id');
        $data = ProductWishes::where('user_id', $user_id)->with('product')->get();
        return ResponseHelper::Out('success', $data, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user_id = $request->header('id');
        $data = ProductWishes::updateOrCreate(
            ['user_id' => $user_id, 'product_id' => $request->product_id],
            ['user_id' => $user_id, 'product_id' => $request->product_id],
        );
        return ResponseHelper::Out('success', $data, 200);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $user_id = $request->header('id');
        $data = ProductWishes::where(['user_id' => $user_id, 'product_id' => $request->input('product_id')])->delete();
        return ResponseHelper::Out('success', $data, 200);
    }
}
