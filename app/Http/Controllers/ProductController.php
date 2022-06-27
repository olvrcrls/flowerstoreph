<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Product;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Inertia::render("Products/Index", [
            'filters' => request()->all('search', 'trashed'),
            'products' => Product::orderBy('created_at','desc')
                    ->filter(request()->only('search', 'trashed'))
                    ->paginate(10)
                    ->withQueryString()
                    ->through(function ($product) {
                        return array(
                            'id' => $product->id,
                            'name' => $product->product_name,
                            'price' => $product->price,
                            'description' => $product->product_description,
                            'status' => $product->status
                        );
                    }),
            ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Products/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\ProductRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        Product::create($request->validated());
        return Redirect::route('products')->with('success', 'Product Created.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        return Inertia::render('Products/Edit', [
            'product' => [
                'id' => $product->id,
                'name' => $product->product_name,
                'price' => $product->price,
                'description' => $product->product_description,
                'quantity' => $product->quantity,
                'status' => $product->status,
            ]
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\ProductRequest  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, Product $product)
    {
        $product->update($request->validated());
        return Redirect::route('products')->with('success', 'Product updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->update(['status' => false]);
        return Redirect::back()->with('success', 'Product deleted.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function restore(Product $product)
    {
        $product->update(['status' => true]);
        return Redirect::back()->with('success', 'Product restored.');
    }
}
