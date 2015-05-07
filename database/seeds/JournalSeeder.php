<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
//use DB;
use App\Journal;
use Faker\Factory as Faker;

class JournalSeeder extends Seeder
{
    public function run()
    {
        Journal::truncate();

        $faker = Faker::create();
        $arrJournal = [];
        $cover = ['test1.jpg', 'test2.jpg', 'test3.jpg', 'test4.jpg', 'test5.jpg'];
        $publish_at = ['2015-03-26', '2015-04-27', '2015-04-16', '2015-04-20', '2015-04-26'];
        for($i=1; $i <= 30; $i++)
        {
            $arrJournal[] = [
                'name' => 'Journal '. $i,
                'num' => $i,
                'cover' => $faker->randomElement($cover),
                'expect_publish_at' => $faker->randomElement($publish_at),
            ];
        }

        DB::table("journals")->insert($arrJournal);
    }
}
