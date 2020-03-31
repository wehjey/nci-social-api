<?php

namespace App\Http\Controllers;

use App\Category;

class CategoryController extends Controller
{
    /**
     * Return all categories
     *
     * @return void
     */
    public function index()
    {
        $categories = Category::all();
        return resourceCreatedResponse($categories, 'Categories returned successfully', 200);
    }
}
