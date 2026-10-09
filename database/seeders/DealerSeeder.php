<?php

namespace Database\Seeders;

use App\Models\Dealer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DealerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dealers = [
            ['code' => '0001', 'name' => 'Astra Motor Pontianak'],
            ['code' => '0002', 'name' => 'Astra Motor Jakarta Pusat'],
            ['code' => '0003', 'name' => 'Astra Motor Surabaya'],
            ['code' => '0004', 'name' => 'Astra Motor Balikpapan'],
            ['code' => '0005', 'name' => 'Astra Motor Makassar'],
            ['code' => '0006', 'name' => 'Astra Motor Semarang'],
            ['code' => '0007', 'name' => 'Astra Motor Medan'],
            ['code' => '0008', 'name' => 'Astra Motor Palembang'],
            ['code' => '0009', 'name' => 'Astra Motor Denpasar'],
            ['code' => '0010', 'name' => 'Astra Motor Bandung'],
        ];

        Dealer::upsert($dealers, ['code'], ['name']);
    }
}
