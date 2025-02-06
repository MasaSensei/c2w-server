<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Models\OrderBahanBaku;
use App\Models\OrderBahanBakuDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class OrderBahanBakuController extends Controller
{
    private function validateOrderBahanBaku($data)
    {
        return Validator::make($data, [
            'invoice_number' => 'required|unique:order_bahan_baku',
            'order_date' => 'required|date',
            'due_date' => 'required|date',
            'status' => 'required|string',
            'remarks' => 'nullable|string',
            'is_active' => 'required|boolean',
            'details' => 'required|array|min:1',
            'details.*.id_inv_cutters_material' => 'required|exists:inventory_bahan_baku_to_cutters,id',
            'details.*.product_code' => 'required|string',
            'details.*.roll' => 'required|integer|min:1',
            'details.*.total_yard' => 'required|numeric|min:0',
            'details.*.cost_per_yard' => 'required|numeric|min:0',
        ]);
    }

    private function findOrderBahanBaku($id)
    {
        return OrderBahanBaku::find($id);
    }

    public function index()
    {
        $datas = OrderBahanBaku::with('details.inventoryBahanBakuToCutters')->get();

        if (count($datas) > 0) {
            return ResponseHelper::success($datas);
        }

        return ResponseHelper::notFound();
    }

    public function store(Request $request)
    {
        $validator = $this->validateOrderBahanBaku($request->all());

        if ($validator->fails()) {
            return ResponseHelper::error($validator->errors());
        }

        $data = OrderBahanBaku::create([
            'invoice_number' => $request->invoice_number,
            'order_date' => $request->order_date,
            'due_date' => $request->due_date,
            'status' => $request->status,
            'remarks' => $request->remarks,
            'is_active' => $request->is_active ?? 1,
        ]);

        foreach ($request->details as $detail) {
            OrderBahanBakuDetails::create([
                'id_order_bahan_baku' => $data->id,
                'id_inv_cutters_material' => $detail['id_inv_cutters_material'],
                'roll' => $detail['roll'],
                'total_yard' => $detail['total_yard'],
                'product_code' => $detail['product_code'],
                'cost_per_yard' => $detail['cost_per_yard'],
                'sub_total' => $detail['total_yard'] * $detail['cost_per_yard'],
                'remarks' => $detail['remarks'] ?? null,
                'is_active' => 1,
            ]);
        }

        return ResponseHelper::created($data);
    }
}
