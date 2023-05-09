<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

class MasterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Master Status');

        // truncate
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Status::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // get file
        $status_json = file_get_contents(database_path('seeders/data/master/statuses.json'));
        $statuses = json_decode($status_json);

        $this->command->getOutput()->progressStart(count($statuses));

        foreach ($statuses as $status) {
            // create
            Status::create([
                'uuid' => Uuid::uuid1(),
                'name' => $status->name
            ]);

            $this->command->getOutput()->progressAdvance();
        }

        $this->command->getOutput()->progressFinish();
    }
}
