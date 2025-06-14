<?php

namespace Database\Seeders;

use App\Models\Pembudidaya;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PembudidayaSeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 1; $i <= 10; $i++) {
            Pembudidaya::create([
                'name' => "Pembudidaya $i",
                'email' => "pembudidaya$i@example.com",
                'password' => Hash::make('password'),
            ]);
        }
    }
}
