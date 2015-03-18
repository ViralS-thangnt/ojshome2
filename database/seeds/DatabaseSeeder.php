<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
//use DB;
use App\User;
use App\Manuscript;
use App\EditorManuscript;

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
                'email'             =>  'admin@nadia.bz',
                'degree_id'         =>  1,
                'actor_no'          =>  ADMIN,
              ]);

        //Author
        User::create([
                'id'                =>  2,
                'username'          =>  'author_demo',
                'password'          =>  bcrypt('12345678'),
                'email'             =>  'author_demo@nadia.bz',
                'actor_no'          =>  AUTHOR,
                'degree_id'         =>  1,
                'last_name'         => 'last_name',
                'first_name'        => 'first_name',
              ]);

        //Managing Editor
        User::create([
                'id'                =>  3,
                'username'          =>  'managing_editor',
                'password'          =>  bcrypt('12345678'),
                'email'             =>  'managing_editor@nadia.bz',
                'actor_no'          =>  MANAGING_EDITOR,
                'degree_id'         =>  1,
                'last_name'         => 'last_name',
                'first_name'        => 'first_name',
              ]);

        //Screening Editor
        User::create([
                'id'                =>  4,
                'username'          =>  'screening_editor',
                'password'          =>  bcrypt('12345678'),
                'email'             =>  'screening_editor@nadia.bz',
                'actor_no'          =>  SCREENING_EDITOR,
                'degree_id'         =>  1,
              ]);

        //Section Editor
        User::create([
                'id'                =>  5,
                'username'          =>  'section_editor',
                'password'          =>  bcrypt('12345678'),
                'email'             =>  'section_editor@nadia.bz',
                'actor_no'          =>  SECTION_EDITOR,
                'degree_id'         =>  1,
              ]);

        //Reviewer
        User::create([
                'id'                =>  6,
                'username'          =>  'reviewer',
                'password'          =>  bcrypt('12345678'),
                'email'             =>  'reviewer@nadia.bz',
                'actor_no'          =>  REVIEWER,
                'degree_id'         =>  1,
              ]);

      //Chief Editor
      User::create([
              'id'                =>  7,
              'username'          =>  'chief_editor',
              'password'          =>  bcrypt('12345678'),
              'email'             =>  'chief@nadia.bz',
              'actor_no'          =>  CHIEF_EDITOR,
              'degree_id'         =>  1,
            ]);

      //Copy Editor
      User::create([
              'id'                =>  8,
              'username'          =>  'copy_editor',
              'password'          =>  bcrypt('12345678'),
              'email'             =>  'copy_editor@nadia.bz',
              'actor_no'          =>  COPY_EDITOR,
              'degree_id'         =>  1,
            ]);

      //Layout Editor
      User::create([
              'id'                =>  9,
              'username'          =>  'layout_editor',
              'password'          =>  bcrypt('12345678'),
              'email'             =>  'layout_editor@nadia.bz',
              'actor_no'          =>  LAYOUT_EDITOR,
              'degree_id'         =>  1,
            ]);

      //Production Editor
      User::create([
              'id'                =>  10,
              'username'          =>  'production_editor',
              'password'          =>  bcrypt('12345678'),
              'email'             =>  'production_editor@nadia.bz',
              'actor_no'          =>  PRODUCTION_EDITOR,
              'degree_id'         =>  1,
            ]);

      //Manuscripts
      DB::table('manuscripts')->delete();

      Manuscript::create([
          'id'                    =>  1,
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
          'id'                    =>  2,
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
          'id'                    =>  3,
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
          'id'                    =>  4,
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
          'id'                    =>  5,
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
          'id'                    =>  6,
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
          'id'                    =>  7,
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
          'id'                    =>  8,
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
          'id'                    =>  9,
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
          'id'                    =>  10,
          'type'                  =>  A,
          'author_id'             =>  2,
          'name'                  =>  'Lorem ipsum dolor',
          'summary_vi'            =>  'sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco',
          'keyword_vi'            =>  '',
          'summary_en'            =>  'aboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur',
          'topic'                 =>  'Excepteur sint',
          'recommend'             =>  0,
          'propose_reviewer'      =>  '',
          'co_author'             =>  '',
          'file'                  =>  'author_manuscript.docx',
          'is_chief_review'       =>  0,
          'chief_decide'          =>  0,
          'is_revise'             =>  0,
          'status'                =>  IN_SCREENING,
        ]);
      
      Manuscript::create([
          'id'                    =>  11,
          'type'                  =>  A,
          'author_id'             =>  2,
          'name'                  =>  'Lorem ipsum dolor',
          'summary_vi'            =>  'sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco',
          'keyword_vi'            =>  '',
          'summary_en'            =>  'aboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur',
          'topic'                 =>  'Excepteur sint',
          'recommend'             =>  0,
          'propose_reviewer'      =>  '',
          'co_author'             =>  '',
          'file'                  =>  'author_manuscript.docx',
          'is_chief_review'       =>  0,
          'chief_decide'          =>  0,
          'is_revise'             =>  0,
          'status'                =>  IN_SCREENING,
        ]);
      
      Manuscript::create([
          'id'                    =>  12,
          'type'                  =>  A,
          'author_id'             =>  2,
          'name'                  =>  'Lorem ipsum dolor',
          'summary_vi'            =>  'sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco',
          'keyword_vi'            =>  '',
          'summary_en'            =>  'aboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur',
          'topic'                 =>  'Excepteur sint',
          'recommend'             =>  0,
          'propose_reviewer'      =>  '',
          'co_author'             =>  '',
          'file'                  =>  'author_manuscript.docx',
          'is_chief_review'       =>  0,
          'chief_decide'          =>  0,
          'is_revise'             =>  0,
          'status'                =>  IN_SCREENING,
        ]);

      //Editor manuscripts
      DB::table('editor_manuscripts')->delete();

      EditorManuscript::create([
          'manuscript_id'         => 10,
          'user_id'               => 4,
          'loop'                  => 1,
          'comments'              => 'consectetur adipiscing elit, sed do eiusmod tempor incididunt',
        ]);

      EditorManuscript::create([
          'manuscript_id'         => 10,
          'user_id'               => 4,
          'loop'                  => 2,
          'comments'              => 'consectetur adipiscing elit, sed do eiusmod tempor incididunt',
        ]);

      EditorManuscript::create([
          'manuscript_id'         => 10,
          'user_id'               => 4,
          'loop'                  => 3,
          'comments'              => 'consectetur adipiscing elit, sed do eiusmod tempor incididunt',
        ]);

       EditorManuscript::create([
          'manuscript_id'         => 11,
          'user_id'               => 4,
          'loop'                  => 1,
          'comments'              => 'consectetur adipiscing elit, sed do eiusmod tempor incididunt',
        ]);

      EditorManuscript::create([
          'manuscript_id'         => 11,
          'user_id'               => 4,
          'loop'                  => 2,
          'comments'              => 'consectetur adipiscing elit, sed do eiusmod tempor incididunt',
        ]);

      EditorManuscript::create([
          'manuscript_id'         => 11,
          'user_id'               => 4,
          'loop'                  => 3,
          'comments'              => 'consectetur adipiscing elit, sed do eiusmod tempor incididunt',
        ]);
      
      EditorManuscript::create([
          'manuscript_id'         => 12,
          'user_id'               => 4,
          'loop'                  => 1,
          'comments'              => 'consectetur adipiscing elit, sed do eiusmod tempor incididunt',
        ]);

      EditorManuscript::create([
          'manuscript_id'         => 12,
          'user_id'               => 4,
          'loop'                  => 2,
          'comments'              => 'consectetur adipiscing elit, sed do eiusmod tempor incididunt',
        ]);

      EditorManuscript::create([
          'manuscript_id'         => 12,
          'user_id'               => 4,
          'loop'                  => 3,
          'comments'              => 'consectetur adipiscing elit, sed do eiusmod tempor incididunt',
        ]);

    }
}
