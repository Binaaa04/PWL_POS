<?php

namespace Database\Factories;

use App\Models\Detailm; // Menggunakan model Detailm
use App\Models\Penjualanm; // Menggunakan model Penjualanm
use App\Models\Barangm; // Menggunakan model Barangm

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Detailm>
 */
class DetailmFactory extends Factory
{
    // Menentukan model yang akan digunakan oleh factory ini
    protected $model = Detailm::class;

    // Method untuk mendefinisikan data dummy
    public function definition(): array
    {
        return [
            // Menghasilkan angka desimal (float) dengan 2 digit di belakang koma, dalam rentang 50.000 - 300.000
            'harga' => $this->faker->randomFloat(2, 50000, 300000),

            // Menghasilkan angka random antara 1 hingga 100 untuk jumlah barang
            'jumlah' => $this->faker->numberBetween(1, 100),

            // Mengambil `barang_id` secara acak dari tabel Barangm
            // Jika tidak ada data, maka akan membuat satu data baru menggunakan factory
            'barang_id' => Barangm::inRandomOrder()->value('barang_id') ?? Barangm::factory()->create()->barang_id,

            // Mengambil `penjualan_id` secara acak dari tabel Penjualanm
            // Jika tidak ada data, maka akan membuat satu data baru menggunakan factory
            'penjualan_id' => Penjualanm::inRandomOrder()->value('penjualan_id') ?? Penjualanm::factory()->create()->penjualan_id,
        ];
    }
}
