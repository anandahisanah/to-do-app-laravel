<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\User;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

class DefaultSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // truncate
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        User::truncate();
        Permission::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $this->command->info('Default Permission');

        $permissions = [
            // user
            'show user',
            'create user',
            'edit user',
            'delete user',
            // group
            'show group',
            'create group',
            'edit group',
            'delete group',
            // todo
            'show todo',
            'create todo',
            'edit todo',
            'delete todo',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        $faker = Faker::create('id_ID');

        $this->command->info('Default User');

        // create
        User::create([
            'uuid' => Uuid::uuid1(),
            'name' => 'Administrator',
            'birthdate' => now(),
            'address' => $faker->address,
            'email' => 'administrator@mail.com',
            'password' => bcrypt('administrator'),
        ]);
    }
}
