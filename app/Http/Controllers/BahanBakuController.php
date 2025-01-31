<?php

namespace App\Http\Controllers;

use App\Models\BahanBaku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Helpers\ResponseHelper;

class BahanBakuController extends Controller
{
    private function validateBahanBaku($data)
    {
        return Validator::make($data, [
            'id_code'   => 'required|exists:code,id',
            'id_color'  => 'required|exists:color,id',
            'total_roll' => 'nullable|integer|min:0',
            'total_yard' => 'nullable|numeric|min:0',
            'cost_per_yard' => 'nullable|numeric|min:0',
            'remarks' => 'nullable|string',
            'is_active' => 'required|boolean',
            'item_categories' => 'nullable|array', // Ubah dari item_category ke item_categories
            'item_categories.*' => 'exists:item_categories,id', // Validasi kategori
        ]);
    }

    private function findBahanBaku($id)
    {
        return BahanBaku::with('category')->find($id);
    }

    public function index()
    {
        $datas = BahanBaku::active()->with(['category', 'code', 'color'])->get();

        $datas->each(function ($data) {
            $data->makeHidden(['id_code', 'id_color']);
            $data->category->each(function ($category) {
                $category->makeHidden('pivot'); // Menyembunyikan pivot di setiap kategori
            });
        });

        return count($datas) > 0 ? ResponseHelper::success($datas) : ResponseHelper::notFound();
    }

    public function show($id)
    {
        $data = $this->findBahanBaku($id);
        if ($data) {
            // Menyembunyikan pivot pada kategori
            $data->category->each(function ($category) {
                $category->makeHidden('pivot');
            });
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

        $data = BahanBaku::create($request->except('item_categories'));

        if ($request->has('item_categories')) {
            $data->category()->sync($request->item_categories);
        }

        // Menyembunyikan pivot pada kategori
        $data->category->each(function ($category) {
            $category->makeHidden('pivot');
        });

        return ResponseHelper::created($data->load('category'));
    }

    public function update($id, Request $request)
    {
        $validator = $this->validateBahanBaku($request->all());
        if ($validator->fails()) {
            return ResponseHelper::error($validator->errors());
        }

        $data = $this->findBahanBaku($id);
        if ($data) {
            $data->update($request->except('item_categories'));

            if ($request->has('item_categories')) {
                $data->category()->sync($request->item_categories);
            }

            // Menyembunyikan pivot pada kategori
            $data->category->each(function ($category) {
                $category->makeHidden('pivot');
            });

            return ResponseHelper::edit($data->load('category'));
        }

        return ResponseHelper::notFound();
    }

    public function destroy($id)
    {
        $data = $this->findBahanBaku($id);
        if ($data) {
            $data->category()->detach(); // Hapus relasi kategori sebelum delete
            $data->delete();
            return ResponseHelper::deleted();
        }

        return ResponseHelper::notFound();
    }
}
