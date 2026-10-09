<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departments = [
            ['code' => 'DPT-01', 'name' => 'IT & System'],
            ['code' => 'DPT-02', 'name' => 'Human Resources (HRD)'],
            ['code' => 'DPT-03', 'name' => 'Sales & Marketing'],
            ['code' => 'DPT-04', 'name' => 'Technical Service'],
            ['code' => 'DPT-05', 'name' => 'Finance & Accounting'],
            ['code' => 'DPT-06', 'name' => 'Customer Service'],
            ['code' => 'DPT-07', 'name' => 'Operations'],
            ['code' => 'DPT-08', 'name' => 'Quality Control'],
            ['code' => 'DPT-09', 'name' => 'Logistics & Supply Chain'],
            ['code' => 'DPT-10', 'name' => 'Research & Development'],
        ];

        Department::upsert($departments, ['code'], ['name']);
    }
}
