<?php

namespace App\Http\Controllers;

use App\Models\DataUser;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // ================= DASHBOARD =================
    public function dashboard()
    {
        $products = collect([
            ['id'=>1,'nama_barang'=>'Canon EOS 80D','jenis_barang'=>'Kamera','harga'=>150000,'unit'=>5,'status'=>'Ready','deskripsi'=>'Kamera DSLR Canon 80D','gambar'=> 'canon-eos-80d.jpeg'],
            ['id'=>2,'nama_barang'=>'Nikon D7500','jenis_barang'=>'Kamera','harga'=>160000,'unit'=>4,'status'=>'Ready','deskripsi'=>'Kamera DSLR Nikon','gambar'=> 'nikon-d7500.jpeg'],
            ['id'=>3,'nama_barang'=>'Sony A6000','jenis_barang'=>'Kamera','harga'=>140000,'unit'=>3,'status'=>'Ready','deskripsi'=>'Mirrorless Sony','gambar'=> 'sony-a6000.jpg'],
            ['id'=>4,'nama_barang'=>'Canon EOS M50','jenis_barang'=>'Kamera','harga'=>170000,'unit'=>2,'status'=>'Ready','deskripsi'=>'Mirrorless Canon','gambar'=> 'canon-eos-m50.jpg'],
            ['id'=>5,'nama_barang'=>'Sony A7 III','jenis_barang'=>'Kamera','harga'=>250000,'unit'=>2,'status'=>'Ready','deskripsi'=>'Full Frame Sony','gambar'=> 'sony-a7.jpg'],
            ['id'=>6,'nama_barang'=>'GoPro Hero 9','jenis_barang'=>'Kamera','harga'=>120000,'unit'=>6,'status'=>'Ready','deskripsi'=>'Action cam GoPro','gambar'=> 'gopro-hero-9.jpg'],
            ['id'=>7,'nama_barang'=>'DJI Osmo Pocket','jenis_barang'=>'Kamera','harga'=>130000,'unit'=>3,'status'=>'Ready','deskripsi'=>'Kamera stabilizer','gambar'=> 'dji-osmo-pocket.png'],
            ['id'=>8,'nama_barang'=>'Canon EOS 700D','jenis_barang'=>'Kamera','harga'=>100000,'unit'=>5,'status'=>'Ready','deskripsi'=>'DSLR entry level','gambar'=> 'canon-eos-700d.jpg'],
            ['id'=>9,'nama_barang'=>'Nikon D5600','jenis_barang'=>'Kamera','harga'=>150000,'unit'=>4,'status'=>'Ready','deskripsi'=>'DSLR Nikon','gambar'=> 'nikon-d5600.jpg'],
            ['id'=>10,'nama_barang'=>'Sony ZV-E10','jenis_barang'=>'Kamera','harga'=>180000,'unit'=>3,'status'=>'Ready','deskripsi'=>'Kamera vlog','gambar'=> 'sony-zv-e10.jpg'],

            ['id'=>16,'nama_barang'=>'Tenda 2 Orang','jenis_barang'=>'Camping','harga'=>80000,'unit'=>5,'status'=>'Ready','deskripsi'=>'Tenda kecil 2 orang','gambar'=> 'tenda-2-orang.jpeg'],
            ['id'=>17,'nama_barang'=>'Tenda 4 Orang','jenis_barang'=>'Camping','harga'=>100000,'unit'=>4,'status'=>'Ready','deskripsi'=>'Tenda keluarga','gambar'=> 'tenda-4-orang.jpeg'],
            ['id'=>18,'nama_barang'=>'Sleeping Bag','jenis_barang'=>'Camping','harga'=>30000,'unit'=>10,'status'=>'Ready','deskripsi'=>'Sleeping bag hangat','gambar'=> 'sleeping-bag.jpg'],
            ['id'=>19,'nama_barang'=>'Matras Camping','jenis_barang'=>'Camping','harga'=>20000,'unit'=>8,'status'=>'Ready','deskripsi'=>'Matras ringan','gambar'=> 'matras-camping.jpg'],
            ['id'=>20,'nama_barang'=>'Kompor Portable','jenis_barang'=>'Camping','harga'=>30000,'unit'=>6,'status'=>'Ready','deskripsi'=>'Kompor gas kecil','gambar'=> 'kompor-portable.jpg'],
        ]);

        return view('pelanggan.dashboard', compact('products'));
    }

    // ================= KERANJANG =================
    public function tambahKeranjang(Request $request)
    {
        $keranjang = session('keranjang', []);

        $keranjang[] = [
            'nama_barang' => $request->nama_barang,
            'product_id' => $request->product_id,
            'qty' => $request->qty,
            'tanggal_pinjam' => $request->tanggal_pinjam,
            'tanggal_kembali' => $request->tanggal_kembali,
            'harga_per_hari' => $request->harga_per_hari
        ];

        session()->put('keranjang', $keranjang);

        return redirect()->route('pelanggan.keranjang')
            ->with('success', 'Berhasil masuk keranjang');
    }

    public function keranjang()
    {
        $cart = session('keranjang', []);
        return view('pelanggan.keranjang', compact('cart'));
    }

    public function hapusKeranjang($index)
    {
        $cart = session('keranjang', []);

        unset($cart[$index]);

        session()->put('keranjang', array_values($cart));

        return back()->with('success', 'Produk dihapus');
    }

    public function checkout(Request $request)
    {
        $cart = session('keranjang', []);

        if (empty($cart)) {
            return back()->with('error', 'Keranjang kosong');
        }

        $request->validate([
            'foto_ktp' => 'required|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $fileName = time() . '.' . $request->foto_ktp->extension();
        $request->foto_ktp->move(public_path('ktp'), $fileName);

        session()->put('sewa', [
            'items' => $cart,
            'ktp' => $fileName,
            'status' => 'menunggu',
        ]);

        session()->forget('keranjang');

        return redirect()->route('pelanggan.sewa')
            ->with('success', 'Berhasil checkout!');
    }

    public function sewa()
    {
        $sewa = session('sewa', []);
        return view('pelanggan.sewa', compact('sewa'));
    }

    public function pembayaran()
    {
        $pembayaran = session('sewa', []);
        return view('pelanggan.pembayaran', compact('pembayaran'));
    }

    // ================= ADMIN USER =================
    public function index()
    {
        $users = DataUser::orderBy('created_at', 'desc')->get();
        return view('admin.users', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_user' => 'required|unique:data_users,kode_user',
            'nama_lengkap' => 'required',
            'no_ktp' => 'required|unique:data_users,no_ktp',
            'no_telp' => 'required',
            'no_wa' => 'required',
            'jenis_kelamin' => 'required',
            'foto_ktp' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->except('foto_ktp');

        if ($request->hasFile('foto_ktp')) {
            $data['foto_ktp'] = $request->file('foto_ktp')->store('foto_ktp', 'public');
        }

        DataUser::create($data);

        return redirect()->route('admin.users.index')
            ->with('success', 'Data user berhasil ditambahkan');
    }

    public function show($id)
    {
        $user = DataUser::findOrFail($id);
        return view('admin.user-detail', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = DataUser::findOrFail($id);

        $request->validate([
            'kode_user' => 'required|unique:data_users,kode_user,' . $id,
            'nama_lengkap' => 'required',
            'no_ktp' => 'required|unique:data_users,no_ktp,' . $id,
            'no_telp' => 'required',
            'no_wa' => 'required',
            'jenis_kelamin' => 'required',
            'foto_ktp' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->except('foto_ktp');

        if ($request->hasFile('foto_ktp')) {
            $data['foto_ktp'] = $request->file('foto_ktp')->store('foto_ktp', 'public');
        }

        $user->update($data);

        return redirect()->route('admin.users.index')
            ->with('success', 'Data user berhasil diupdate');
    }

    public function destroy($id)
    {
        $user = DataUser::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'Data user berhasil dihapus');
    }
}

