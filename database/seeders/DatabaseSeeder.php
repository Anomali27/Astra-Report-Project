<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'id' => 1,
            'name' => 'Supervisor Astra',
            'email' => 'supervisor@astra.com',
            'password' => bcrypt('password123'),
        ]);
        
        $this->call([
            DealerSeeder::class,
            DepartmentSeeder::class,
            AreaSeeder::class,
            TaskSeeder::class
        ]);
    }
}
