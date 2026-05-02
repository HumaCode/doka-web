<?php

namespace Database\Factories\Kegiatan;

use App\Models\Kegiatan\Kegiatan;
use App\Models\Master\Kategori;
use App\Models\Master\UnitKerja;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\Master\Kegiatan>
 */
class KegiatanFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Kegiatan::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $kategoriIds = Kategori::pluck('id')->toArray();
        $unitIds = UnitKerja::pluck('id')->toArray();
        $userIds = User::pluck('id')->toArray();

        $judulPrefix = [
            'Rapat Koordinasi', 'Sosialisasi Kebijakan', 'Workshop Peningkatan Kapasitas',
            'Studi Banding', 'Kunjungan Kerja', 'Pelatihan Teknis', 'Upacara Bendera',
            'Seminar Nasional', 'Webinar Internal', 'Evaluasi Kinerja', 'Bimbingan Teknis',
            'Pertemuan Rutin', 'Launching Program', 'Peresmian Gedung', 'Monitoring Lapangan',
        ];

        $lokasiList = [
            'Aula Utama Gedung A', 'Ruang Rapat Lantai 2', 'Hotel Santika', 'Kantor Gubernur',
            'Sekretariat Daerah', 'Dinas Kominfo', 'Bappeda', 'Gedung Serbaguna',
            'Ruang Media Center', 'Laboratorium Komputer', 'Lapangan Upacara', 'Hotel Aston',
        ];

        $kategori_id = $this->faker->randomElement($kategoriIds);
        $unit_id = $this->faker->optional(0.8)->randomElement($unitIds);
        $petugas_id = $this->faker->optional(0.9)->randomElement($userIds);

        return [
            'judul' => $this->faker->randomElement($judulPrefix).' '.$this->faker->sentence(3),
            'tanggal' => $this->faker->dateTimeBetween('-1 year', 'now')->format('Y-m-d'),
            'waktu' => $this->faker->optional(0.7)->time('H:i'),
            'lokasi' => $this->faker->optional(0.8)->randomElement($lokasiList),
            'kategori_id' => $kategori_id,
            'unit_id' => $unit_id,
            'uraian' => $this->faker->paragraphs(3, true),
            'jumlah_peserta' => $this->faker->optional(0.9)->numberBetween(10, 200),
            'narasumber' => $this->faker->optional(0.5)->name(),
            'status' => $this->faker->randomElement(['draft', 'berjalan', 'selesai']),
            'petugas_id' => $petugas_id,
            'tags' => $this->faker->words($this->faker->numberBetween(1, 4)),
        ];
    }
}
