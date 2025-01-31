<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Code;
use App\Helpers\ResponseHelper;


class CodeController extends Controller
{

    private function validateCode($data)
    {
        return Validator::make($data, [
            'code' => 'required|string',
            'remarks' => 'nullable|string',
            'is_active' => 'required|boolean',
        ]);
    }

    private function findCode($id)
    {
        return Code::find($id);
    }

    public function index()
    {
        $codes = Code::all();

        if (count($codes) > 0) {
            return ResponseHelper::success($codes);
        }

        return ResponseHelper::notFound();
    }

    public function show($id)
    {
        $code = Code::find($id);

        if ($code) {
            return ResponseHelper::success($code);
        }

        return ResponseHelper::notFound();
    }

    public function store(Request $request)
    {
        $validator = $this->validateCode($request->all());

        if ($validator->fails()) {
            return ResponseHelper::error($validator->errors());
        }

        $code = Code::create($request->all());

        return ResponseHelper::created($code);
    }

    public function update($id, Request $request)
    {
        $validator = $this->validateCode($request->all());

        if ($validator->fails()) {
            return ResponseHelper::error($validator->errors());
        }

        $code = $this->findCode($id);

        if ($code) {
            $code->update($request->all());
            return ResponseHelper::edit($code);
        }

        return ResponseHelper::notFound();
    }

    public function destroy($id, Request $request)
    {
        $code = $this->findCode($id);

        if ($code) {
            $code->update([
                'is_active' => false
            ]);
            $code->delete();
            return ResponseHelper::deleted();
        }

        return ResponseHelper::notFound();
    }
}
