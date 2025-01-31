<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Size;
use App\Helpers\ResponseHelper;


class SizeController extends Controller
{

    private function validatesize($data)
    {
        return Validator::make($data, [
            'size' => 'required|string',
            'remarks' => 'nullable|string',
            'is_active' => 'required|boolean',
        ]);
    }

    private function findsize($id)
    {
        return size::find($id);
    }

    public function index()
    {
        $datas = size::all();

        if (count($datas) > 0) {
            return ResponseHelper::success($datas);
        }

        return ResponseHelper::notFound();
    }

    public function show($id)
    {
        $data = size::find($id);

        if ($data) {
            return ResponseHelper::success($data);
        }

        return ResponseHelper::notFound();
    }

    public function store(Request $request)
    {
        $validator = $this->validatesize($request->all());

        if ($validator->fails()) {
            return ResponseHelper::error($validator->errors());
        }

        $data = size::create($request->all());

        return ResponseHelper::created($data);
    }

    public function update($id, Request $request)
    {
        $validator = $this->validatesize($request->all());

        if ($validator->fails()) {
            return ResponseHelper::error($validator->errors());
        }

        $data = $this->findsize($id);

        if ($data) {
            $data->update($request->all());
            return ResponseHelper::edit($data);
        }

        return ResponseHelper::notFound();
    }

    public function destroy($id, Request $request)
    {
        $data = $this->findsize($id);

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
