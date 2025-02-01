<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\BahanBaku;
use App\Helpers\ResponseHelper;


class BahanBakuController extends Controller
{
    private function validateBahanBaku($data)
    {
        return Validator::make($data, [
            'id_color' => 'required|integer',
            'id_code' => 'required|integer',
            'item' => 'required|string',
            'remarks' => 'nullable|string',
            'total_roll' => 'nullable|integer',
            'total_yard' => 'nullable|numeric',
            'cost_per_yard' => 'nullable|numeric',
            'is_active' => 'required|boolean',
        ]);
    }

    private function findCategory($id)
    {
        return BahanBaku::find($id);
    }

    public function index()
    {
        $datas = BahanBaku::with('color', 'code')->get();

        if (count($datas) > 0) {
            return ResponseHelper::success($datas);
        }

        return ResponseHelper::notFound();
    }

    public function show($id)
    {
        $data = BahanBaku::find($id);

        if ($data) {
            return ResponseHelper::success($data);
        }

        return ResponseHelper::notFound();
    }

    public function store(Request $request)
    {
        $validator = $this->validateBahanBaku($request->all());

        if ($validator->fails()) {
            return ResponseHelper::error($validator->errors());
        }

        $data = BahanBaku::create($request->all());

        return ResponseHelper::created($data);
    }

    public function update($id, Request $request)
    {
        $validator = $this->validateBahanBaku($request->all());

        if ($validator->fails()) {
            return ResponseHelper::error($validator->errors());
        }

        $data = $this->findCategory($id);

        if ($data) {
            $data->update($request->all());
            return ResponseHelper::edit($data);
        }

        return ResponseHelper::notFound();
    }

    public function destroy($id, Request $request)
    {
        $data = $this->findCategory($id);

        if ($data) {
            $data->update([
                'is_active' => false
            ]);
            $data->delete();
            return ResponseHelper::deleted();
        }

        return ResponseHelper::notFound();
    }
}
