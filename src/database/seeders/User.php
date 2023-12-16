<?php

namespace Database\Seeders;

use App\Models\User as ModelsUser;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class User extends Seeder
{
    /**
     * Run user seed.
     *
     * @return void
     */
    public function run()
    {
        ModelsUser::create([
            'name'     => 'Developer',
            'email'    => 'dev@laravel.com',
            'password' => Hash::make('laravel')
        ]);
    }
}
