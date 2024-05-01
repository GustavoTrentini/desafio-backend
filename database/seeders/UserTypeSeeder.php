<?php

namespace Database\Seeders;

use App\Models\TypeUser;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TypeUser::insert([
            [
                'description' => 'Comum',
                'allow_transfers' => true
            ],
            [
                'description' => 'Lojista',
                'allow_transfers' => false
            ]
        ]);
    }
}
