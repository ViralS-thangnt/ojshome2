<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
//use DB;
use App\User;
use App\Manuscript;
use App\EditorManuscript;
use App\Journal;

use Faker\Factory as Faker;

class MiniDataManuscriptSeeder extends Seeder
{
    public function run()
    {
        DB::table('manuscripts')->truncate();
        DB::table('editor_manuscripts')->truncate();
        $faker = Faker::create();

        $author_ids         = User::where('actor_no',AUTHOR)->lists('id');
        $editor_id          = User::where('actor_no', SCREENING_EDITOR)->lists('id');
        $section_editor_id  = User::where('actor_no', SECTION_EDITOR)->lists('id');
        $copy_editor_id     = User::where('actor_no', COPY_EDITOR)->lists('id');
        $layout_editor_id   = User::where('actor_no', LAYOUT_EDITOR)->lists('id');
        $managing_editor    = User::where('actor_no', MANAGING_EDITOR)->lists('id');
        $reviewer_ids       = User::where('actor_no', REVIEWER)->lists('id');
        $journal_ids = Journal::all()->lists('id');  
        $type = [1,2,3,4,5];

        for($i = 1; $i <= 10; $i++)
        {
            $arrManuscript[] = [
                'author_id'                    => $faker->randomElement($author_ids),
                'editor_id'                    => $faker->randomElement($copy_editor_id),
                'section_editor_id'            => $faker->randomElement($section_editor_id),
                'layout_editor_id'             => $faker->randomElement($layout_editor_id),
                'author_comments'              => 'author_comments manuscript' . $i,
                'type'                         => $faker->randomElement($type),
                'expect_journal_id'            => $faker->randomElement($journal_ids),
                'publish_journal_id'           => 0,
                'pre_journal_id'               => $faker->randomElement($journal_ids),
                'name'                         => 'Manuscript '. $i,
                'summary_vi'                   => 'summary_vi ' . $i,
                'summary_en'                   => 'summary_en ' . $i,
                'topic'                        => 'topic ' . $i,
                'propose_reviewer'             => 'propose_reviewer '. $i,
                'co_author'                    => 'co_author' . $i,
                'is_chief_review'              => 1,
                'chief_decide'                 => 0,
                'is_review'                    => 1,
                'is_revise'                    => 1,
                'is_print_out'                 => 1,
                'is_pre_public'                => 1,
                'status'                       => PUBLISHED,
                ];
        }

        for($i = 11; $i <= 20; $i++)
        {
           $arrManuscript[] = [
                'author_id'                    => $faker->randomElement($author_ids),
                'editor_id'                    => $faker->randomElement($editor_id),
                'section_editor_id'            => $faker->randomElement($section_editor_id),
                'layout_editor_id'             => 0,
                'author_comments'              => 'author_comments manuscript' . $i,
                'type'                         => $faker->randomElement($type),
                'expect_journal_id'            => $faker->randomElement($journal_ids),
                'publish_journal_id'           => 0,
                'pre_journal_id'               => $faker->randomElement($journal_ids),
                'name'                         => 'Manuscript '. $i,
                'summary_vi'                   => 'summary_vi ' . $i,
                'summary_en'                   => 'summary_en ' . $i,
                'topic'                        => 'topic ' . $i,
                'propose_reviewer'             => 'propose_reviewer '. $i,
                'co_author'                    => 'co_author' . $i,
                'is_chief_review'              => 1,
                'chief_decide'                 => 0,
                'is_review'                    => 1,
                'is_revise'                    => 0,
                'is_print_out'                 => 0,
                'is_pre_public'                => 0,
                'status'                       => IN_EDITING,
                ];
        }  

        //dd($arrManuscript);      

        DB::table("manuscripts")->insert($arrManuscript);
    }
}