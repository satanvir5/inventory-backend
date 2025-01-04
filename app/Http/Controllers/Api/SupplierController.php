<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    // List Suppliers (with pagination)
    public function index(Request $request)
    {
        $query = Supplier::query();

        if ($request->has('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        $suppliers = $query->paginate(10);
        return response()->json($suppliers);
    }
    // Create Supplier
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'contact_info' => 'required|string',
            'address' => 'required|string',
        ]);

        $supplier = Supplier::create($validated);

        return response()->json($supplier, 201);
    }

    // Update Supplier
    public function update(Request $request, $id)
    {
        $supplier = Supplier::findOrFail($id);

        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'contact_info' => 'sometimes|string',
            'address' => 'sometimes|string',
        ]);

        $supplier->update($validated);

        return response()->json($supplier);
    }

    // Delete Supplier (soft delete)
    public function destroy($id)
    {
        $supplier = Supplier::findOrFail($id);
        $supplier->delete();

        return response()->json(['message' => 'Supplier deleted successfully.']);
    }

    // Fetch Single Supplier
    public function show($id)
    {
        $supplier = Supplier::findOrFail($id);

        return response()->json($supplier);
    }
}
