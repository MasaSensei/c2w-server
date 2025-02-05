<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class MaterialToCuttersItemCategory extends Pivot
{
    protected $table = 'material_to_cutters_item_category';

    // Jika kamu perlu mendefinisikan kolom yang bisa diisi, lakukan ini:
    protected $fillable = [
        'id_inv_cutters_material',
        'id_item_category',
    ];

    // Menambahkan relasi ke kedua tabel yang terhubung
    public function inventoryBahanBakuToCutters()
    {
        return $this->belongsTo(InventoryBahanBakuToCutters::class, 'id_inv_cutters_material');
    }

    public function itemCategory()
    {
        return $this->belongsTo(Category::class, 'id_item_category');
    }
}
