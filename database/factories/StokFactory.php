<?php

namespace Database\Factories; // Namespace untuk Factory di Laravel

use App\Models\Stok; // Import model Stok
use App\Models\Userm; // Import model Userm
use App\Models\Barangm; // Import model Barangm
use Illuminate\Database\Eloquent\Factories\Factory; // Import Factory bawaan Laravel

class StokFactory extends Factory
{
    // Menentukan model yang akan digunakan oleh factory ini
    protected $model = Stok::class;

    // Fungsi untuk mendefinisikan data dummy yang akan dibuat
    public function definition()
    {
        return [
            // Menghasilkan tanggal stok secara acak
            'stok_tanggal' => $this->faker->date(),

            // Menghasilkan jumlah stok secara acak antara 1 hingga 100
            'stok_jumlah' => $this->faker->numberBetween(1, 100),

            // Mengambil barang_id secara acak dari tabel Barangm
            // Jika tidak ada data, maka buat data baru dan ambil barang_id-nya
            'barang_id' => Barangm::inRandomOrder()->value('barang_id') ?? Barangm::factory()->create()->barang_id,

            // Mengambil user_id secara acak dari tabel Userm
            // Jika tidak ada data, maka buat data baru dan ambil user_id-nya
            'user_id' => Userm::inRandomOrder()->value('user_id') ?? Userm::factory()->create()->user_id,
        ];
    }
}
