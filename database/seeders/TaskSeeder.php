<?php

namespace Database\Seeders;

use App\Models\Task;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tasks = [
            [
                'title' => 'Laporan Evaluasi Penjualan Q1',
                'department_id' => 3, 
                'area_id' => 1,       
                'due_at' => date('Y-m-d', strtotime('+7 days')),
                'created_by' => 1,
                // Menggunakan fungsi date bawaan PHP untuk timestamp
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'title' => 'Laporan Audit Infrastruktur IT',
                'department_id' => 1, 
                'area_id' => 2,       
                'due_at' => date('Y-m-d', strtotime('+14 days')),
                'created_by' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        Task::insert($tasks);
    }
}
