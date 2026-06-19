<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();

        if ($request->search) {
            $query->where('nama_barang', 'like', '%' . $request->search . '%');
        }

        if ($request->kategori) {
            $query->where('jenis_barang', $request->kategori);
        }

        if ($request->sort === 'murah') {
            $query->orderBy('harga', 'asc');
        } elseif ($request->sort === 'mahal') {
            $query->orderBy('harga', 'desc');
        } elseif ($request->sort === 'stok') {
            $query->orderBy('unit', 'desc');
        } else {
            $query->latest();
        }

        $products = $query->get();

        return view('pelanggan.produk', compact('products'));
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);

        return view('pelanggan.detail', compact('product'));
    }
}