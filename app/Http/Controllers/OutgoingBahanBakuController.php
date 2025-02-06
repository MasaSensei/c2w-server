<?php

namespace App\Http\Controllers;

use App\Models\OutgoingBahanBaku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Helpers\ResponseHelper;
use App\Models\BahanBaku;

class OutgoingBahanBakuController extends Controller
{
    private function validateOutgoingBahanBaku($data)
    {
        return Validator::make($data, [
            'id_bahan_baku' => 'required|integer',
            'outgoing_date' => 'required|date',
            'total_roll' => 'required|integer',
            'total_yard' => 'required|numeric',
            'status' => 'required|string',
            'incoming_invoice_number' => 'nullable|string',
            'remarks' => 'nullable|string',
            'is_active' => 'required|boolean',
        ]);
    }

    private function findOutgoingBahanBaku($id)
    {
        return OutgoingBahanBaku::find($id);
    }

    public function index()
    {
        $data = OutgoingBahanBaku::with(['bahanbaku', 'bahanbaku.color', 'bahanbaku.code', 'item_categories'])->get();

        if (count($data) > 0) {
            return ResponseHelper::success($data);
        }

        return ResponseHelper::notFound();
    }

    public function store(Request $request)
    {
        $validator = $this->validateOutgoingBahanBaku($request->all());

        if ($validator->fails()) {
            return ResponseHelper::error($validator->errors());
        }

        $data = OutgoingBahanBaku::create($request->all());

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
}
