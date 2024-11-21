<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // get all categories
    public function getAll()
    {
        $categories = Category::all();
        return response()->json(
            [
                'status' => 'success',
                'message' => 'Categories fetched successfully',
                'data' => $categories
            ]
        );
    }
}
