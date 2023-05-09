<?php

namespace Database\Seeders;

use App\Models\Group;
use App\Models\MemberGroup;
use App\Models\Status;
use App\Models\Todo;
use App\Models\User;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

class DummySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // truncate
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Todo::truncate();
        MemberGroup::truncate();
        Group::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $faker = Faker::create('id_ID');

        $this->command->info('Dummy User');

        $this->command->getOutput()->progressStart(100);

        foreach (range(1, 100) as $key => $value) {
            // create
            User::create([
                'uuid' => Uuid::uuid1(),
                'name' => $faker->name,
                'birthdate' => $faker->date($format = 'Y-m-d', $max = 'now'),
                'address' => $faker->address,
                'email' => $faker->safeEmail,
                'password' => bcrypt('dummy'),
            ]);

            $this->command->getOutput()->progressAdvance();
        }

        $this->command->getOutput()->progressFinish();

        $this->command->info('Dummy Group, Member Group and Todo');

        $this->command->getOutput()->progressStart(100);

        foreach (range(1, 50) as $key => $value) {
            // create group
            $group = Group::create([
                'uuid' => Uuid::uuid1(),
                'admin_id' => User::inRandomOrder()->first()->id,
                'name' => $faker->company,
                'description' => $faker->text,
            ]);

            foreach (range(1, 5) as $key => $value) {
                // create member group
                MemberGroup::create([
                    'uuid' => Uuid::uuid1(),
                    'group_id' => $group->id,
                    'user_id' => User::where('id', '!=', $group->admin_id)->inRandomOrder()->first()->id,
                ]);
            }

            foreach (range(1, 15) as $key => $value) {
                // create todo
                Todo::create([
                    'uuid' => Uuid::uuid1(),
                    'group_id' => $group->id,
                    'created_user_id' => $group->admin_id,
                    'assignee_id' => MemberGroup::where('group_id', $group->id)->inRandomOrder()->first()->user_id,
                    'status_id' => Status::inRandomOrder()->first()->id,
                    'title' => $faker->text,
                    'description' => $faker->text,
                ]);
            }

            $this->command->getOutput()->progressAdvance();
        }

        $this->command->getOutput()->progressFinish();
    }
}
