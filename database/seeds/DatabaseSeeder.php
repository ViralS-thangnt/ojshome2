<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
//use DB;
use App\User;
use App\Manuscript;

class DatabaseSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call('UserTableSeeder');
    }
}

class UserTableSeeder extends Seeder
{
    public function run()
    {
        //Users

        //clear database
        DB::table('users')->delete();

        //Administrator
        User::create([
                'id'                =>  1,
                'username'          =>  'admin',
                'password'          =>  bcrypt('12345678'),
                'email'             =>  'quandt@naida.bz',
                'actor_no'          =>  ADMIN,
              ]);

        //Author
        User::create([
                'id'                =>  2,
                'username'          =>  'author_demo',
                'password'          =>  bcrypt('12345678'),
                'email'             =>  'author_demo@naida.bz',
                'actor_no'          =>  AUTHOR,
                'last_name'         => 'last_name',
                'first_name'        => 'first_name',
              ]);

        //Managing Editor
        User::create([
                'id'                =>  3,
                'username'          =>  'managing_editor',
                'password'          =>  bcrypt('12345678'),
                'email'             =>  'managing_editor@naida.bz',
                'actor_no'          =>  MANAGING_EDITOR,
                'last_name'         => 'last_name',
                'first_name'        => 'first_name',
              ]);

        //Screening Editor
        User::create([
                'id'                =>  4,
                'username'          =>  'screening_editor',
                'password'          =>  bcrypt('12345678'),
                'email'             =>  'screening_editor@naida.bz',
                'actor_no'          =>  SCREENING_EDITOR,
              ]);

        //Section Editor
        User::create([
                'id'                =>  5,
                'username'          =>  'section_editor',
                'password'          =>  bcrypt('12345678'),
                'email'             =>  'section_editor@naida.bz',
                'actor_no'          =>  SECTION_EDITOR,
              ]);

        //Reviewer
        User::create([
                'id'                =>  6,
                'username'          =>  'reviewer',
                'password'          =>  bcrypt('12345678'),
                'email'             =>  'reviewer@naida.bz',
                'actor_no'          =>  REVIEWER,
              ]);

      //Chief Editor
      User::create([
              'id'                =>  7,
              'username'          =>  'chief_editor',
              'password'          =>  bcrypt('12345678'),
              'email'             =>  'chief@naida.bz',
              'actor_no'          =>  CHIEF_EDITOR,
            ]);

      //Copy Editor
      User::create([
              'id'                =>  8,
              'username'          =>  'copy_editor',
              'password'          =>  bcrypt('12345678'),
              'email'             =>  'copy_editor@naida.bz',
              'actor_no'          =>  COPY_EDITOR,
            ]);

      //Layout Editor
      User::create([
              'id'                =>  9,
              'username'          =>  'layout_editor',
              'password'          =>  bcrypt('12345678'),
              'email'             =>  'layout_editor@naida.bz',
              'actor_no'          =>  LAYOUT_EDITOR,
            ]);

      //Production Editor
      User::create([
              'id'                =>  10,
              'username'          =>  'production_editor',
              'password'          =>  bcrypt('12345678'),
              'email'             =>  'production_editor@naida.bz',
              'actor_no'          =>  PRODUCTION_EDITOR,
            ]);

      //Manuscripts
      DB::table('manuscripts')->delete();

      Manuscript::create([
          'type'                  =>  A,
          'author_id'             =>  2,
          'name'                  =>  'Lorem ipsum dolor',
          'summary_vi'            =>  'sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco',
          'keyword_vi'            =>  '',
          'summary_en'            =>  'aboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur',
          'topic'                 =>  'Excepteur sint',
          'recommend'             =>  0,
          'propose_reviewer'    =>  '',
          'co_author'             =>  '',
          'file'                  =>  'author_manuscript.docx',
          'is_chief_review'       =>  0,
          'chief_decide'          =>  0,
          'is_revise'             =>  0,
          'status'                =>  UNSUBMIT,
        ]);

      Manuscript::create([
          'type'                  =>  B,
          'author_id'             =>  2,
          'name'                  =>  'Lorem ipsum dolor',
          'summary_vi'            =>  'sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco',
          'keyword_vi'            =>  '',
          'summary_en'            =>  'aboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur',
          'topic'                 =>  'Excepteur sint',
          'recommend'             =>  0,
          'propose_reviewer'    =>  '',
          'co_author'             =>  '',
          'file'                  =>  'author_manuscript.docx',
          'is_chief_review'       =>  0,
          'chief_decide'          =>  0,
          'is_revise'             =>  0,
          'status'                =>  UNSUBMIT,
        ]);

      Manuscript::create([
          'type'                  =>  C,
          'author_id'             =>  2,
          'name'                  =>  'Lorem ipsum dolor',
          'summary_vi'            =>  'sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco',
          'keyword_vi'            =>  '',
          'summary_en'            =>  'aboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur',
          'topic'                 =>  'Excepteur sint',
          'recommend'             =>  0,
          'propose_reviewer'    =>  '',
          'co_author'             =>  '',
          'file'                  =>  'author_manuscript.docx',
          'is_chief_review'       =>  0,
          'chief_decide'          =>  0,
          'is_revise'             =>  0,
          'status'                =>  UNSUBMIT,
        ]);

      Manuscript::create([
          'type'                  =>  D,
          'author_id'             =>  2,
          'name'                  =>  'Lorem ipsum dolor',
          'summary_vi'            =>  'sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco',
          'keyword_vi'            =>  '',
          'summary_en'            =>  'aboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur',
          'topic'                 =>  'Excepteur sint',
          'recommend'             =>  0,
          'propose_reviewer'    =>  '',
          'co_author'             =>  '',
          'file'                  =>  'author_manuscript.docx',
          'is_chief_review'       =>  0,
          'chief_decide'          =>  0,
          'is_revise'             =>  0,
          'status'                =>  UNSUBMIT,
        ]);

      Manuscript::create([
          'type'                  =>  E,
          'author_id'             =>  2,
          'name'                  =>  'Lorem ipsum dolor',
          'summary_vi'            =>  'sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco',
          'keyword_vi'            =>  '',
          'summary_en'            =>  'aboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur',
          'topic'                 =>  'Excepteur sint',
          'recommend'             =>  0,
          'propose_reviewer'    =>  '',
          'co_author'             =>  '',
          'file'                  =>  'author_manuscript.docx',
          'is_chief_review'       =>  0,
          'chief_decide'          =>  0,
          'is_revise'             =>  0,
          'status'                =>  UNSUBMIT,
        ]);
      
      Manuscript::create([
          'type'                  =>  A,
          'author_id'             =>  2,
          'name'                  =>  'Lorem ipsum dolor',
          'summary_vi'            =>  'sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco',
          'keyword_vi'            =>  '',
          'summary_en'            =>  'aboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur',
          'topic'                 =>  'Excepteur sint',
          'recommend'             =>  0,
          'propose_reviewer'    =>  '',
          'co_author'             =>  '',
          'file'                  =>  'author_manuscript.docx',
          'is_chief_review'       =>  0,
          'chief_decide'          =>  0,
          'is_revise'             =>  0,
          'status'                =>  UNSUBMIT,
        ]);

      Manuscript::create([
          'type'                  =>  B,
          'author_id'             =>  2,
          'name'                  =>  'Lorem ipsum dolor',
          'summary_vi'            =>  'sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco',
          'keyword_vi'            =>  '',
          'summary_en'            =>  'aboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur',
          'topic'                 =>  'Excepteur sint',
          'recommend'             =>  0,
          'propose_reviewer'    =>  '',
          'co_author'             =>  '',
          'file'                  =>  'author_manuscript.docx',
          'is_chief_review'       =>  0,
          'chief_decide'          =>  0,
          'is_revise'             =>  0,
          'status'                =>  UNSUBMIT,
        ]);

      Manuscript::create([
          'type'                  =>  C,
          'author_id'             =>  2,
          'name'                  =>  'Lorem ipsum dolor',
          'summary_vi'            =>  'sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco',
          'keyword_vi'            =>  '',
          'summary_en'            =>  'aboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur',
          'topic'                 =>  'Excepteur sint',
          'recommend'             =>  0,
          'propose_reviewer'    =>  '',
          'co_author'             =>  '',
          'file'                  =>  'author_manuscript.docx',
          'is_chief_review'       =>  0,
          'chief_decide'          =>  0,
          'is_revise'             =>  0,
          'status'                =>  UNSUBMIT,
        ]);

      Manuscript::create([
          'type'                  =>  D,
          'author_id'             =>  2,
          'name'                  =>  'Lorem ipsum dolor',
          'summary_vi'            =>  'sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco',
          'keyword_vi'            =>  '',
          'summary_en'            =>  'aboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur',
          'topic'                 =>  'Excepteur sint',
          'recommend'             =>  0,
          'propose_reviewer'    =>  '',
          'co_author'             =>  '',
          'file'                  =>  'author_manuscript.docx',
          'is_chief_review'       =>  0,
          'chief_decide'          =>  0,
          'is_revise'             =>  0,
          'status'                =>  UNSUBMIT,
        ]);
    }
}
