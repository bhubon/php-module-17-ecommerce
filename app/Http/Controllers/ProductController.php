<?php

namespace App\Http\Controllers;

use App\Models\CustomerProfile;
use App\Models\Product;
use App\Models\ProductDetail;
use App\Models\ProductReview;
use Illuminate\Http\Request;
use App\Models\ProductSlider;
use App\Helper\ResponseHelper;

class ProductController extends Controller
{
    public function ListProductByCategory(Request $request)
    {
        $data = Product::where('category_id', $request->id)->with('brand', 'category')->get();
        return ResponseHelper::Out('success', $data, 200);
    }

    public function ListProductByRemark(Request $request)
    {
        $data = Product::where('remark', $request->remark)->with('brand', 'category')->get();
        return ResponseHelper::Out('success', $data, 200);
    }

    public function ListProductByBrand(Request $request)
    {
        $data = Product::where('brand_id', $request->id)->with('brand', 'category')->get();
        return ResponseHelper::Out('success', $data, 200);
    }

    public function ListProductSlider(Request $request)
    {
        $data = ProductSlider::all();
        return ResponseHelper::Out('success', $data, 200);
    }

    public function ProductDetailsById(Request $request)
    {
        $data = ProductDetail::where('product_id', $request->id)->with('product', 'product.brand', 'product.category')->get();
        return ResponseHelper::Out('success', $data, 200);
    }

    public function ListReviewById(Request $request)
    {
        $data = ProductReview::where('product_id', $request->product_id)->with([
            'profile' => function ($query) {
                $query->select('id', 'cus_name');
            }
        ])->get();
        return ResponseHelper::Out('success', $data, 200);
    }

    public function createReview(Request $request)
    {
        $user_id = $request->header('id');

        $profile = CustomerProfile::where('user_id', $user_id)->first();

        if ($profile) {
            $request->merge(['customer_id' => $profile->id]);
            $data = ProductReview::updateOrCreate(
                ['customer_id' => $profile->id, 'product_id' => $request->input('product_id')],
                $request->input(),
            );

            return ResponseHelper::Out('success', $data, 200);
        } else {
            return ResponseHelper::Out('failed', 'Customer profile not exists', 200);
        }

    }


}
