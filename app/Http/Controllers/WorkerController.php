<?php

namespace App\Http\Controllers;

use App\Models\WorkerType;
use Illuminate\Http\Request;
use App\Helpers\ResponseHelper;
use App\Models\Worker;
use Illuminate\Support\Facades\Validator;

class WorkerController extends Controller
{
    private function validateWorker(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'contact' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'is_active' => 'required|boolean',
            'type' => 'nullable|string|',
            'min_cost' => 'nullable|numeric|min:0',
        ]);

        return $validator;
    }

    public function index(Request $request)
    {
        $query = Worker::with([
            'workerTypes' => function ($q) use ($request) {
                if ($request->has('type')) {
                    $q->where('worker_type', $request->input('type'));
                }
            },
            'workerPrices' => function ($q) use ($request) {
                if ($request->has('type')) {
                    $q->whereHas('workerType', function ($q2) use ($request) {
                        $q2->where('worker_type', $request->input('type'));
                    });
                }
            },
            'workerPrices.materialCategory'
        ])->whereHas('workerTypes', function ($q) use ($request) {
            if ($request->has('type')) {
                $q->where('worker_type', $request->input('type'));
            }
        });

        $datas = $query->get();


        $result = $datas->map(function ($data) {
            return [
                'id' => $data->id,
                'name' => $data->name,
                'contact' => $data->contact,
                'address' => $data->address,
                'is_active' => $data->is_active,
                'worker_types' => $data->workerTypes->map(function ($type) {
                    return [
                        'worker_type' => $type->worker_type,
                        'min_cost' => $type->pivot->min_cost,
                        'is_active' => $type->pivot->is_active,
                    ];
                }),
                'prices' => $data->workerPrices->map(function ($price) {
                    return [
                        'material_category' => $price->materialCategory->category,
                        'min_cost' => $price->min_cost,
                        'cost_per_yard' => $price->cost_per_yard,
                    ];
                })
            ];
        });

        return ResponseHelper::success($result);
    }


    public function store(Request $request)
    {
        $validator = $this->validateWorker($request);

        if ($validator->fails()) {
            return ResponseHelper::error($validator->errors());
        }

        // Cek apakah pekerja dengan nama, contact, dan alamat yang sama sudah ada
        $worker = Worker::where('name', $request->input('name'))
            ->where('contact', $request->input('contact'))
            ->where('address', $request->input('address'))
            ->first();

        if (!$worker) {
            // Jika tidak ada, buat pekerja baru
            $worker = Worker::create($request->only(['name', 'contact', 'address', 'is_active']));
        }

        // Menambahkan atau memperbarui worker_type jika ada
        if ($request->filled('type')) {
            $workerType = WorkerType::firstOrCreate([
                'worker_type' => $request->input('type'),
            ]);

            $worker->workerTypes()->syncWithoutDetaching([
                $workerType->id => [
                    'min_cost' => $request->input('min_cost', 0),
                    'is_active' => $request->input('is_active', true),
                ]
            ]);
        }

        return ResponseHelper::created($worker);
    }
}
