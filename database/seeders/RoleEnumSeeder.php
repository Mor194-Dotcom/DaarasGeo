<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RoleEnum;

class RoleEnumSeeder extends Seeder
{
    public function run(): void
    {
        RoleEnum::insert([
            ['libelle' => 'Tuteur'],
            ['libelle' => 'ResponsableDaara'],
            ['libelle' => 'Talibe'],
            ['libelle' => 'Administrateur'],
        ]);
    }
}
