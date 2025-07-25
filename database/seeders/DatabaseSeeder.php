<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            AdminSeeder::class,
            UserSeeder::class,
            PembudidayaSeeder::class,
            DokumenPembudidayaSeeder::class,
            ProdukSeeder::class,
        ]);
    }
}
