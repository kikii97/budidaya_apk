<?php

namespace Database\Seeders;

use App\Models\DokumenPembudidaya;
use App\Models\Pembudidaya;
use Illuminate\Database\Seeder;

class DokumenPembudidayaSeeder extends Seeder
{
    public function run(): void
    {
        $statusList = ['menunggu', 'disetujui', 'ditolak'];
        
        // Ambil semua pembudidaya
        $pembudidayas = Pembudidaya::all();

        foreach ($pembudidayas as $pembudidaya) {
            DokumenPembudidaya::create([
                'pembudidaya_id' => $pembudidaya->id,
                'surat_usaha_path' => 'dokumen/surat_usaha_dummy.pdf',
                'foto_usaha_path' => 'dokumen/foto_usaha_dummy.jpg',
                'status' => $statusList[array_rand($statusList)],
                'keterangan' => 'Keterangan tambahan contoh',
                'catatan' => 'Catatan admin contoh',
            ]);
        }
    }
}
