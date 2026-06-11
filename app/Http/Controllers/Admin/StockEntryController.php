<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\InventoryMovement;
use App\Models\Product;
use App\Models\StockEntry;
use App\Models\StockEntryItem;
use App\Models\Supplier;
use App\Models\SupplierProductPrice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StockEntryController extends Controller
{
    public function index(Request $request)
    {
        $query = StockEntry::with(['supplier', 'user']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $stockEntries = $query->latest()->paginate(15)->withQueryString();
        $suppliers = Supplier::orderBy('name')->get();

        return view('admin.stock-entries.index', compact('stockEntries', 'suppliers'));
    }

    public function create()
    {
        $suppliers = Supplier::active()->get();
        $products = Product::active()->get();
        return view('admin.stock-entries.create', compact('suppliers', 'products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'notes' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.product_id' => [
                'required',
                \Illuminate\Validation\Rule::exists('products', 'id')->where('supplier_id', $request->supplier_id),
            ],
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_cost' => 'nullable|numeric|min:0',
            'items.*.notes' => 'nullable|string',
        ], [
            'items.*.product_id.exists' => 'One or more selected items do not belong to the selected supplier.',
        ]);

        DB::beginTransaction();
        try {
            $stockEntry = StockEntry::create([
                'supplier_id' => $validated['supplier_id'],
                'user_id' => auth()->id(),
                'status' => StockEntry::STATUS_PENDING,
                'notes' => $validated['notes'] ?? null,
            ]);

            foreach ($validated['items'] as $item) {
                $product = Product::find($item['product_id']);
                StockEntryItem::create([
                    'stock_entry_id' => $stockEntry->id,
                    'product_id'     => $item['product_id'],
                    'quantity'       => $item['quantity'],
                    'unit_cost'      => ($product && $product->cost_price > 0) ? $product->cost_price : ($item['unit_cost'] ?? null),
                    'notes'          => $item['notes'] ?? null,
                ]);
            }

            AuditLog::log('Created stock entry', $stockEntry, null, $stockEntry->toArray());
            DB::commit();

            return redirect()->route('admin.stock-entries.index')
                ->with('success', 'Stock entry created successfully and is pending approval.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error creating stock entry: ' . $e->getMessage())->withInput();
        }
    }

    public function show(StockEntry $stockEntry)
    {
        $stockEntry->load(['supplier', 'user', 'approvedByUser', 'items.product']);
        return view('admin.stock-entries.show', ['entry' => $stockEntry]);
    }

    public function approve(StockEntry $stockEntry)
    {
        if ($stockEntry->status !== StockEntry::STATUS_PENDING) {
            return back()->with('error', 'Only pending stock entries can be approved.');
        }

        DB::beginTransaction();
        try {
            $oldValues = $stockEntry->toArray();

            $stockEntry->update([
                'status'      => StockEntry::STATUS_APPROVED,
                'approved_by' => auth()->id(),
                'approved_at' => now(),
            ]);

            foreach ($stockEntry->items as $item) {
                $product      = $item->product;
                $beforeStock  = $product->current_stock;

                $product->increment('current_stock', $item->quantity);

                // --- Price recalculation on approval ---
                // If the stock entry item recorded a unit_cost, use it to update
                // the product's cost_price and recalculate unit_price.
                if (!empty($item->unit_cost) && (float) $item->unit_cost > 0) {
                    $newCost     = (float) $item->unit_cost;
                    $oldCostPrice = (float) $product->cost_price;

                    // Only update if cost actually changed
                    if (abs($newCost - $oldCostPrice) > 0.0001) {
                        $newSellingPrice = $product->calculateSellingPrice($newCost);
                        $markupUsed      = (float) ($product->markup_percentage
                            ?? \App\Models\Setting::where('key', 'default_markup_percentage')->value('value')
                            ?? 20);

                        // Record the price change in history
                        SupplierProductPrice::create([
                            'supplier_id'      => $stockEntry->supplier_id,
                            'product_id'       => $product->id,
                            'cost_price'       => $newCost,
                            'selling_price'    => $newSellingPrice ?? $product->unit_price,
                            'markup_percentage' => $markupUsed,
                            'reason'           => 'Stock entry approved: ' . $stockEntry->entry_number,
                            'recorded_by'      => auth()->id(),
                        ]);

                        // Update the product's stored cost and selling price
                        $product->update([
                            'cost_price' => $newCost,
                            'unit_price' => $newSellingPrice ?? $product->unit_price,
                        ]);
                    }
                }

                InventoryMovement::create([
                    'product_id'     => $product->id,
                    'type'           => InventoryMovement::TYPE_IN,
                    'quantity'       => $item->quantity,
                    'before_stock'   => $beforeStock,
                    'after_stock'    => $product->fresh()->current_stock,
                    'reference_type' => StockEntry::class,
                    'reference_id'   => $stockEntry->id,
                    'notes'          => 'Stock entry approved: ' . $stockEntry->entry_number,
                    'user_id'        => auth()->id(),
                ]);
            }

            AuditLog::log('Approved stock entry', $stockEntry, $oldValues, $stockEntry->toArray());
            DB::commit();

            return redirect()->route('admin.stock-entries.show', $stockEntry)
                ->with('success', 'Stock entry approved. Inventory and pricing updated.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error approving stock entry: ' . $e->getMessage());
        }
    }

    public function reject(StockEntry $stockEntry)
    {
        if ($stockEntry->status !== StockEntry::STATUS_PENDING) {
            return back()->with('error', 'Only pending stock entries can be rejected.');
        }

        $oldValues = $stockEntry->toArray();

        $stockEntry->update([
            'status' => StockEntry::STATUS_REJECTED,
            'approved_by' => auth()->id(),
            'approved_at' => now(),
        ]);

        AuditLog::log('Rejected stock entry', $stockEntry, $oldValues, $stockEntry->toArray());

        return redirect()->route('admin.stock-entries.show', $stockEntry)
            ->with('success', 'Stock entry rejected.');
    }
}
