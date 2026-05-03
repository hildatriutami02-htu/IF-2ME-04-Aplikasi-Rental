<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        Product::truncate();

        Product::insert([
            ['id'=>1,'kode_barang'=>'BRG001','nama_barang'=>'Canon EOS 80D','jenis_barang'=>'Kamera','harga'=>150000,'unit'=>5,'status'=>'Ready','deskripsi'=>'Kamera DSLR Canon 80D','gambar'=>'canon-eos-80d.jpeg'],
            ['id'=>2,'kode_barang'=>'BRG002','nama_barang'=>'Nikon D7500','jenis_barang'=>'Kamera','harga'=>160000,'unit'=>4,'status'=>'Ready','deskripsi'=>'Kamera DSLR Nikon','gambar'=>'nikon-d7500.jpeg'],
            ['id'=>3,'kode_barang'=>'BRG003','nama_barang'=>'Sony A6000','jenis_barang'=>'Kamera','harga'=>140000,'unit'=>3,'status'=>'Ready','deskripsi'=>'Mirrorless Sony','gambar'=>'sony-a6000.jpg'],
            ['id'=>4,'kode_barang'=>'BRG004','nama_barang'=>'Canon EOS M50','jenis_barang'=>'Kamera','harga'=>170000,'unit'=>2,'status'=>'Ready','deskripsi'=>'Mirrorless Canon','gambar'=>'canon-eos-m50.jpg'],
            ['id'=>5,'kode_barang'=>'BRG005','nama_barang'=>'Sony A7 III','jenis_barang'=>'Kamera','harga'=>250000,'unit'=>2,'status'=>'Ready','deskripsi'=>'Full Frame Sony','gambar'=>'sony-a7.jpg'],
            ['id'=>6,'kode_barang'=>'BRG006','nama_barang'=>'GoPro Hero 9','jenis_barang'=>'Kamera','harga'=>120000,'unit'=>6,'status'=>'Ready','deskripsi'=>'Action cam GoPro','gambar'=>'gopro-hero-9.jpg'],
            ['id'=>7,'kode_barang'=>'BRG007','nama_barang'=>'DJI Osmo Pocket','jenis_barang'=>'Kamera','harga'=>130000,'unit'=>3,'status'=>'Ready','deskripsi'=>'Kamera stabilizer','gambar'=>'dji-osmo-pocket.png'],
            ['id'=>8,'kode_barang'=>'BRG008','nama_barang'=>'Canon EOS 700D','jenis_barang'=>'Kamera','harga'=>100000,'unit'=>5,'status'=>'Ready','deskripsi'=>'DSLR entry level','gambar'=>'canon-eos-700d.jpg'],
            ['id'=>9,'kode_barang'=>'BRG009','nama_barang'=>'Nikon D5600','jenis_barang'=>'Kamera','harga'=>150000,'unit'=>4,'status'=>'Ready','deskripsi'=>'DSLR Nikon','gambar'=>'nikon-d5600.jpg'],
            ['id'=>10,'kode_barang'=>'BRG010','nama_barang'=>'Sony ZV-E10','jenis_barang'=>'Kamera','harga'=>180000,'unit'=>3,'status'=>'Ready','deskripsi'=>'Kamera vlog','gambar'=>'sony-zv-e10.jpg'],

            ['id'=>16,'kode_barang'=>'BRG016','nama_barang'=>'Tenda 2 Orang','jenis_barang'=>'Camping','harga'=>80000,'unit'=>5,'status'=>'Ready','deskripsi'=>'Tenda kecil 2 orang','gambar'=>'tenda-2-orang.jpeg'],
            ['id'=>17,'kode_barang'=>'BRG017','nama_barang'=>'Tenda 4 Orang','jenis_barang'=>'Camping','harga'=>100000,'unit'=>4,'status'=>'Ready','deskripsi'=>'Tenda keluarga','gambar'=>'tenda-4-orang.jpeg'],
            ['id'=>18,'kode_barang'=>'BRG018','nama_barang'=>'Sleeping Bag','jenis_barang'=>'Camping','harga'=>30000,'unit'=>10,'status'=>'Ready','deskripsi'=>'Sleeping bag hangat','gambar'=>'sleeping-bag.jpg'],
            ['id'=>19,'kode_barang'=>'BRG019','nama_barang'=>'Matras Camping','jenis_barang'=>'Camping','harga'=>20000,'unit'=>8,'status'=>'Ready','deskripsi'=>'Matras ringan','gambar'=>'matras-camping.jpg'],
            ['id'=>20,'kode_barang'=>'BRG020','nama_barang'=>'Kompor Portable','jenis_barang'=>'Camping','harga'=>30000,'unit'=>6,'status'=>'Ready','deskripsi'=>'Kompor gas kecil','gambar'=>'kompor-portable.jpg'],
            ['id'=>26,'kode_barang'=>'BRG026','nama_barang'=>'Jas Hujan','jenis_barang'=>'Camping','harga'=>10000,'unit'=>7,'status'=>'Ready','deskripsi'=>'Raincoat outdoor','gambar'=>'jas-hujan.jpg'],
        ]);
    }
}