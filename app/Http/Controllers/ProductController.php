<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::latest()->get();

        return view('admin.products', compact('products'));
    }
    public function show($id)
    {
        $product = Product::findOrFail((int) $id);

        return view('admin.products-detail', compact('product'));
    }
    public function edit($id)
    {
        $product = Product::findOrFail((int) $id);

        return view('admin.products-edit', compact('product'));
    }
    public function detailPelanggan($id)
    {
        $product = Product::findOrFail((int) $id);

        return view('detail', compact('product'));
    }
    public function produkPelanggan(Request $request)
    {
        $query = Product::query();

        if ($request->search) {
            $query->where('nama_barang', 'like', '%' . $request->search . '%');
        }

        if ($request->kategori) {
            $query->where('jenis_barang', $request->kategori);
        }

        if ($request->sort == 'murah') {
            $query->orderBy('harga', 'asc');
        } elseif ($request->sort == 'mahal') {
            $query->orderBy('harga', 'desc');
        } elseif ($request->sort == 'stok') {
            $query->orderBy('unit', 'desc');
        } else {
            $query->latest();
        }

        $products = $query->get();
        return view('pelanggan.produk', compact('products'));
    }
}