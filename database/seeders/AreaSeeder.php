<?php

namespace Database\Seeders;

use App\Models\Area;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $areas = [
            ['code' => 'AR-01', 'name' => 'Kalimantan Barat'],
            ['code' => 'AR-02', 'name' => 'DKI Jakarta'],
            ['code' => 'AR-03', 'name' => 'Jawa Timur'],
            ['code' => 'AR-04', 'name' => 'Kalimantan Timur'],
            ['code' => 'AR-05', 'name' => 'Sulawesi Selatan'],
            ['code' => 'AR-06', 'name' => 'Jawa Tengah'],
            ['code' => 'AR-07', 'name' => 'Sumatera Utara'],
            ['code' => 'AR-08', 'name' => 'Sumatera Selatan'],
            ['code' => 'AR-09', 'name' => 'Bali'],
            ['code' => 'AR-10', 'name' => 'Jawa Barat'],
        ];

        Area::upsert($areas, ['code'], ['name']);
    }
}
