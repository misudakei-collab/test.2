<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 配列の値を書き換えるだけで、個別パスワードにも共通パスワードにも自由に対応できます
        $users = [
            [
                'name' => 'Admin1',
                'email' => 'mi.su.da.kei@gmail.com',
                'password' => 'password',
            ],
            [
                'name' => 'Admin2',
                'email' => 'suzumiya.kei@gmail.com',
                'password' => 'password',
            ],
            [
                'name' => 'Admin3',
                'email' => 'kaldenisq@gmail.com',
                'password' => 'password',
            ],
        ];


        foreach ($users as $userData) {
            User::updateOrCreate(
                ['email' => $userData['email']],
                [
                    'name' => $userData['name'],
                    'password' => Hash::make($userData['password']), // 
                    'email_verified_at' => now(),
                ]
            );
        }
    }
}
