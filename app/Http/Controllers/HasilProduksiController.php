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
        return response()->json($hasilProduksis);
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

        $hasilProduksi = HasilProduksi::create([
            'nama' => $request->nama,
            'harga' => $request->harga,
            'tanggal_produksi' => $request->tanggal_produksi,
            'stok' => $request->stok,
            'penanggung_jawab' => $request->penanggung_jawab,
            'file_foto_produk' => $filePath,
        ]);

        return response()->json(['message' => 'Hasil Produksi created successfully.', 'hasilProduksi' => $hasilProduksi], 201);
    }

    public function show($id)
    {
        $hasilProduksi = HasilProduksi::findOrFail($id);
        return response()->json($hasilProduksi);
    }

    public function updateHasilProduksi(Request $request, $id)
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

        return response()->json(['message' => 'Hasil Produksi updated successfully.', 'hasilProduksi' => $hasilProduksi]);
    }

    public function destroy($id)
    {
        $hasilProduksi = HasilProduksi::findOrFail($id);

        Storage::disk('public')->delete($hasilProduksi->file_foto_produk);

        $hasilProduksi->delete();

        return response()->json(['message' => 'Hasil Produksi deleted successfully.']);
    }
}
