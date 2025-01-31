<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Category;
use App\Helpers\ResponseHelper;


class CategoriesController extends Controller
{
    private function validateCategory($data)
    {
        return Validator::make($data, [
            'category' => 'required|string',
            'remarks' => 'nullable|string',
            'is_active' => 'required|boolean',
        ]);
    }

    private function findCategory($id)
    {
        return Category::find($id);
    }

    public function index()
    {
        $datas = Category::all();

        if (count($datas) > 0) {
            return ResponseHelper::success($datas);
        }

        return ResponseHelper::notFound();
    }

    public function show($id)
    {
        $data = Category::find($id);

        if ($data) {
            return ResponseHelper::success($data);
        }

        return ResponseHelper::notFound();
    }

    public function store(Request $request)
    {
        $validator = $this->validateCategory($request->all());

        if ($validator->fails()) {
            return ResponseHelper::error($validator->errors());
        }

        $data = Category::create($request->all());

        return ResponseHelper::created($data);
    }

    public function update($id, Request $request)
    {
        $validator = $this->validateCategory($request->all());

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
