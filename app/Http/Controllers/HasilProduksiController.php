<?php

namespace App\Http\Controllers;

use App\Models\HasilProduksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HasilProduksiController extends Controller
{
    public function index()
    {
        $hasilProduksis = HasilProduksi::all();
        return view('hasil_produksis.index', compact('hasilProduksis'));
    }

    public function create()
    {
        return view('hasil_produksis.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'harga' => 'required|integer',
            'tanggal_produksi' => 'nullable|date',
            'stok' => 'required|integer',
            'penanggung_jawab' => 'required|string|max:255',
            'file_foto_produk' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $filePath = $request->file('file_foto_produk')->store('hasil_produksi_images', 'public');

        HasilProduksi::create([
            'nama' => $request->nama,
            'harga' => $request->harga,
            'tanggal_produksi' => $request->tanggal_produksi,
            'stok' => $request->stok,
            'penanggung_jawab' => $request->penanggung_jawab,
            'file_foto_produk' => $filePath,
        ]);

        return redirect()->route('hasil-produksis.index')->with('success', 'Hasil Produksi created successfully.');
    }

    public function show($id)
    {
        $hasilProduksi = HasilProduksi::findOrFail($id);
        return view('hasil_produksis.show', compact('hasilProduksi'));
    }

    public function edit($id)
    {
        $hasilProduksi = HasilProduksi::findOrFail($id);
        return view('hasil_produksis.edit', compact('hasilProduksi'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'harga' => 'required|integer',
            'tanggal_produksi' => 'nullable|date',
            'stok' => 'required|integer',
            'penanggung_jawab' => 'required|string|max:255',
            'file_foto_produk' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $hasilProduksi = HasilProduksi::findOrFail($id);

        if ($request->hasFile('file_foto_produk')) {
            Storage::disk('public')->delete($hasilProduksi->file_foto_produk);

            $filePath = $request->file('file_foto_produk')->store('hasil_produksi_images', 'public');
            $hasilProduksi->file_foto_produk = $filePath;
        }

        $hasilProduksi->update([
            'nama' => $request->nama,
            'harga' => $request->harga,
            'tanggal_produksi' => $request->tanggal_produksi,
            'stok' => $request->stok,
            'penanggung_jawab' => $request->penanggung_jawab,
        ]);

        return redirect()->route('hasil-produksis.index')->with('success', 'Hasil Produksi updated successfully.');
    }

    public function destroy($id)
    {
        $hasilProduksi = HasilProduksi::findOrFail($id);

        Storage::disk('public')->delete($hasilProduksi->file_foto_produk);

        $hasilProduksi->delete();

        return redirect()->route('hasil-produksis.index')->with('success', 'Hasil Produksi deleted successfully.');
    }
}