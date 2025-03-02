<?php

namespace Database\Factories;

use App\Models\Penjualanm; // Menggunakan model Penjualanm
use App\Models\Userm; // Menggunakan model Userm
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Factory untuk model Penjualanm
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Penjualanm>
 */
class PenjualanmFactory extends Factory
{
    // Menentukan model yang digunakan oleh factory ini
    protected $model = Penjualanm::class;

    /**
     * Mendefinisikan data dummy untuk tabel penjualanm
     */
    public function definition(): array
    {
        return [
            // Menghasilkan nama pembeli secara acak
            'pembeli' => $this->faker->name(),

            // Menghasilkan kode penjualan dengan format 'PNJ-xxxxx' (huruf acak)
            'penjualan_kode' => $this->faker->lexify('PNJ-?????'),

            // Menghasilkan tanggal penjualan secara acak
            'penjualan_tanggal' => $this->faker->date(),

            // Mengambil user_id secara acak dari database, jika tidak ada, buat user baru
            'user_id' => Userm::inRandomOrder()->value('user_id') ?? Userm::factory()->create()->user_id,
        ];
    }
}
