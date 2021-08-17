<?php

namespace Database\Seeders;

use App\Models\Ad;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory(10)->create()->each(function ($user) {
            $user->ads()->saveMany(\App\Models\Ad::factory(100)->make([
                'user_id' => $user->id
            ]));
        });
    }
}
