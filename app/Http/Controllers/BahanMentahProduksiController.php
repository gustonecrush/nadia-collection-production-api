<?php

namespace App\Http\Controllers;

use App\Models\BahanMentahProduksi;
use App\Models\BahanMentah;
use App\Models\HasilProduksi;
use Illuminate\Http\Request;

class BahanMentahProduksiController extends Controller
{
    public function index()
    {
        $bahanMentahProduksis = BahanMentahProduksi::with(['bahanMentah', 'hasilProduksi'])->get();
        return view('bahan_mentah_produksis.index', compact('bahanMentahProduksis'));
    }

    public function create()
    {
        $bahanMentahs = BahanMentah::all();
        $hasilProduksis = HasilProduksi::all();
        return view('bahan_mentah_produksis.create', compact('bahanMentahs', 'hasilProduksis'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_bahan_mentah' => 'required|exists:bahan_mentahs,id',
            'id_hasil_produksi' => 'required|exists:hasil_produksis,id',
            'kuantitas' => 'required|integer',
            'harga' => 'required|integer',
        ]);

        BahanMentahProduksi::create([
            'id_bahan_mentah' => $request->id_bahan_mentah,
            'id_hasil_produksi' => $request->id_hasil_produksi,
            'kuantitas' => $request->kuantitas,
            'harga' => $request->harga,
        ]);

        return redirect()->route('bahan-mentah-produksis.index')->with('success', 'Bahan Mentah Produksi created successfully.');
    }

    public function show($id)
    {
        $bahanMentahProduksi = BahanMentahProduksi::findOrFail($id);
        return view('bahan_mentah_produksis.show', compact('bahanMentahProduksi'));
    }

    public function edit($id)
    {
        $bahanMentahProduksi = BahanMentahProduksi::findOrFail($id);
        $bahanMentahs = BahanMentah::all();
        $hasilProduksis = HasilProduksi::all();
        return view('bahan_mentah_produksis.edit', compact('bahanMentahProduksi', 'bahanMentahs', 'hasilProduksis'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'id_bahan_mentah' => 'required|exists:bahan_mentahs,id',
            'id_hasil_produksi' => 'required|exists:hasil_produksis,id',
            'kuantitas' => 'required|integer',
            'harga' => 'required|integer',
        ]);

        $bahanMentahProduksi = BahanMentahProduksi::findOrFail($id);
        $bahanMentahProduksi->update([
            'id_bahan_mentah' => $request->id_bahan_mentah,
            'id_hasil_produksi' => $request->id_hasil_produksi,
            'kuantitas' => $request->kuantitas,
            'harga' => $request->harga,
        ]);

        return redirect()->route('bahan-mentah-produksis.index')->with('success', 'Bahan Mentah Produksi updated successfully.');
    }

    public function destroy($id)
    {
        $bahanMentahProduksi = BahanMentahProduksi::findOrFail($id);
        $bahanMentahProduksi->delete();
        return redirect()->route('bahan-mentah-produksis.index')->with('success', 'Bahan Mentah Produksi deleted successfully.');
    }
}