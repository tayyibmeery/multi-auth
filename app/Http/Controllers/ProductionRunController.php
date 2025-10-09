<?php

namespace App\Http\Controllers;

use App\Models\ProductionRun;
use App\Models\BillOfMaterial;
use App\Models\StockLedger;
use Illuminate\Http\Request;
use DB;

class ProductionRunController extends Controller
{
    public function index()
    {
        $productionRuns = ProductionRun::with('billOfMaterial.product', 'user')->latest()->paginate(10);
        return view('production-runs.index', compact('productionRuns'));
    }

    public function create()
    {
        $boms = BillOfMaterial::with('product', 'bomItems.item')->get();
        return view('production-runs.create', compact('boms'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'bom_id' => 'required|exists:bill_of_materials,id',
            'quantity_to_produce' => 'required|integer|min:1',
            'production_date' => 'required|date',
        ]);

        try {
            DB::transaction(function () use ($request) {
                $bom = BillOfMaterial::with('bomItems.item')->find($request->bom_id);

                // Check stock availability
                foreach ($bom->bomItems as $bomItem) {
                    $requiredQuantity = $bomItem->quantity * $request->quantity_to_produce;
                    if ($bomItem->item->current_stock < $requiredQuantity) {
                        throw new \Exception("Insufficient stock for {$bomItem->item->name}. Required: {$requiredQuantity}, Available: {$bomItem->item->current_stock}");
                    }
                }

                $productionRun = ProductionRun::create([
                    'bom_id' => $request->bom_id,
                    'quantity_to_produce' => $request->quantity_to_produce,
                    'production_date' => $request->production_date,
                    'status' => 'pending',
                    'user_id' => auth()->id(),
                    'notes' => $request->notes,
                ]);

                // Deduct items from stock
                foreach ($bom->bomItems as $bomItem) {
                    $quantityUsed = $bomItem->quantity * $request->quantity_to_produce;
                    $item = $bomItem->item;

                    $item->current_stock -= $quantityUsed;
                    $item->save();

                    // Stock ledger entry for usage
                    StockLedger::create([
                        'date' => $request->production_date,
                        'type' => 'production_usage',
                        'reference_type' => ProductionRun::class,
                        'reference_id' => $productionRun->id,
                        'item_id' => $item->id,
                        'quantity_out' => $quantityUsed,
                        'unit_cost' => $item->current_price,
                        'total_cost' => $quantityUsed * $item->current_price,
                        'stock_after_transaction' => $item->current_stock,
                        'notes' => 'Used in production: ' . $productionRun->batch_number . ' for ' . $bom->product->name,
                        'user_id' => auth()->id(),
                    ]);
                }

                // Add finished product to stock
                $product = $bom->product;
                $product->current_stock += $request->quantity_to_produce;
                $product->save();

                // Calculate production cost per unit
                $productionCostPerUnit = $this->calculateProductionCost($bom, $request->quantity_to_produce);

                // Stock ledger entry for output
                StockLedger::create([
                    'date' => $request->production_date,
                    'type' => 'production_output',
                    'reference_type' => ProductionRun::class,
                    'reference_id' => $productionRun->id,
                    'product_id' => $product->id,
                    'quantity_in' => $request->quantity_to_produce,
                    'unit_cost' => $productionCostPerUnit,
                    'total_cost' => $productionCostPerUnit * $request->quantity_to_produce,
                    'stock_after_transaction' => $product->current_stock,
                    'notes' => 'Produced: ' . $productionRun->batch_number . ' - ' . $product->name,
                    'user_id' => auth()->id(),
                ]);

                $productionRun->update([
                    'status' => 'completed',
                    'actual_quantity' => $request->quantity_to_produce,
                    'completion_date' => now(),
                ]);
            });

            return redirect()->route('production-runs.index')->with('success', 'Production run completed successfully.');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    private function calculateProductionCost($bom, $quantity)
    {
        $totalCost = 0;
        foreach ($bom->bomItems as $bomItem) {
            $totalCost += $bomItem->item->current_price * $bomItem->quantity;
        }
        return $totalCost;
    }

    public function show(ProductionRun $productionRun)
    {
        $productionRun->load('billOfMaterial.bomItems.item', 'stockLedgers');
        return view('production-runs.show', compact('productionRun'));
    }

    public function destroy(ProductionRun $productionRun)
    {
        // Prevent deletion of completed production runs
        if ($productionRun->status === 'completed') {
            return redirect()->route('production-runs.index')->with('error', 'Cannot delete completed production run.');
        }

        $productionRun->delete();
        return redirect()->route('production-runs.index')->with('success', 'Production run deleted successfully.');
    }
}