<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
//use DB;
use App\User;
use App\Manuscript;
use App\EditorManuscript;
use App\Journal;

use Faker\Factory as Faker;

class DataManuscriptSeeder extends Seeder
{

    
    public function run()
    {
        DB::table('manuscripts')->truncate();
        DB::table('editor_manuscripts')->truncate();
        $faker = Faker::create();

        $author_ids         = User::where('actor_no',AUTHOR)->lists('id');
        $editor_id          = User::where('actor_no', SCREENING_EDITOR)->lists('id');
        $section_editor_id  = User::where('actor_no', SECTION_EDITOR)->lists('id');
        $layout_editor_id   = User::where('actor_no', LAYOUT_EDITOR)->lists('id');
        $managing_editor    = User::where('actor_no', MANAGING_EDITOR)->lists('id');
        $reviewer_ids       = User::where('actor_no', REVIEWER)->lists('id');
        $editor_review      = User::whereIN('actor_no',[MANAGING_EDITOR, SCREENING_EDITOR, SECTION_EDITOR, CHIEF_EDITOR, COPY_EDITOR, LAYOUT_EDITOR, PRODUCTION_EDITOR])->lists('id');

        //$author_ids = User::where('actor_no',AUTHOR)->lists('id');
        $journal_ids = Journal::all()->lists('id');
        
        $type = [1,2,3,4,5];

        //1.create new Manuscript 

        $arrManuscript = [];
        $trueOrFail = [0,1];
        $status = [ UNSUBMIT, IN_SCREENING, IN_REVIEW, IN_EDITING, REJECTED, WITHDRAWN, PUBLISHED, 
        REVIEWED, WAIT_REVIEW, REJECTED_REVIEW ];
        $send_at = ['2015-03-26', '2015-03-27', '2015-03-28', '2015-03-29', '2015-03-30'];
        $chief_decide = [NULL, ACCEPT, REJECT, NEED_EDIT_AGAIN, RE_REVIEW];
        for($i = 1; $i <= 250; $i++)
        {
            $arrManuscript[] = [
                'author_id'                    => $faker->randomElement($author_ids),
                'editor_id'                    => '',
                'section_editor_id'            => '',
                'layout_editor_id'             => '',
                'author_comments'              => 'author_comments manuscript' . $i,
                'type'                         => $faker->randomElement($type),
                'expect_journal_id'            => $faker->randomElement($journal_ids),
                'publish_journal_id'           => '',
                'pre_journal_id'               => '',
                'name'                         => 'Manuscript '. $i,
                'summary_vi'                   => 'summary_vi ' . $i,
                'summary_en'                   => 'summary_en ' . $i,
                'topic'                        => 'topic ' . $i,
                'propose_reviewer'             => 'propose_reviewer '. $i,
                'co_author'                    => 'co_author' . $i,
                'is_chief_review'              => 0,
                'chief_decide'                 => 0,
                'is_review'                    => 0,
                'is_revise'                    => 0,
                'is_print_out'                 => 0,
                'is_pre_public'                => 0,
                'status'                       => UNSUBMIT,
                'send_at'                      => '',
                ];
        }
        DB::table("manuscripts")->insert($arrManuscript);
        //2. Tac gia gui ban thao vao vong so loai

        for($i=10; $i<=250; $i++)
        {
            $manuscript = Manuscript::find($i);
            $manuscript->status = IN_SCREENING;
            $manuscript->save();
        }
        
        //2.1 tac gia rut nop ban thao
        for($i=10; $i<=15; $i++)
        {
            $manuscript = Manuscript::find($i);
            $manuscript->status = WITHDRAWN;
            $manuscript->save();
        }
        
        //3. thu ky toan soan lua chon bien tap vien so loai    
        for($i=45; $i<=250; $i++)
        {
            $tmp = $faker->randomElement($editor_id);
            if ($tmp == 2 && ($i==26 || $i==50)){
                //3.1 Bien tap vien so loai tu choi ban thao.
                // Trang thai ban thao REJECTED
                // tao moi EditorManuscript
                $stage  = SCREENING;
                $status = REJECTED;
                $loop   = 1;
                
            }else{             
                //3.2 bien tap vien so loai chap nhan
                // 
                // tao moi EditorManuscript ///////
                // stage            = SCREENING
                // manuscript_id    = $i
                // user_id          = $tmp = $faker->randomElement($editor_id);
                // loop             = 1
                // delivery_at      =
                // deadline_at      =
                // current_id       = manuscriptId_SCREENING_1
                ////// Update Manuscript///////
                // editor_id                =
                // current_editor_manuscript_id = manuscriptId_SCREENING_1
                $stage      = SCREENING;
                $status     = IN_SCREENING;
                $loop       = 1;
            }
            $EMdata = [
                        'stage'         => $stage,
                        'manuscript_id' => $i,
                        'user_id'       => $tmp ,
                        'loop'          => $loop,
                        'delivery_at'   => '4/4/2015',
                        'deadline_at'   => '6/4/2015',
                        'current_id'    => $i . '_'. $stage .'_1',
                        ] ;

            $EMId = DB::table("editor_manuscripts")->insertGetId($EMdata);

            $manuscript = Manuscript::find($i);
            $manuscript->status = $status;
            $manuscript->current_editor_manuscript_id  = $i . '_'. $stage .'_1';
            $manuscript->save();
                     
        }
 
        
            



        //4. Thu ky toan soan se lua chon nha phan bien va BTV chuyen trach
        // Update Manuscript//
        // section_editor_id            =
        // invite_reviewer_ids          =
        // reviewer_ids                 =
        // reject_reviewer_ids          =
        // delivery_at                  =
        // deadline_at                  =       
        // status                       = 
        // current_editor_manuscript    = manuscriptId_IN_REVIEW_1
        // 
        // tao moi EditorManuScript //
        // current_id           = manuscriptId_IN_REVIEW_1
        // stage                = REVIEWING
        // manuscript_ids       =
        // loop                 = current_id[3] + 1
        // delivery_at          = 
        // deadline_at          = 

        for($i=45; $i<=250; $i++)
        {
            $stage          = REVIEWING;
            $status         = IN_REVIEW;
            $loop           = 1;
            
            $SEid      = $faker->randomElement($section_editor_id);           
            $IRids     = $faker->randomElement($reviewer_ids);
            $EMdata = [
                        'stage'         => $stage,
                        'manuscript_id' => $i,
                        'loop'          => $loop,
                        'delivery_at'   => '6/4/2015',
                        'deadline_at'   => '8/4/2015',
                        'current_id'    => $i . '_' . $stage . '_' . $loop,
                        ] ;

            $EMId = DB::table("editor_manuscripts")->insertGetId($EMdata);
            
            $manuscript = Manuscript::find($i);

            $manuscript->section_editor_id              = $SEid;
            $manuscript->invite_reviewer_ids            = $IRids;
            $manuscript->status                         = $status;
            $manuscript->current_editor_manuscript_id   = $i . '_'. $stage .'_1';
            $manuscript->save();
           
        }       
  
        // 4.1 Quyet dinh cua nha phan bien //
        
       for ($i=65; $i <=250 ; $i++) { 

            $reject_ids  = null;
            $reviewer_ids  = null;
            $manuscript = Manuscript::find($i);
            if($i <90){
                // 4.1.1 Nha phan bien tu choi
                // Update Manuscript//
                // tao moi EditorManuScript //                
                $manuscripts = DB::table("manuscripts")->find($i);

                $reject_ids     = $manuscripts->invite_reviewer_ids;
                $stage          = REVIEWING;
                $status         = IN_REVIEW;
                $loop           = 2;
            }elseif ($i > 90) {
                //4.1.2 Nha phan bien chap nhan
                // Update Manuscript//
                // tao moi EditorManuScript //
                $manuscripts = DB::table("manuscripts")->find($i);

                $reviewer_ids   = $manuscripts->invite_reviewer_ids;
                $stage          = REVIEWING;
                $status         = IN_REVIEW;
                $loop           = 1;
            }
            
            

            // $SEid      = $faker->randomElement($section_editor_id);           
            // $IRids     = $faker->randomElement($reviewer_ids);
            //$reviewer_id           = $faker->randomElement($reviewer_ids);
            //$reject_reviewer_id    = $faker->randomElement($reject_reviewer_ids);   
            $EMdata = [
                        'stage'         => $stage,
                        'manuscript_id' => $i,
                        'loop'          => $loop,
                        'delivery_at'   => '6/4/2015',
                        'deadline_at'   => '8/4/2015',
                        'current_id'    => $i . '_' . $stage . '_' . $loop,
                        ] ;

            $EMId = DB::table("editor_manuscripts")->insertGetId($EMdata);
            
            

            $manuscript->invite_reviewer_ids            = null;
            $manuscript->reviewer_ids                   = $reviewer_ids;
            $manuscript->reject_reviewer_ids            = $reject_ids;
            $manuscript->status                         = $status;
            $manuscript->current_editor_manuscript_id   = $i . '_'. $stage .'_1';
            $manuscript->save();
       }
        





        // 
        // 4.2 BTV chuyen trach danh gia ban thao
        // Update Manuscript//
        // tao moi EditorManuScript //
        // 
        

        //5. Quyet dinh cua Tong Bien Tap
        
        for ($i=120; $i <=250 ; $i++) { 

            $manuscript = Manuscript::find($i);

            if($i > 120 && $i <180){
                //5.1 Tu choi ban thao
                // Update Manuscript//
                // tao moi EditorManuScript //
                $stage          = REVIEWING;
                $status         = REJECTED;
                $loop           = 1;
            }elseif ($i > 180 && $i <190) {
               //5.2 Yeu cau chinh sua ban thao
                // Update Manuscript//
                // tao moi EditorManuScript //
                $stage          = REVIEWING;
                $status         = IN_REVIEW;
                $loop           = 2;
            }
            elseif ($i > 190 && $i <220) {
               //5.3 Yeu cau phan bien lai ban thao
                // Update Manuscript//
                // tao moi EditorManuScript //
                $stage          = REVIEWING;
                $status         = IN_REVIEW;
                $loop           = 2;
            }elseif ($i > 220 && $i <250) {
                //5.4 Chap nhan ban thao
                // Update Manuscript//
                // tao moi EditorManuScript //
                $stage          = EDITING;
                $status         = IN_EDITING;
                $loop           = 1;
            }
                       
            $EMdata = [
                        'stage'         => $stage,
                        'manuscript_id' => $i,
                        'loop'          => $loop,
                        'delivery_at'   => '6/4/2015',
                        'deadline_at'   => '8/4/2015',
                        'current_id'    => $i . '_' . $stage . '_' . $loop,
                        ] ;

            $EMId = DB::table("editor_manuscripts")->insertGetId($EMdata);
            
            $manuscript->status                         = $status;
            $manuscript->current_editor_manuscript_id   = $i . '_'. $stage .'_1';
            $manuscript->save();
       }

        //6. xuat ban
        for ($i=230; $i <=250 ; $i++) { 

            $manuscript = Manuscript::find($i);

            $stage          = PUBLISHING;
            $status         = PUBLISHED;
            $loop           = 1;
                       
            $EMdata = [
                        'stage'         => $stage,
                        'manuscript_id' => $i,
                        'loop'          => $loop,
                        'delivery_at'   => '6/4/2015',
                        'deadline_at'   => '8/4/2015',
                        'current_id'    => $i . '_' . $stage . '_' . $loop,
                        ] ;
            $EMId = DB::table("editor_manuscripts")->insertGetId($EMdata);
            
            $manuscript->status                         = $status;
            $manuscript->current_editor_manuscript_id   = $i . '_'. $stage .'_1';
            $manuscript->save();
       }    
    }
}
