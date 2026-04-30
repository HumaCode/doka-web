<?php

namespace Database\Factories\Master;

use App\Models\Master\UnitKerja;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<UnitKerja>
 */
class UnitKerjaFactory extends Factory
{
    protected $model = UnitKerja::class;

    public function definition(): array
    {
        $fakerIndo = \Faker\Factory::create('id_ID');

        $opds = [
            ['Dinas Komunikasi dan Informatika', 'Diskominfo', 'Dinas', 'bi-cpu-fill'],
            ['Dinas Pendidikan dan Kebudayaan', 'Disdikbud', 'Dinas', 'bi-journal-bookmark-fill'],
            ['Dinas Kesehatan', 'Dinkes', 'Dinas', 'bi-hospital-fill'],
            ['Dinas Sosial', 'Dinsos', 'Dinas', 'bi-heart-fill'],
            ['Dinas Pekerjaan Umum dan Penataan Ruang', 'DPUPR', 'Dinas', 'bi-building-gear'],
            ['Dinas Lingkungan Hidup', 'DLH', 'Dinas', 'bi-tree-fill'],
            ['Dinas Perhubungan', 'Dishub', 'Dinas', 'bi-bus-front-fill'],
            ['Dinas Pariwisata', 'Dispar', 'Dinas', 'bi-trophy-fill'],
            ['Badan Perencanaan Pembangunan Daerah', 'Bappeda', 'Badan', 'bi-graph-up-arrow'],
            ['Badan Kepegawaian dan Pengembangan SDM', 'BKPSDM', 'Badan', 'bi-people-fill'],
            ['Inspektorat Daerah', 'Inspektorat', 'Inspektorat', 'bi-shield-fill'],
            ['Sekretariat Daerah', 'Setda', 'Sekretariat', 'bi-building-lock'],
            ['Sekretariat DPRD', 'Setwan', 'Sekretariat', 'bi-journal-text'],
            ['RSUD Kota Pekalongan', 'RSUD', 'RSUD', 'bi-hospital-fill'],
            ['Satuan Polisi Pamong Praja', 'Satpol PP', 'Kantor', 'bi-shield-check-fill'],
            ['Bagian Hubungan Masyarakat', 'Humas', 'Bagian', 'bi-megaphone-fill'],
            ['Bagian Hukum', 'Hukum', 'Bagian', 'bi-briefcase-fill'],
            ['Bagian Organisasi', 'Organisasi', 'Bagian', 'bi-gear-fill'],
            ['Dinas Koperasi dan UMKM', 'Diskop', 'Dinas', 'bi-cash-coin'],
            ['Dinas Perindustrian dan Tenaga Kerja', 'Dinperinaker', 'Dinas', 'bi-tools'],
        ];

        $opd = $fakerIndo->randomElement($opds);
        $gelarDepan = ['Drs.', 'Ir.', 'H.', 'Hj.', 'dr.', 'drg.'];
        $gelarBelakang = ['S.Kom.', 'S.E.', 'M.M.', 'M.T.', 'M.Si.', 'M.Pd.', 'S.H.', 'M.H.', 'S.Sos.'];

        $namaKepala = $fakerIndo->randomElement($gelarDepan) . ' ' . $fakerIndo->name() . ', ' . $fakerIndo->randomElement($gelarBelakang);

        return [
            'id' => (string) Str::ulid(),
            'nama_instansi' => $opd[0],
            'singkatan' => $opd[1],
            'jenis_opd' => $opd[2],
            'nama_kepala' => $namaKepala,
            'telp' => $fakerIndo->phoneNumber(),
            'email' => strtolower($opd[1]) . '@pekalongan.go.id',
            'website' => 'https://' . strtolower($opd[1]) . '.pekalongan.go.id',
            'alamat' => $fakerIndo->address(),
            'deskripsi' => 'Melaksanakan urusan pemerintahan di bidang ' . strtolower($opd[0]) . ' sesuai dengan peraturan perundang-undangan.',
            'icon' => $opd[3],
            'warna' => $fakerIndo->numberBetween(0, 15),
            'status' => 'active',
        ];
    }
}
