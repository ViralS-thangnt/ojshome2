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
        //$this->call('DataManuscriptSeeder');
        //$this->call('JournalSeeder');
        
    }
}

class UserTableSeeder extends Seeder
{
    public function run()
    {
        //Users

        //clear database
        DB::table('users')->truncate();


        $actors = [
            ADMIN                   => ['Administrator', 'admin'],
            AUTHOR                  => ['Author', 'author'],
            MANAGING_EDITOR         => ['ManagingEditor', 'managing_editor'],
            SCREENING_EDITOR        => ['ScreeningEditor', 'screening_editor'],
            SECTION_EDITOR          => ['SectionEditor', 'section_editor'],
            REVIEWER                => ['Reviewer', 'reviewer'],
            CHIEF_EDITOR            => ['ChiefEditor','chief'],
            COPY_EDITOR             => ['CopyEditor','copy_editor'],
            LAYOUT_EDITOR           => ['LayoutEditor', 'layout_editor'],
            PRODUCTION_EDITOR       => ['ProductionEditor', 'production_editor']
        ];
        // Create Author
        $arrUser = [];
        foreach ($actors as $key => $value) {       
            if ($key==ADMIN || $key==MANAGING_EDITOR ){
                $arrUser[] = [
                    'degree_id' => 1,
                    'academic_id' => 1,
                    'username' => $value[0],
                    'password' => bcrypt('12345678'),
                    'last_name' => 'First',
                    'first_name' => 'Last', 
                    'middle_name' => 'mid',
                    'sex' => 1, 
                    'year' => '1987',
                    'email' => $value[1] . '@nadia.bz',
                    'nation' => 'VN',
                    'research_area' => 'IT',
                    'research' => 'php',
                    'actor_no' => $key
                ];
            }else{
                for ($i=1; $i <= 5; $i++) { 
                    $arrUser[] = [
                        'degree_id' => 1,
                        'academic_id' => 1,
                        'username' => $value[0] . $i,
                        'password' => bcrypt('12345678'),
                        'last_name' => 'First '.$i,
                        'first_name' => 'Last', 
                        'middle_name' => 'mid',
                        'sex' => 1, 
                        'year' => '1987',
                        'email' => $value[1] . $i . '@nadia.bz',
                        'nation' => 'VN',
                        'research_area' => 'IT',
                        'research' => 'php',
                        'actor_no' => $key
                    ];
                }
            }      
        }
        DB::table("users")->insert($arrUser);
    }
}
