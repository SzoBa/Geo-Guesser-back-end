<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $files = ['1geo_junkies_cities.sql', '2maps.sql', '3map-city inserts.sql'];
        $path = 'database/data_dump/';
        foreach ($files as $file) {
            DB::beginTransaction();
            try {
                DB::unprepared(file_get_contents($path . $file));
                DB::commit();
                $this->command->info(explode('.', $file)[0] . ' - table seeded!');
            } catch (\Exception $e) {
                DB::rollBack();
                $this->command->error(explode('.', $file)[0] . ' - Failed to seed!');
//                $this->command->error($e->getMessage());
            }
        }
    }
}
