<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
        
                'kategori_id'=> 3,
                'barang_kode'=> 'CSN',
                'barang_nama'=> 'Cushion Mother of Pearl',
                'harga_beli'=> 189000,
                'harga_jual'=> 198000,
            ],
            [
             
                'kategori_id'=> 1,
                'barang_kode'=> 'LSK',
                'barang_nama'=> 'Lipstick Dior',
                'harga_beli'=> 154000,
                'harga_jual'=> 175000,
            ],
            [
                
                'kategori_id'=> 4,
                'barang_kode'=> 'MSC',
                'barang_nama'=> 'Mascara OTWOO',
                'harga_beli'=> 90000,
                'harga_jual'=> 100000,
            ],
            [
               
                'kategori_id'=> 2,
                'barang_kode'=> 'MSK',
                'barang_nama'=> 'Masker FFY',
                'harga_beli'=> 75000,
                'harga_jual'=> 80000,
            ],
            [
                'kategori_id'=> 5,
                'barang_kode'=> 'LPW',
                'barang_nama'=> 'Loose Powder Somethinc',
                'harga_beli'=> 50000,
                'harga_jual'=> 60000,
            ],
            [

                'kategori_id'=> 3,
                'barang_kode'=> 'FDN',
                'barang_nama'=> 'Foundation Guele',
                'harga_beli'=> 189000,
                'harga_jual'=> 198000,
            ],
            [

                'kategori_id'=> 1,
                'barang_kode'=> 'LGE',
                'barang_nama'=> 'Lip Glaze MakeOver',
                'harga_beli'=> 15000,
                'harga_jual'=> 17000,
            ],
            [
 
                'kategori_id'=> 4,
                'barang_kode'=> 'MSJ',
                'barang_nama'=> 'Mascara JudyDoll',
                'harga_beli'=> 40000,
                'harga_jual'=> 45000,
            ],
            [
     
                'kategori_id'=> 2,
                'barang_kode'=> 'TNR',
                'barang_nama'=> 'Toner Skin1004',
                'harga_beli'=> 10000,
                'harga_jual'=> 20000,
            ],
            [
    
                'kategori_id'=> 5,
                'barang_kode'=> 'SPW',
                'barang_nama'=> 'Setting Powder Guele',
                'harga_beli'=> 30000,
                'harga_jual'=> 50000,
            ],
            ];
            DB::table('m_barang')->insert($data);
    }
}
