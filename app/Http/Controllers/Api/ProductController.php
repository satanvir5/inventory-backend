<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::query()
            ->when($request->input('name'), fn($q) => $q->where('name', 'like', '%' . $request->input('name') . '%'))
            ->when($request->input('SKU'), fn($q) => $q->where('SKU', $request->input('SKU')))
            ->when($request->input('category_id'), fn($q) => $q->where('category_id', $request->input('category_id')))
            ->paginate(10);

        return response()->json($products);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'SKU' => 'required|string|unique:products,SKU',
            'price' => 'required|numeric',
            'initial_stock_quantity' => 'required|integer|min:0',
            'category_id' => 'nullable|exists:categories,id',
        ]);

        $validated['current_stock_quantity'] = $validated['initial_stock_quantity'];
        $product = Product::create($validated);

        return response()->json($product, 201);
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);

        return response()->json($product);
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'SKU' => 'sometimes|string|unique:products,SKU,' . $id . ',product_id', // Corrected the unique validation rule
            'price' => 'sometimes|numeric',
            'initial_stock_quantity' => 'sometimes|integer|min:0',
            'category_id' => 'nullable|exists:categories,id',
        ]);

        $product->update($validated);

        return response()->json($product);
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return response()->json(['message' => 'Product deleted successfully']);
    }
}
