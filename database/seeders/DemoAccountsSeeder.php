<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DemoAccountsSeeder extends Seeder
{
    public function run(): void
    {
        $accounts = [
            [
                'name' => 'Administrator',
                'email' => 'admin@inventory.test',
                'password' => 'Admin123!',
                'role' => 'admin',
            ],
            [
                'name' => 'Staff Inventory',
                'email' => 'staff@inventory.test',
                'password' => 'Staff123!',
                'role' => 'staff',
            ],
            [
                'name' => 'Pembeli Demo',
                'email' => 'pembeli1@example.com',
                'password' => 'Buyer123!',
                'role' => 'buyer',
            ],
        ];

        foreach ($accounts as $account) {
            $user = User::firstOrNew([
                'email' => $account['email'],
            ]);

            $user->name = $account['name'];
            $user->password = Hash::make($account['password']);
            $user->role = $account['role'];
            $user->save();
        }

        $this->command->info('Akun demo berhasil disiapkan.');
    }
}