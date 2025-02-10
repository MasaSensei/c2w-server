<?php

namespace App\Http\Controllers;

use App\Models\Batch;
use App\Helpers\ResponseHelper;
use App\Models\OrderBahanBakuDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class BatchController extends Controller
{
    private function validateBatch($data)
    {
        return Validator::make($data, [
            'batch_number' => 'required|string|unique:batches,batch_number',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'status' => 'required|string',
            'remarks' => 'nullable|string',
            'is_active' => 'boolean',
            'details' => 'required|array|min:1',
            'details.*.id_reference' => 'required',
            'details.*.product_code' => 'required|string',
            'details.*.reference_type' => 'required|in:cutters,sewer,client',
            'details.*.quantity' => 'required|integer|min:1',
            'details.*.total_yard' => 'required|numeric|min:0',
            'details.*.cost_per_yard' => 'required|numeric|min:0',
            'details.*.sub_total' => 'required|numeric|min:0',
            'details.*.remarks' => 'nullable|string',
            'details.*.is_active' => 'boolean',
        ]);
    }

    private function findBatch($id)
    {
        return Batch::find($id)->with('details');
    }

    private function getReferenceDetail($detail)
    {
        switch ($detail->reference_type) {
            case 'cutters':
                return OrderBahanBakuDetails::with('orderBahanBaku')->where('id', $detail->id_reference)->first();
            default:
                return null;
        }
    }

    public function index(Request $request)
    {
        $batches = Batch::with(['details' => function ($query) use ($request) {
            if ($request->has('reference_type')) {
                $query->where('reference_type', $request->reference_type);
            }
        }])->get();

        // Tambahkan informasi dari tabel referensi
        $batches->transform(function ($batch) {
            $batch->details->transform(function ($detail) {
                $detail->reference = $this->getReferenceDetail($detail);
                return $detail;
            });
            return $batch;
        });

        return ResponseHelper::success($batches);
    }

    public function show(Request $request, $id)
    {
        $batch = Batch::with('details')->find($id);

        if (!$batch) {
            return ResponseHelper::notFound();
        }

        // Tambahkan informasi dari tabel referensi
        $batch->details->transform(function ($detail) {
            $detail->reference = $this->getReferenceDetail($detail);
            return $detail;
        });

        return ResponseHelper::success($batch);
    }

    public function store(Request $request)
    {
        $validator = $this->validateBatch($request->all());

        if ($validator->fails()) {
            return ResponseHelper::error($validator->errors());
        }

        $quantity = count($request->details);

        $batch = Batch::create([
            'batch_number' => $request->batch_number,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'status' => $request->status,
            'quantity' => $quantity, // Jumlah details sebagai quantity
            'remarks' => $request->remarks,
            'is_active' => $request->is_active,
        ]);

        // Menambahkan id_batch ke setiap detail sebelum disimpan
        foreach ($request->details as $detail) {
            $detail['id_batch'] = $batch->id;
            $batch->details()->create($detail);
        }

        return ResponseHelper::success($batch);
    }
}
