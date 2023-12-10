<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function getAll()
    {
        $products = Product::all();
        return response()->json($products);
    }

    public function select($id)
    {
        $product = Product::find($id);
        return response()->json($product);
    }

    public function insert(Request $request)
    {
        $product = Product::create($request->all());
        return response()->json($product, 201);
    }

    public function update(Request $request, $id)
    {
        $product = Product::find($id);
        $product->update($request->all());
        return response()->json($product);
    }

    public function delete($id)
    {
        $product = Product::find($id);
        $product->delete();
        return response()->json(null, 204);
    }
}
