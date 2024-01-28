<?php

namespace App\Http\Controllers;

use App\Helper\ResponseHelper;
use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function BrandList()
    {
        $brands = Brand::all();
        return ResponseHelper::Out('success', $brands, 200);
    }
}
