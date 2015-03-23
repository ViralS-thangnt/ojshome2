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

        $actors = $actor            = [
            ADMIN                   => 'Administrator',
            AUTHOR                  => 'Author',
            MANAGING_EDITOR         => 'ManagingEditor',
            SCREENING_EDITOR        => 'ScreeningEditor',
            SECTION_EDITOR          => 'SectionEditor',
            REVIEWER                => 'Reviewer',
            CHIEF_EDITOR            => 'ChiefEditor',
            COPY_EDITOR             => 'CopyEditor',
            LAYOUT_EDITOR           => 'LayoutEditor',
            PRODUCTION_EDITOR       => 'ProductionEditor',
        ];
        $emails = [
          ADMIN => 'admin@nadia.bz',
          AUTHOR => 'author_demo@nadia.bz',
          MANAGING_EDITOR => 'managing_editor@nadia.bz',
          SCREENING_EDITOR => 'screening_editor@nadia.bz',
          SECTION_EDITOR => 'section_editor@nadia.bz',
          REVIEWER => 'reviewer@nadia.bz',
          CHIEF_EDITOR => 'chief@nadia.bz',
          COPY_EDITOR => 'copy_editor@nadia.bz',
          LAYOUT_EDITOR => 'layout_editor@nadia.bz',
          PRODUCTION_EDITOR => 'production_editor@nadia.bz',
        ];
        $last_name = ['Quan', 'Tao', 'Lan', 'Thang', 'Tuan'];
        $middle_name = ['Thanh', 'Truong', 'Ngoc', 'Toan', 'Thi'];
        $first_name = ['Do', 'Dam','Le', 'Pham', 'Nguyen'];

        $id = 1;
        foreach ($actors as $actor_key => $actor_val) {
          User::create([
                'id'                =>  $id,
                'username'          =>  $actor_val,
                'first_name'        =>  $first_name[array_rand($first_name)],
                'middle_name'       =>  $middle_name[array_rand($middle_name)],
                'last_name'         =>  $last_name[array_rand($last_name)],
                'password'          =>  bcrypt('12345678'),
                'email'             =>  $emails[$actor_key],
                'degree_id'         =>  1,
                'actor_no'          =>  $actor_key,
              ]);
          $id++;
        }

      //Manuscripts
      DB::table('manuscripts')->delete();
      //Editor manuscripts
      DB::table('editor_manuscripts')->delete();

      $mns_type = [A,B,C,D,E];
      $loops = [1,2,3];

      //unsubmit manuscript
      for($i = 1; $i <= 10; $i++) {
          Manuscript::create([
            'id'                    =>  $i,
            'type'                  =>  $mns_type[array_rand($mns_type)],
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

      $j = 1;
      //inscreening manuscirpt
      for($i = 11; $i <= 20; $i++) {
          Manuscript::create([
            'id'                    =>  $i,
            'current_editor_manuscript_id' => $j+count($loops)-1,
            'type'                  =>  $mns_type[array_rand($mns_type)],
            'author_id'             =>  2,
            'editor_id'             =>  4,
            'section_editor_id'     =>  5,
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
            'status'                =>  IN_SCREENING,
          ]);
        
        foreach($loops as $loop){
              EditorManuscript::create([
                'id'                    => $j,
                'manuscript_id'         => $i,
                'stage'                 => SCREENING,
                'user_id'               => 4,
                'loop'                  => $loop,
                'comments'              => 'consectetur adipiscing elit, sed do eiusmod tempor incididunt',
              ]);
              $j++;
        }
      }

      //inediting manuscript
      for ($i = 21; $i <= 30; $i++) {
          Manuscript::create([
            'id'                    =>  $i,
            'current_editor_manuscript_id' => $j+count($loops)-1,
            'type'                  =>  $mns_type[array_rand($mns_type)],
            'author_id'             =>  2,
            'editor_id'             =>  8,
            'section_editor_id'     =>  5,
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
            'status'                =>  IN_EDITING,
          ]);

        foreach($loops as $loop){
              EditorManuscript::create([
                'id'                    => $j,
                'manuscript_id'         => $i,
                'stage'                 => EDITING,
                'user_id'               => 4,
                'loop'                  => $loop,
                'comments'              => 'consectetur adipiscing elit, sed do eiusmod tempor incididunt',
              ]);
              $j++;
        }
      }
    }
}
