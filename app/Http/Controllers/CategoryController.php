<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cache;
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
        $categories = Cache::remember('categories', 86400, function () { // Cache for 24 hours
            return Category::all();
        });

        return resourceCreatedResponse($categories, 'Categories returned successfully', 200);
    }
}
