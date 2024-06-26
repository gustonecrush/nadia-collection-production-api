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
        return view('bahan_mentahs.index', compact('bahanMentahs'));
    }

    public function create()
    {
        $suppliers = Supplier::all();
        return view('bahan_mentahs.create', compact('suppliers'));
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

        BahanMentah::create([
            'supplier_id' => $request->supplier_id,
            'nama' => $request->nama,
            'kuantitas' => $request->kuantitas,
            'satuan' => $request->satuan,
            'harga' => $request->harga,
            'file_gambar' => $filePath,
        ]);

        return redirect()->route('bahan_mentahs.index')->with('success', 'Bahan Mentah created successfully.');
    }

    public function show($id)
    {
        $bahanMentah = BahanMentah::with('supplier')->findOrFail($id);
        return view('bahan_mentahs.show', compact('bahanMentah'));
    }

    public function edit($id)
    {
        $bahanMentah = BahanMentah::findOrFail($id);
        $suppliers = Supplier::all();
        return view('bahan_mentahs.edit', compact('bahanMentah', 'suppliers'));
    }

    public function update(Request $request, $id)
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

        return redirect()->route('bahan_mentahs.index')->with('success', 'Bahan Mentah updated successfully.');
    }

    public function destroy($id)
    {
        $bahanMentah = BahanMentah::findOrFail($id);

        Storage::disk('public')->delete($bahanMentah->file_gambar);

        $bahanMentah->delete();

        return redirect()->route('bahan_mentahs.index')->with('success', 'Bahan Mentah deleted successfully.');
    }
}