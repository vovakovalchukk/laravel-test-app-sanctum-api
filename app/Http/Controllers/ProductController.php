<?php

namespace App\Http\Controllers;

use App\Events\ProductStoredEvent;
use App\Http\Requests\ProductRequestStore;
use App\Http\Requests\ProductRequestUpdate;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ProductResource::collection(Product::paginate());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequestStore $request)
    {
        $product = auth()->user()
            ->products()
            ->create($request->all());

        event(new ProductStoredEvent(auth()->user(), $product));

        return new ProductResource($product);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return new ProductResource(Product::findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequestUpdate $request, $id)
    {
        $product = Product::findOrFail($id);
        $product->update($request->all());
        return new ProductResource($product);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return Product::destroy($id);
    }

    /**
     * Search by name.
     *
     * @param  string  $name
     * @return \Illuminate\Http\Response
     */
    public function searchByName($name)
    {
        return ProductResource::collection(Product::where('name', 'like', "%$name%")->paginate());
    }
}
