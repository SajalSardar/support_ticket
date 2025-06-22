<?php

namespace Database\Seeders;

use App\Models\Module;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $iterator = json_decode(file_get_contents(database_path('backups/modules.json')))[2]->data;
        foreach ($iterator as $item) {
            Module::insert((array) $item);
        }
    }
}
