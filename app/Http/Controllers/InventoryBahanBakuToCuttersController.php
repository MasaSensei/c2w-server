<?php

namespace App\Http\Controllers;

use App\Models\InventoryBahanBakuToCutters;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Helpers\ResponseHelper;
use App\Models\BahanBaku;

class InventoryBahanBakuToCuttersController extends Controller
{
    private function validateInventoryBahanBakuToCutters($data)
    {
        return Validator::make($data, [
            'id_bahan_baku' => 'required|exists:bahan_baku,id',
            'transfer_date' => 'required|date',
            'item' => 'required|string',
            'total_roll' => 'required|integer',
            'total_yard' => 'required|numeric',
            'status' => 'required|string',
            'remarks' => 'nullable|string',
            'is_active' => 'required|boolean',
        ]);
    }
    private function findInventoryBahanBakuToCutters($id)
    {
        return InventoryBahanBakuToCutters::find($id);
    }

    public function index()
    {
        $data = InventoryBahanBakuToCutters::all();

        if ($data) {
            return ResponseHelper::success($data);
        }

        return ResponseHelper::notFound();
    }

    public function store(Request $request)
    {
        $validator = $this->validateInventoryBahanBakuToCutters($request->all());

        if ($validator->fails()) {
            return ResponseHelper::error($validator->errors());
        }

        $data = InventoryBahanBakuToCutters::create($request->all());

        $bahan_baku = BahanBaku::find($request->id_bahan_baku);

        if ($bahan_baku) {
            $new_total_roll = $bahan_baku->total_roll - $request->total_roll;
            $new_total_yard = $bahan_baku->total_yard - $request->total_yard;

            $bahan_baku->update([
                'total_roll' => $new_total_roll,
                'total_yard' => $new_total_yard,
            ]);
        }

        return ResponseHelper::created($data);
    }

    public function update($id, Request $request)
    {
        $validator = $this->validateInventoryBahanBakuToCutters($request->all());

        if ($validator->fails()) {
            return ResponseHelper::error($validator->errors());
        }

        $data = $this->findInventoryBahanBakuToCutters($id);

        if ($data) {
            $data->update($request->all());
            return ResponseHelper::edit($data);
        }

        return ResponseHelper::notFound();
    }
}
