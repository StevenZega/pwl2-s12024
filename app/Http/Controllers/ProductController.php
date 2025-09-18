<?php

namespace App\Http\Controllers;

use App\Models\Product;

use Illuminate\View\View;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * index
     * 
     * @return void
     */
    public function index() : View
    {
        $product = new Product;
        $products = $product->get_product()->latest()->paginate(10);

        return view('products.index', compact('products'));
    }
}
