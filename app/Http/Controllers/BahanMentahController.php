<?php

namespace App\Http\Controllers;

use App\Models\BahanMentah;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BahanMentahController extends Controller
{
    public function index()
    {
        $bahanMentahs = BahanMentah::with('supplier')->get();
        return response()->json($bahanMentahs);
    }

    public function store(Request $request)
    {
        $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'nama' => 'required|string|max:255',
            'kuantitas' => 'required|integer',
            'satuan' => 'required|string|max:50',
            'harga' => 'required|integer',
            'file_gambar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $filePath = $request->file('file_gambar')->store('bahan_mentah_images', 'public');

        $bahanMentah = BahanMentah::create([
            'supplier_id' => $request->supplier_id,
            'nama' => $request->nama,
            'kuantitas' => $request->kuantitas,
            'satuan' => $request->satuan,
            'harga' => $request->harga,
            'file_gambar' => $filePath,
        ]);

        return response()->json(['message' => 'Bahan Mentah created successfully.', 'bahanMentah' => $bahanMentah], 201);
    }

    public function show($id)
    {
        $bahanMentah = BahanMentah::with('supplier')->findOrFail($id);
        return response()->json($bahanMentah);
    }

    public function updateBahanMentah(Request $request, $id)
    {
        $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'nama' => 'required|string|max:255',
            'kuantitas' => 'required|integer',
            'satuan' => 'required|string|max:50',
            'harga' => 'required|integer',
            'file_gambar' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $bahanMentah = BahanMentah::findOrFail($id);

        if ($request->hasFile('file_gambar')) {
            Storage::disk('public')->delete($bahanMentah->file_gambar);

            $filePath = $request->file('file_gambar')->store('bahan_mentah_images', 'public');
            $bahanMentah->file_gambar = $filePath;
        }

        $bahanMentah->update([
            'supplier_id' => $request->supplier_id,
            'nama' => $request->nama,
            'kuantitas' => $request->kuantitas,
            'satuan' => $request->satuan,
            'harga' => $request->harga,
        ]);

        return response()->json(['message' => 'Bahan Mentah updated successfully.', 'bahanMentah' => $bahanMentah]);
    }

    public function destroy($id)
    {
        $bahanMentah = BahanMentah::findOrFail($id);

        Storage::disk('public')->delete($bahanMentah->file_gambar);

        $bahanMentah->delete();

        return response()->json(['message' => 'Bahan Mentah deleted successfully.']);
    }
}
