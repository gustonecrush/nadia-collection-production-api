<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BahanMentahProduksi extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    public function bahanMentah()
    {
        return $this->belongsTo(BahanMentah::class, 'id_bahan_mentah');
    }

    public function hasilProduksi()
    {
        return $this->belongsTo(HasilProduksi::class, 'id_hasil_produksi');
    }
}