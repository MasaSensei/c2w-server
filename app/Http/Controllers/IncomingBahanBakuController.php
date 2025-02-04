<?php

namespace App\Http\Controllers;

use App\Models\IncomingDetailBahanBaku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\IncomingBahanBaku;
use App\Helpers\ResponseHelper;
use App\Models\BahanBaku;

class IncomingBahanBakuController extends Controller
{
    private function validateIncomingBahanBaku($data)
    {
        return Validator::make($data, [
            'id_supplier' => 'required|exists:suppliers,id',
            'invoice_number' => 'required|unique:incoming_bahan_baku,invoice_number',
            'invoice_date' => 'required|date',
            'details' => 'required|array',
            'details.*.id_bahan_baku' => 'required|exists:bahan_baku,id',
            'details.*.length_yard' => 'nullable|numeric',
            'details.*.roll' => 'required|integer|min:1',
            'details.*.total_yard' => 'required|numeric',
            'details.*.cost_per_yard' => 'required|numeric',
            'details.*.sub_total' => 'required|numeric',
            'details.*.remarks' => 'nullable|string',
        ]);
    }

    public function index()
    {
        $datas = IncomingBahanBaku::with(['suppliers', 'details.bahanBaku', 'details.bahanBaku.color', 'details.bahanBaku.code'])->get();

        if ($datas->isNotEmpty()) {
            $datas = $datas->map(function ($incoming) {
                $incoming->details->map(function ($detail) {
                    $bahanBaku = $detail->bahanBaku;
                    if ($bahanBaku) {
                        // Hilangkan desimal jika .00
                        $bahanBaku->price_per_yard = floatval($bahanBaku->price_per_yard) == intval($bahanBaku->price_per_yard)
                            ? intval($bahanBaku->price_per_yard)
                            : number_format($bahanBaku->price_per_yard, 2);
                    }
                    return $detail;
                });
                return $incoming;
            });

            return ResponseHelper::success($datas);
        }

        return ResponseHelper::notFound();
    }


    public function store(Request $request)
    {
        $validator = $this->validateIncomingBahanBaku($request->all());

        if ($validator->fails()) {
            return ResponseHelper::error($validator->errors());
        }

        $data = IncomingBahanBaku::create([
            'id_supplier' => $request->id_supplier,
            'invoice_number' => $request->invoice_number,
            'invoice_date' => $request->invoice_date,
            'is_active' => 1,
        ]);

        foreach ($request->details as $detail) {
            IncomingDetailBahanBaku::create([
                'id_incoming_bahan_baku' => $data->id,
                'id_bahan_baku' => $detail['id_bahan_baku'],
                'length_yard' => $detail['total_yard'] / $detail['roll'],
                'roll' => $detail['roll'],
                'total_yard' => $detail['total_yard'],
                'cost_per_yard' => $detail['cost_per_yard'],
                'sub_total' => $detail['sub_total'],
                'remarks' => $detail['remarks'],
                'is_active' => 1,
            ]);

            $bahan_baku = BahanBaku::find($detail['id_bahan_baku']);

            if ($bahan_baku) {
                $new_total_roll = $bahan_baku->total_roll + $detail['roll'];
                $new_total_yard = $bahan_baku->total_yard + $detail['total_yard'];

                $new_cost_per_yard = (
                    ($bahan_baku->total_yard * $bahan_baku->cost_per_yard) +
                    ($detail['total_yard'] * $detail['cost_per_yard'])
                ) / $new_total_yard;

                $bahan_baku->update([
                    'total_roll' => $new_total_roll,
                    'total_yard' => $new_total_yard,
                    'cost_per_yard' => $new_cost_per_yard,
                ]);
            }
        }

        return ResponseHelper::created($data->load('details.bahanBaku'), 'Incoming bahan baku berhasil ditambahkan');
    }

    public function show($id)
    {
        $data = IncomingBahanBaku::with(['suppliers', 'details.bahanBaku', 'details.bahanBaku.color', 'details.bahanBaku.code'])->find($id);

        if ($data) {
            // Modifikasi price_per_yard sebelum return
            $data->details->map(function ($detail) {
                $bahanBaku = $detail->bahanBaku;
                if ($bahanBaku) {
                    $bahanBaku->price_per_yard = floatval($bahanBaku->price_per_yard) == intval($bahanBaku->price_per_yard)
                        ? intval($bahanBaku->price_per_yard)
                        : number_format($bahanBaku->price_per_yard, 2);
                }
                return $detail;
            });

            return ResponseHelper::success($data);
        }

        return ResponseHelper::notFound();
    }
}
