<?php

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
        // $this->call(UserSeeder::class);
        $threads = factory(\App\Thread::class, 10)->create();
        $threads->each(function($thread){
            factory(\App\Reply::class, 5)->create([
                'thread_id' => $thread->id
            ]);
        });
    }
}
