<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Option;
use App\Models\Poll;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Poll::factory(10)
            ->create()
            ->each(function (Poll $poll) {
                $poll->options()->saveMany(
                    Option::factory(rand(3, 6))->make()
                );
            });
    }
}
