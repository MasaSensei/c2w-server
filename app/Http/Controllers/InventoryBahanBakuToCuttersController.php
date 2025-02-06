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
            'id_size' => 'required|',
            'id_model' => 'required|',
            'transfer_date' => 'required|date',
            'item' => 'required|string',
            'total_roll' => 'required|integer',
            'total_yard' => 'required|numeric',
            'status' => 'required|string',
            'remarks' => 'nullable|string',
            'is_active' => 'required|boolean',
            'categories' => 'required|array',
            'categories.*' => 'exists:item_categories,id',
        ]);
    }
    private function findInventoryBahanBakuToCutters($id)
    {
        return InventoryBahanBakuToCutters::find($id);
    }

    public function index()
    {
        $data = InventoryBahanBakuToCutters::with('category', 'size', 'model')->get();

        if ($data) {
            return ResponseHelper::success($data);
        }

        return ResponseHelper::notFound();
    }

    public function store(Request $request)
    {
        // Validasi input data
        $validator = $this->validateInventoryBahanBakuToCutters($request->all());

        // Jika validasi gagal, kembalikan response error
        if ($validator->fails()) {
            return ResponseHelper::error($validator->errors());
        }

        // Cari data yang sudah ada dengan kondisi yang sama
        $existingData = InventoryBahanBakuToCutters::where('id_bahan_baku', $request->id_bahan_baku)
            ->where('id_size', $request->id_size)
            ->where('id_model', $request->id_model)
            ->where('transfer_date', $request->transfer_date)
            ->whereHas('category', function ($query) use ($request) {
                $query->whereIn('inventory_bahan_baku_to_cutters_item_category.id_item_category', $request->category);
            })
            ->first();

        // Jika data sudah ada, update total_roll dan total_yard
        if ($existingData) {
            $existingData->total_roll += $request->total_roll;
            $existingData->total_yard += $request->total_yard;
            $existingData->save();

            // Kembalikan response sukses dengan data yang diupdate
            return ResponseHelper::edit($existingData);
        }

        // Jika data tidak ada, buat data baru
        $data = InventoryBahanBakuToCutters::create([
            'id_bahan_baku' => $request->id_bahan_baku,
            'id_size' => $request->id_size,
            'id_model' => $request->id_model,
            'transfer_date' => $request->transfer_date,
            'item' => $request->item,
            'total_roll' => $request->total_roll,
            'total_yard' => $request->total_yard,
            'status' => $request->status ?? 'ready',
            'remarks' => $request->remarks,
            'is_active' => $request->is_active ?? 1,
        ]);

        // Menyambungkan kategori (pivot) ke InventoryBahanBakuToCutters
        if (isset($request->category) && count($request->category) > 0) {
            $data->category()->attach($request->category);
        }

        // Mengambil data bahan baku yang terkait
        $bahan_baku = BahanBaku::find($request->id_bahan_baku);

        // Jika bahan baku ditemukan, update stok bahan baku
        if ($bahan_baku) {
            $new_total_roll = $bahan_baku->total_roll - $request->total_roll;
            $new_total_yard = $bahan_baku->total_yard - $request->total_yard;

            // Update stok bahan baku
            $bahan_baku->update([
                'total_roll' => $new_total_roll,
                'total_yard' => $new_total_yard,
            ]);
        }

        // Kembalikan response sukses dengan data yang disimpan
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
