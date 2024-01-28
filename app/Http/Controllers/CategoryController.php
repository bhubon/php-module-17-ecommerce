<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Helper\ResponseHelper;

class CategoryController extends Controller
{
    public function CategoryList()
    {
        $brands = Category::all();
        return ResponseHelper::Out('success', $brands, 200);
    }
}
