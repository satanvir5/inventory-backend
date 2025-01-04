<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Purchase;
use App\Models\PurchaseItem;
use App\Models\Product;

class PurchaseController extends Controller
{
    // Create a new purchase order
    public function store(Request $request)
    {
        $request->validate([
            'supplier_id' => 'required|exists:suppliers,supplier_id',
            'purchase_date' => 'required|date',
            'items' => 'required|array',
            'items.*.product_id' => 'required|exists:products,product_id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
        ]);

        // Start a transaction
        \DB::beginTransaction();
        try {
            // Create purchase
            $purchase = Purchase::create([
                'supplier_id' => $request->supplier_id,
                'total_amount' => 0, // Total will be calculated later
                'purchase_date' => $request->purchase_date,
            ]);

            // Create purchase items and calculate total amount
            $totalAmount = 0;
            foreach ($request->items as $item) {
                $totalPrice = $item['quantity'] * $item['unit_price'];
                PurchaseItem::create([
                    'purchase_id' => $purchase->purchase_id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                    'total_price' => $totalPrice,
                ]);

                // Update stock quantity for the product
                $product = Product::find($item['product_id']);
                $product->current_stock_quantity += $item['quantity'];
                $product->save();

                // Add to total amount
                $totalAmount += $totalPrice;
            }

            // Update total amount for purchase
            $purchase->total_amount = $totalAmount;
            $purchase->save();

            // Commit transaction
            \DB::commit();

            return response()->json($purchase, 201);
        } catch (\Exception $e) {
            \DB::rollBack();
            return response()->json(['error' => 'Failed to create purchase order' . $e->getMessage()], 500);
        }
    }

    // List all purchases
    public function index()
    {
        $purchases = Purchase::with('supplier')->paginate(10);
        return response()->json($purchases);
    }
}

