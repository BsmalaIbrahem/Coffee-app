<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'name' => 'super admin',
            'email' => "admin@cuppa.com",
            'password' => Hash::make('12345678'),
        ]);  
        
        $user->assignRole('super_admin');
    }
}
