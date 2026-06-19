<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::latest()->get();
        return view('admin.products', compact('products'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'kode_barang' => 'nullable|string|max:50',
            'jenis_barang' => 'required|string|max:100',
            'nama_barang' => 'required|string|max:150',
            'status' => 'nullable|string|max:50',
            'estimasi' => 'nullable|string|max:50',
            'deskripsi' => 'required|string',
            'harga' => 'required|numeric|min:0',
            'unit' => 'required|integer|min:0',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $namaGambar = time() . '-' . str_replace(' ', '-', strtolower($file->getClientOriginalName()));

            $file->move(public_path('images'), $namaGambar);

            $data['gambar'] = $namaGambar;
        }

        Product::create($data);

        return redirect()->route('admin.products')->with('success', 'Barang berhasil ditambahkan.');
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);
        return view('admin.products-detail', compact('product'));
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('admin.products-edit', compact('product'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $data = $request->validate([
            'kode_barang' => 'nullable|string|max:50',
            'jenis_barang' => 'required|string|max:100',
            'nama_barang' => 'required|string|max:150',
            'status' => 'nullable|string|max:50',
            'estimasi' => 'nullable|string|max:50',
            'deskripsi' => 'required|string',
            'harga' => 'required|numeric|min:0',
            'unit' => 'required|integer|min:0',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $namaGambar = time() . '-' . str_replace(' ', '-', strtolower($file->getClientOriginalName()));

            $file->move(public_path('images'), $namaGambar);

            $data['gambar'] = $namaGambar;
        }

        $product->update($data);

        return redirect()->route('admin.products')->with('success', 'Barang berhasil diupdate.');
    }

    public function destroy($id)
    {
        Product::findOrFail($id)->delete();

        return redirect()->route('admin.products')->with('success', 'Barang berhasil dihapus.');
    }
}