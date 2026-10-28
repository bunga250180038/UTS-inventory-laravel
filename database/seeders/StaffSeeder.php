<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class StaffSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'staff@inventory.test'],
            [
                'name' => 'Staff Inventory',
                'password' => Hash::make('Staff12345!'),
                'role' => 'staff',
            ]
        );
    }
}
