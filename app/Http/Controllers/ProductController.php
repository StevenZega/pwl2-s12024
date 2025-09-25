<?php

namespace App\Http\Controllers;

use App\Models\Product;

use App\Models\Category_product;

use App\Models\Supplier;

use Illuminate\View\View;

use Illuminate\Http\RedirectResponse;

use Illuminate\Support\Facades\Storage;

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

    /**
     * create
     * 
     * @return View
     */
    public function create(): View
    {
        $product = new Category_product;
        $supplier = new Supplier;

        $data['categories'] = $product->get_category_product()->get();
        $data['suppliers'] = $supplier->get_supplier()->get();

        return view('products.create', compact('data'));
    }

    /**
     * store
     *
     * @param  mixed $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        // var_dump($request);exit;
        //validate form
        $validatedData = $request->validate([
            'image'                 => 'required|image|mimes:jpeg,jpg,png|max:2048',
            'title'                 => 'required|min:5',
            'product_category_id'   => 'required|integer',
            'supplier'              => 'required|integer',
            'description'           => 'required|min:10',
            'price'                 => 'required|numeric',
            'stock'                 => 'required|numeric'
        ]);

        // Menghandle upload file gambar
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $store_image = $image->store('images', 'public'); // Simpan gambar ke folder penyimpanan

            $product = new Product;
            $insert_product = $product->storeProduct($request, $image);

            //redirect to index
            return redirect()->route('products.index')->with(['success' => 'Data Berhasil Disimpan!']);
        }

        //redirect to index
        return redirect()->route('products.index')->with(['error' => 'Failed to upload image (request).']);
    }

}
