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
            'type' => 'nullable|string|unique:worker_types,worker_type',  // Validasi untuk 'type', pastikan type unik
            'min_cost' => 'nullable|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return ResponseHelper::error($validator->errors());
        }
    }

    public function index(Request $request)
    {
        $query = Worker::with(['workerTypes.workerPrices.materialCategory'])
            ->whereHas('workerTypes', function ($q) use ($request) {
                if ($request->has('types')) {
                    $q->where('worker_types.worker_type', $request->input('types'));
                }
            });

        $datas = $query->get();

        $result = $datas->map(function ($data) {
            $dataArray = $data->toArray();
            $dataArray['worker_types'] = $data->workerTypes->map(function ($type) {
                $typeArray = $type->toArray();
                $typeArray['min_cost'] = $type->pivot->min_cost;
                $typeArray['is_active'] = $type->pivot->is_active;
                $typeArray['materials'] = $type->workerPrices->map(function ($dataPrice) {
                    return $dataPrice->materialCategory->toArray() + [
                        'price_per_yard' => $dataPrice->price_per_yard,
                    ];
                });
                return $typeArray;
            });
            return $dataArray;
        });

        if ($result->isEmpty()) {
            return ResponseHelper::notFound();
        }

        return ResponseHelper::success($result);
    }

    public function store(Request $request)
    {
        $validator = $this->validateWorker($request);

        if ($validator->fails()) {
            return ResponseHelper::error($validator->errors());
        }

        $data = Worker::create($request->only(['name', 'contact', 'address', 'is_active']));

        if ($request->has('types')) {
            $worker_type = WorkerType::firstOrCreate([
                'worker_type' => $request->input('type'),
            ]);

            $data->workerTypes()->attach($worker_type->id, [
                'min_cost' => $request->input('min_cost', 0),
                'is_active' => $request->input('is_active', true),
            ]);
        }

        return ResponseHelper::created($data);
    }
}
