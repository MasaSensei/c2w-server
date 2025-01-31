<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Model;
use App\Helpers\ResponseHelper;


class ModelController extends Controller
{

    private function validateModel($data)
    {
        return Validator::make($data, [
            'model' => 'required|string',
            'remarks' => 'nullable|string',
            'is_active' => 'required|boolean',
        ]);
    }

    private function findModel($id)
    {
        return model::find($id);
    }

    public function index()
    {
        $datas = model::all();

        if (count($datas) > 0) {
            return ResponseHelper::success($datas);
        }

        return ResponseHelper::notFound();
    }

    public function show($id)
    {
        $data = model::find($id);

        if ($data) {
            return ResponseHelper::success($data);
        }

        return ResponseHelper::notFound();
    }

    public function store(Request $request)
    {
        $validator = $this->validateModel($request->all());

        if ($validator->fails()) {
            return ResponseHelper::error($validator->errors());
        }

        $data = model::create($request->all());

        return ResponseHelper::created($data);
    }

    public function update($id, Request $request)
    {
        $validator = $this->validateModel($request->all());

        if ($validator->fails()) {
            return ResponseHelper::error($validator->errors());
        }

        $data = $this->findModel($id);

        if ($data) {
            $data->update($request->all());
            return ResponseHelper::edit($data);
        }

        return ResponseHelper::notFound();
    }

    public function destroy($id, Request $request)
    {
        $data = $this->findModel($id);

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
