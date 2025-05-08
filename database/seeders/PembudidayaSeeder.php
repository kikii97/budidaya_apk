<?php

namespace Database\Seeders;

use App\Models\Pembudidaya;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PembudidayaSeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 1; $i <= 5; $i++) {
            Pembudidaya::create([
                'name' => "Pembudidaya $i",
                'email' => "pembudidaya$i@example.com",
                'password' => Hash::make('password'),
                'address' => "Alamat Pembudidaya $i",
                'documents' => json_encode(['KTP', 'Surat Izin']),
                'is_approved' => rand(0, 1),
            ]);
        }
    }
}
