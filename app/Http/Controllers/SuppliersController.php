<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Suppliers;
use App\Helpers\ResponseHelper;

class SuppliersController extends Controller
{
    private function validateSupplier($data)
    {
        return Validator::make($data, [
            'name' => 'required|string',
            'contact' => 'required|string',
            'address' => 'required|string',
            'remarks' => 'nullable|string',
            'is_active' => 'required|boolean',
        ]);
    }

    private function findSupplier($id)
    {
        return Suppliers::find($id);
    }

    public function index()
    {
        $suppliers = Suppliers::all();

        if (count($suppliers) > 0) {
            return ResponseHelper::success($suppliers);
        }

        return ResponseHelper::notFound();
    }

    public function show($id)
    {
        $supplier = Suppliers::find($id);

        if ($supplier) {
            return ResponseHelper::success($supplier);
        }

        return ResponseHelper::notFound();
    }

    public function store(Request $request)
    {
        $validator = $this->validateSupplier($request->all());

        if ($validator->fails()) {
            return ResponseHelper::error($validator->errors());
        }

        $supplier = Suppliers::create($request->all());

        return ResponseHelper::created($supplier);
    }

    public function update($id, Request $request)
    {
        $validator = $this->validateSupplier($request->all());

        if ($validator->fails()) {
            return ResponseHelper::error($validator->errors());
        }

        $supplier = $this->findSupplier($id);

        if ($supplier) {
            $supplier->update($request->all());
            return ResponseHelper::edit($supplier);
        }

        return ResponseHelper::notFound();
    }

    public function destroy($id, Request $request)
    {
        $supplier = $this->findSupplier($id);

        if ($supplier) {
            $supplier->delete();
            return ResponseHelper::deleted();
        }

        return ResponseHelper::notFound();
    }
}
