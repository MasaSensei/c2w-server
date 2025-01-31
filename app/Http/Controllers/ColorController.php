<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Color;
use App\Helpers\ResponseHelper;


class ColorController extends Controller
{

    private function validateColor($data)
    {
        return Validator::make($data, [
            'color' => 'required|string',
            'remarks' => 'nullable|string',
            'is_active' => 'required|boolean',
        ]);
    }

    private function findColor($id)
    {
        return color::find($id);
    }

    public function index()
    {
        $colors = color::all();

        if (count($colors) > 0) {
            return ResponseHelper::success($colors);
        }

        return ResponseHelper::notFound();
    }

    public function show($id)
    {
        $color = color::find($id);

        if ($color) {
            return ResponseHelper::success($color);
        }

        return ResponseHelper::notFound();
    }

    public function store(Request $request)
    {
        $validator = $this->validateColor($request->all());

        if ($validator->fails()) {
            return ResponseHelper::error($validator->errors());
        }

        $color = color::create($request->all());

        return ResponseHelper::created($color);
    }

    public function update($id, Request $request)
    {
        $validator = $this->validateColor($request->all());

        if ($validator->fails()) {
            return ResponseHelper::error($validator->errors());
        }

        $color = $this->findColor($id);

        if ($color) {
            $color->update($request->all());
            return ResponseHelper::edit($color);
        }

        return ResponseHelper::notFound();
    }

    public function destroy($id, Request $request)
    {
        $color = $this->findColor($id);

        if ($color) {
            $color->update([
                'is_active' => false
            ]);
            $color->delete();
            return ResponseHelper::deleted();
        }

        return ResponseHelper::notFound();
    }
}
