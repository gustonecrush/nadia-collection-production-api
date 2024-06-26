<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HasilProduksi extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    public function bahanMentahProduksi()
    {
        return $this->hasMany(BahanMentahProduksi::class, 'id_hasil_produksi');
    }
}