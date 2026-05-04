<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Trainer;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder {
    public function run(): void {
        $admin = User::create([
            'name' => 'Admin User', 'email' => 'admin@fit.com',
            'password' => Hash::make('admin123'), 'role' => 'admin',
        ]);

        $t1 = User::create([
            'name' => 'John Trainer', 'email' => 'john@fit.com',
            'password' => Hash::make('pass'), 'role' => 'trainer',
        ]);
        Trainer::create(['user_id' => $t1->id, 'specialty' => 'Strength']);

        User::create([
            'name' => 'Alex Client', 'email' => 'alex@fit.com',
            'password' => Hash::make('pass'), 'role' => 'client',
        ]);
    }
}