<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            [ 'email' => 'supervisor.001@gmail.com'],
            [
                'name' => 'Supervisor-1',
                'password' => 'supervisor',
                'role' => 'supervisor'
            ]
        );

        User::updateOrCreate(
            [ 'email' => 'dealer@gmail.com'],
            [
                'name' => 'Dealer-Pontianak',
                'password' => 'password',
                'role' => 'dealer'
            ]
        );
    }
}
