<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['kategori_id'=>1,'kategori_kode'=> 'LPP','kategori_nama'=>'Lip Product'],
            ['kategori_id'=>2,'kategori_kode'=> 'SKC','kategori_nama'=>'Skincare'],
            ['kategori_id'=>3,'kategori_kode'=> 'CXN','kategori_nama'=>'Complexion'],
            ['kategori_id'=>4,'kategori_kode'=> 'EYP','kategori_nama'=>'Eye Product'],
            ['kategori_id'=>5,'kategori_kode'=> 'PWD','kategori_nama'=>'Powder'],
        ];
        DB::table('m_kategori')->insert($data);
    }
}
