<?php

namespace Database\Seeders;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'teste',
            'email' => 'teste@maiscode.com.br',
            'email_verified_at' => now(),
            'password' => bcrypt('123456789'),
            'remember_token' => Str::random(10),
        ])->roles()->sync(1);

        User::create([
            'name' => 'cliente1',
            'email' => 'cliente1@maiscode.com.br',
            'email_verified_at' => now(),
            'password' => bcrypt('123456789'),
            'remember_token' => Str::random(10),
        ])->roles()->attach(2);
        User::create([
            'name' => 'cliente2',
            'email' => 'cliente2@maiscode.com.br',
            'email_verified_at' => now(),
            'password' => bcrypt('123456789'),
            'remember_token' => Str::random(10),
        ])->roles()->attach(2);
        User::create([
            'name' => 'cliente3',
            'email' => 'cliente3@maiscode.com.br',
            'email_verified_at' => now(),
            'password' => bcrypt('123456789'),
            'remember_token' => Str::random(10),
        ])->roles()->attach(2);

        User::create([
            'name' => 'corretor1',
            'email' => 'corretor1@maiscode.com.br',
            'email_verified_at' => now(),
            'password' => bcrypt('123456789'),
            'remember_token' => Str::random(10),
        ])->roles()->attach(3);
        User::create([
            'name' => 'corretor2',
            'email' => 'corretor2@maiscode.com.br',
            'email_verified_at' => now(),
            'password' => bcrypt('123456789'),
            'remember_token' => Str::random(10),
        ])->roles()->attach(3);
        User::create([
            'name' => 'corretor3',
            'email' => 'corretor3@maiscode.com.br',
            'email_verified_at' => now(),
            'password' => bcrypt('123456789'),
            'remember_token' => Str::random(10),
        ])->roles()->attach(3);
        
        User::create([
            'name' => 'construtora1',
            'email' => 'construtora1@maiscode.com.br',
            'email_verified_at' => now(),
            'password' => bcrypt('123456789'),
            'remember_token' => Str::random(10),
        ])->roles()->attach(4);
        User::create([
            'name' => 'construtora2',
            'email' => 'construtora2@maiscode.com.br',
            'email_verified_at' => now(),
            'password' => bcrypt('123456789'),
            'remember_token' => Str::random(10),
        ])->roles()->attach(4);
        User::create([
            'name' => 'construtora3',
            'email' => 'construtora3@maiscode.com.br',
            'email_verified_at' => now(),
            'password' => bcrypt('123456789'),
            'remember_token' => Str::random(10),
        ])->roles()->attach(4);
        
        User::create([
            'name' => 'gestor1',
            'email' => 'gestor1@maiscode.com.br',
            'email_verified_at' => now(),
            'password' => bcrypt('123456789'),
            'remember_token' => Str::random(10),
        ])->roles()->attach(5);
        User::create([
            'name' => 'gestor2',
            'email' => 'gestor2@maiscode.com.br',
            'email_verified_at' => now(),
            'password' => bcrypt('123456789'),
            'remember_token' => Str::random(10),
        ])->roles()->attach(5);
        User::create([
            'name' => 'gestor3',
            'email' => 'gestor3@maiscode.com.br',
            'email_verified_at' => now(),
            'password' => bcrypt('123456789'),
            'remember_token' => Str::random(10),
        ])->roles()->attach(5);
    }
}
