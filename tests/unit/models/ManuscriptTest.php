<?php

 use App\Manuscript;
 use App\EditorManuscript;
 use App\Lib\Prototype\DbClasses\Eloquent\EloquentManuscriptRepository;
 use App\Lib\Prototype\DbClasses\Eloquent\EloquentReportRepository;
 use App\Lib\Prototype\DbClasses\Eloquent\EloquentEditorManuscriptRepository;
// use Illuminate\Contracts\Auth\Guard;


use App\User;
use Illuminate\Contracts\Auth\Guard;
use App\Lib\Prototype\Interfaces\UserInterface;
use App\Lib\Prototype\Interfaces\EditorManuscriptInterface;
use App\Lib\Prototype\DBClasses\Eloquent\EloquentUserRepository;
use App\Lib\Prototype\Interfaces;
use DB;


//use tests\unit\models\ReportInYear;
class ManuscriptTest extends TestCase {
	/**
	 * A basic functional test example.
	 *
	 * @return void
	 */
	protected $repo;
	// protected $auth;

	public function __construct()
	{
		$this->input = ['author_id' => 11, 
                'author_comments' => 'flsajklfdskal;jkl;flsajklfdskal;jkl;flsajklfdskal;jkl;flsajklfdskal;jkl;flsajklfdskal;jkl;flsajklfdskal;jkl;flsajklfdskal;jkl;flsajklfdskal;jkl;flsajklfdskal;jkl;sdflsajklfdskal;jkl;flsajklfdskal;jkl;',
                "type" => "4",
                "expect_journal_id" => "23",
                "publish_journal_id" => 0,
                "name" => "Sự phát triển KTTT",
                "summary_vi" => "flsajklfdskal;jkl;flsajklfdskal;jkl;flsajklfdskal;jkl;flsajklfdskal;jkl;flsajklfdskal;jkl;flsajklfdskal;jkl;flsajklfdskal;jkl;flsajklfdskal;jkl;flsajklfdskal;jkl;sdflsajklfdskal;jkl;flsajklfdskal;jkl;",
                "keyword_vi" => "3,4,5",
                "keyword_en" => "3,4,5",
                "summary_en" => "flsajklfdskal;jkl;flsajklfdskal;jkl;flsajklfdskal;jkl;flsajklfdskal;jkl;flsajklfdskal;jkl;flsajklfdskal;jkl;flsajklfdskal;jkl;flsajklfdskal;jkl;flsajklfdskal;jkl;sdflsajklfdskal;jkl;flsajklfdskal;jkl;",
                "topic" => "dsafdsafdasfdsa",
                "recommend" => 0,
                "propose_reviewer" => "flsajklfdskal;jkl;flsajklfdskal;jkl;flsajklfdskal;jkl;flsajklfdskal;jkl;flsajklfdskal;jkl;flsajklfdskal;jkl;flsajklfdskal;jkl;flsajklfdskal;jkl;flsajklfdskal;jkl;sdflsajklfdskal;jkl;flsajklfdskal;jkl;",
                "co_author" => "flsajklfdskal;jkl;flsajklfdskal;jkl;flsajklfdskal;jkl;flsajklfdskal;jkl;flsajklfdskal;jkl;flsajklfdskal;jkl;flsajklfdskal;jkl;flsajklfdskal;jkl;flsajklfdskal;jkl;sdflsajklfdskal;jkl;flsajklfdskal;jkl;",

                ];
  
  		
	}

    /**
     * testManuscriptWaitReview 
     */
	public function testManuscriptWaitReview()
    {
        $user = User::where('actor_no',REVIEWER)->first();
        $this->be($user);
    	$uersRepo               = new EloquentUserRepository($user);
        $EditorManuscript       = new EloquentEditorManuscriptRepository(new EditorManuscript);
        $this->repo   = new EloquentManuscriptRepository(new Manuscript, $EditorManuscript , $uersRepo);
       
    	$result = $this->repo->getColumnTable(WAIT_REVIEW, REVIEWER, WAIT_REVIEW);

        $status     = $result['data']->first()->status;
        $this->assertEquals($status, IN_REVIEW);
    }

    //model chua lam xong
    /*public function testManuscriptInReview1()
    {   
        $user = User::where('actor_no',AUTHOR)->first();  
        $this->be($user);
        $uersRepo     = new EloquentUserRepository($user);
        $this->repo   = new EloquentManuscriptRepository(new Manuscript, new EditorManuscript, $uersRepo);
       
        $result = $this->repo->getColumnTable(WAIT_REVIEW, REVIEWER, WAIT_REVIEW);
       dd( $result );
        $status     = $result['data']->first()->status;
        $this->assertEquals($status, IN_REVIEW);
       
    }*/
   

    /**
     * testManuscriptUnsubmit
     */
    public function testManuscriptUnsubmit()
    {
        $user = User::where('actor_no',AUTHOR)->first();
        $this->be($user);
        $uersRepo               = new EloquentUserRepository($user);
        $EditorManuscript       = new EloquentEditorManuscriptRepository(new EditorManuscript);
        $this->repo   = new EloquentManuscriptRepository(new Manuscript, $EditorManuscript , $uersRepo);
       
        $result = $this->repo->getColumnTable(UNSUBMIT, AUTHOR);
       
        $status     = $result['data']->first()->status;
        $this->assertEquals($status, UNSUBMIT);
    }

    /**
     * testManuscriptRejectedReview 
     */
   /* public function testManuscriptRejectedReview1()
    {
        $user = User::where('actor_no',REVIEWER)->first();
        $this->be($user);
        $uersRepo     = new EloquentUserRepository($user);
        $this->repo   = new EloquentManuscriptRepository(new Manuscript, new EditorManuscript, $uersRepo);
       
        $result = $this->repo->getColumnTable(REJECTED_REVIEW, REVIEWER, REJECTED_REVIEW);
        $status     = $result['data']->first()->status;
       //   dd($result)  ;
        $this->assertEquals($status, REJECTED);
    }*/

    /**
     * testManuscriptInReview 
     */
    public function testManuscriptInReview()
    {
        $user = User::where('actor_no',REVIEWER)->first();
        $this->be($user);
        $uersRepo               = new EloquentUserRepository($user);
        $EditorManuscript       = new EloquentEditorManuscriptRepository(new EditorManuscript);
        $this->repo   = new EloquentManuscriptRepository(new Manuscript, $EditorManuscript , $uersRepo);
       
        $result = $this->repo->getColumnTable(REJECTED_REVIEW, REVIEWER);
        $status     = $result['data']->first()->status;
            
        $this->assertEquals($status, IN_REVIEW);
        $this->assertEquals($user->actor_no, REVIEWER);
    }
   /* public function testManuscriptInReview2()
    {
        $user = User::where('actor_no',AUTHOR)->first();
        $this->be($user);
        $uersRepo     = new EloquentUserRepository($user);
        $this->repo   = new EloquentManuscriptRepository(new Manuscript, new EditorManuscript, $uersRepo);
       
        $result = $this->repo->getColumnTable(REJECTED_REVIEW, $this->repo->getPermission());
        $status     = $result['data']->first()->status;
        //    dd($result['data']->first());
        $this->assertEquals($status, IN_REVIEW);
        $this->assertEquals($user->actor_no, AUTHOR);
    }*/

    /**
     * testManuscriptInReview 
     */
     public function testManuscriptInEditing1()
    {
        $user = User::where('actor_no',AUTHOR)->first();
        $this->be($user);
        $uersRepo               = new EloquentUserRepository($user);
        $EditorManuscript       = new EloquentEditorManuscriptRepository(new EditorManuscript);
        $this->repo   = new EloquentManuscriptRepository(new Manuscript, $EditorManuscript , $uersRepo);
       
        $result = $this->repo->getColumnTable(IN_EDITING, $this->repo->getPermission());
        $status     = $result['data']->first()->status;
        //    dd($result['data']->first());
        $this->assertEquals($status, IN_EDITING);
       //$this->assertEquals($user->actor_no, AUTHOR);
    }
    public function testManuscriptInEditing2()
    {
        $user = User::where('actor_no',MANAGING_EDITOR)->first();
        $this->be($user);
        $uersRepo               = new EloquentUserRepository($user);
        $EditorManuscript       = new EloquentEditorManuscriptRepository(new EditorManuscript);
        $this->repo   = new EloquentManuscriptRepository(new Manuscript, $EditorManuscript , $uersRepo);
       
        $result = $this->repo->getColumnTable(IN_EDITING, $this->repo->getPermission());
        $status     = $result['data']->first()->status;
        //    dd($result['data']->first());
        $this->assertEquals($status, IN_EDITING);
        //$this->assertEquals($user->actor_no, AUTHOR);
    }
    /*public function testManuscriptInEditing3()
    {
        $user = User::where('actor_no',SECTION_EDITOR)->first();
        $this->be($user);
        $uersRepo     = new EloquentUserRepository($user);
        $this->repo   = new EloquentManuscriptRepository(new Manuscript, new EditorManuscript, $uersRepo);
       
        $result = $this->repo->getColumnTable(IN_EDITING, $this->repo->getPermission());
        $status     = $result['data']->first()->status;
            dd($result['data']->first());
        $this->assertEquals($status, IN_EDITING);
        //$this->assertEquals($user->actor_no, AUTHOR);
    }*/
    public function testManuscriptInEditing4()
    {
        $user = User::where('actor_no',CHIEF_EDITOR)->first();
        $this->be($user);
        $uersRepo               = new EloquentUserRepository($user);
        $EditorManuscript       = new EloquentEditorManuscriptRepository(new EditorManuscript);
        $this->repo   = new EloquentManuscriptRepository(new Manuscript, $EditorManuscript , $uersRepo);
       
        $result = $this->repo->getColumnTable(IN_EDITING, $this->repo->getPermission());
        $status     = $result['data']->first()->status;
        //    dd($result['data']->first());
        $this->assertEquals($status, IN_EDITING);
        //$this->assertEquals($user->actor_no, AUTHOR);
    }
   /* public function testManuscriptInEditing5()
    {
        $user = User::where('actor_no',COPY_EDITOR)->first();
        $this->be($user);
        $uersRepo     = new EloquentUserRepository($user);
        $this->repo   = new EloquentManuscriptRepository(new Manuscript, new EditorManuscript, $uersRepo);
       
        $result = $this->repo->getColumnTable(IN_EDITING, $this->repo->getPermission());
        $status     = $result['data']->first()->status;
        //    dd($result['data']->first());
        $this->assertEquals($status, IN_EDITING);
        //$this->assertEquals($user->actor_no, AUTHOR);
    }*/
    /*public function testManuscriptInEditing6()
    {
        $user = User::where('actor_no',LAYOUT_EDITOR)->first();
        $this->be($user);
        $uersRepo     = new EloquentUserRepository($user);
        $this->repo   = new EloquentManuscriptRepository(new Manuscript, new EditorManuscript, $uersRepo);
       
        $result = $this->repo->getColumnTable(IN_EDITING, $this->repo->getPermission());
        $status     = $result['data']->first()->status;
        //    dd($result['data']->first());
        $this->assertEquals($status, IN_EDITING);
        //$this->assertEquals($user->actor_no, AUTHOR);
    }*/



 
    /**
     * with drawn
     * 
     */
    //ADMIN
    
    //AUTHOR
    public function testManuscriptDrawn2()
    {
        $user = User::where('actor_no',AUTHOR)->first();
        $this->be($user);
        $uersRepo               = new EloquentUserRepository($user);
        $EditorManuscript       = new EloquentEditorManuscriptRepository(new EditorManuscript);
        $this->repo   = new EloquentManuscriptRepository(new Manuscript, $EditorManuscript , $uersRepo);

        $result = $this->repo->getByStatus(WITHDRAWN);
        $id = $result['data']->first()->id;
        $tpm = DB::table('manuscripts')->select('id','status')->where('id',$id)->first();
        //dd($tpm->status);
        $this->assertEquals($tpm->status, WITHDRAWN);
    }
    //MANAGING_EDITOR
    public function testManuscriptDrawn3()
    {
        $user = User::where('actor_no',MANAGING_EDITOR)->first();
        $this->be($user);
        $uersRepo               = new EloquentUserRepository($user);
        $EditorManuscript       = new EloquentEditorManuscriptRepository(new EditorManuscript);
        $this->repo   = new EloquentManuscriptRepository(new Manuscript, $EditorManuscript , $uersRepo);

        $result = $this->repo->getByStatus(WITHDRAWN);
          $id = $result['data']->first()->id;
        $tpm = DB::table('manuscripts')->select('id','status')->where('id',$id)->first();
       $this->assertEquals($tpm->status, WITHDRAWN);
    }
    //SCREENING_EDITOR
    //SECTION_EDITOR
    public function testManuscriptDrawn5()
    {
        $user = User::where('actor_no',SECTION_EDITOR)->first();
        $this->be($user);
        $uersRepo               = new EloquentUserRepository($user);
        $EditorManuscript       = new EloquentEditorManuscriptRepository(new EditorManuscript);
        $this->repo   = new EloquentManuscriptRepository(new Manuscript, $EditorManuscript , $uersRepo);

        $result = $this->repo->getByStatus(WITHDRAWN);
         $id = $result['data']->first()->id;
        $tpm = DB::table('manuscripts')->select('id','status')->where('id',$id)->first();
        $this->assertEquals($tpm->status, WITHDRAWN);
    }
    //REVIEWER
    //CHIEF_EDITOR
    public function testManuscriptDrawn7()
    {
        $user = User::where('actor_no',CHIEF_EDITOR)->first();
        $this->be($user);
        $uersRepo               = new EloquentUserRepository($user);
        $EditorManuscript       = new EloquentEditorManuscriptRepository(new EditorManuscript);
        $this->repo   = new EloquentManuscriptRepository(new Manuscript, $EditorManuscript , $uersRepo);

        $result = $this->repo->getByStatus(WITHDRAWN);
         $id = $result['data']->first()->id;
        $tpm = DB::table('manuscripts')->select('id','status')->where('id',$id)->first();
        $this->assertEquals($tpm->status, WITHDRAWN);
    }
    //COPY_EDITOR
    //LAYOUT_EDITOR
    //PRODUCTION_EDITOR
    
    /**
     * reject
     * 
     */
    //ADMIN

    //AUTHOR
    public function testManuscriptReject2()
    {
        $user = User::where('actor_no',AUTHOR)->first();
        $this->be($user);
        $uersRepo               = new EloquentUserRepository($user);
        $EditorManuscript       = new EloquentEditorManuscriptRepository(new EditorManuscript);
        $this->repo   = new EloquentManuscriptRepository(new Manuscript, $EditorManuscript , $uersRepo);
        $result = $this->repo->getByStatus(REJECTED);
        
        $mnid = $result['data']->first()->id;
        $manuid = DB::table('manuscripts')->where('id',$mnid)->first();

        $this->assertEquals($result['data']->first()->author_id, $user->id);
        $this->assertEquals($manuid->status, REJECTED);
    }
    //MANAGING_EDITOR
    public function testManuscriptReject3()
    {
        $user = User::where('actor_no',MANAGING_EDITOR)->first();
        $this->be($user);
        $uersRepo               = new EloquentUserRepository($user);
        $EditorManuscript       = new EloquentEditorManuscriptRepository(new EditorManuscript);
        $this->repo   = new EloquentManuscriptRepository(new Manuscript, $EditorManuscript , $uersRepo);
        $result = $this->repo->getByStatus(REJECTED);
        
        //$mnid = $result['data']->first()->id;
        //$manuid = DB::table('manuscripts')->where('id',$mnid)->first();
        //dd($result['data']->first()->status);
       // dd($result['data']->first(),$user->id); 

        $status = $result['data']->first()->status;
        //$this->assertEquals($result['data']->first()->editor_id, $user->id);
        $this->assertEquals($status, REJECTED);
    }
    //SCREENING_EDITOR
    //SECTION_EDITOR
    // public function testManuscriptReject5()
    // {
    //     //$manu = DB::table('manuscripts')->where('status',REJECTED)->first();     
    //     $user = User::where('actor_no',SECTION_EDITOR)->get();
    //     dd( $user);
    //     $this->be($user);
    //     $uersRepo               = new EloquentUserRepository($user);
    //     $EditorManuscript       = new EloquentEditorManuscriptRepository(new EditorManuscript);
    //     $this->repo   = new EloquentManuscriptRepository(new Manuscript, $EditorManuscript , $uersRepo);
    //     $result = $this->repo->getByStatus(REJECTED);
        
    //     dd($result);
    //     //$mnid = $result['data']->first()->id;
        

    //     $status = $result['data']->first()->status;
    //     $this->assertEquals($result['data']->first()->section_editor_id, $user->id);
    //     $this->assertEquals($status, REJECTED);
    // }
    //REVIEWER
    //CHIEF_EDITOR
    public function testManuscriptReject7()
    {
        $user = User::where('actor_no',CHIEF_EDITOR)->first();
        $this->be($user);
        $uersRepo               = new EloquentUserRepository($user);
        $EditorManuscript       = new EloquentEditorManuscriptRepository(new EditorManuscript);
        $this->repo   = new EloquentManuscriptRepository(new Manuscript, $EditorManuscript , $uersRepo);
        $result = $this->repo->getByStatus(REJECTED);
        
        //$mnid = $result['data']->first()->id;
        //$manuid = DB::table('manuscripts')->where('id',$mnid)->first();
//dd($result['data']->first());
        $status = $result['data']->first()->status;
        //$this->assertEquals($result['data']->first()->editor_id, $user->id);
        $this->assertEquals($status, REJECTED);
    }
    //COPY_EDITOR
    //LAYOUT_EDITOR
    //PRODUCTION_EDITOR
    //
    

    /**
     * reviewed
     * 
     */
    
    //ADMIN
    
    //AUTHOR
    //MANAGING_EDITOR
    //SCREENING_EDITOR
    //SECTION_EDITOR
    //REVIEWER
    public function testManuscriptReviewed()
    {
        $user = User::where('actor_no',REVIEWER)->first();
        $this->be($user);
        $uersRepo               = new EloquentUserRepository($user);
        $EditorManuscript       = new EloquentEditorManuscriptRepository(new EditorManuscript);
        $this->repo   = new EloquentManuscriptRepository(new Manuscript, $EditorManuscript , $uersRepo);
        $result = $this->repo->getColumnTable(REVIEWED, REVIEWER, REVIEWED);
        
        $mnid = $result['data']->first()->id;
        $manuid = DB::table('manuscripts')->where('id',$mnid)->first();
       
        $arrayIds = explode(',',$manuid->reviewer_ids);
        $test = in_array($user->id, $arrayIds);
        $this->assertTrue($test);
        $this->assertEquals($manuid->status, IN_REVIEW);
    }
    //CHIEF_EDITOR
    //COPY_EDITOR
    //LAYOUT_EDITOR
    //PRODUCTION_EDITOR
    //
    /**
     * report publish 
     * 1 year
     */
    //ADMIN
    public function testManuscriptRePortYear1()
    {
        $user = User::where('actor_no',ADMIN)->first();
        $this->be($user);
        $uersRepo               = new EloquentUserRepository($user);
        $this->repo   = new EloquentReportRepository(new Manuscript, $uersRepo);

        $start = date("d/m/Y",time());
        $result = $this->repo->getDataReport($start, null, REPORT_PUBLISH_IN_YEAR);
       
        $this->assertEquals($start, $result['end']);
    }
    //AUTHOR
    public function testManuscriptRePortYear2()
    {
        $user = User::where('actor_no',AUTHOR)->first();
        $this->be($user);
        $uersRepo               = new EloquentUserRepository($user);
        $this->repo   = new EloquentReportRepository(new Manuscript, $uersRepo);

        $start = date("d/m/Y",time());
        $result = $this->repo->getDataReport($start, null, REPORT_PUBLISH_IN_YEAR);
        
        $this->assertEquals($start, $result['end']);
    }
    //MANAGING_EDITOR
    public function testManuscriptRePortYear3()
    {
        $user = User::where('actor_no',MANAGING_EDITOR)->first();
        $this->be($user);
        $uersRepo               = new EloquentUserRepository($user);
        $this->repo   = new EloquentReportRepository(new Manuscript, $uersRepo);

        $start = date("d/m/Y",time());
        $result = $this->repo->getDataReport($start, null, REPORT_PUBLISH_IN_YEAR);
        
        $this->assertEquals($start, $result['end']);
    }
    //SCREENING_EDITOR
    public function testManuscriptRePortYear4()
    {
        $user = User::where('actor_no',SCREENING_EDITOR)->first();
        $this->be($user);
        $uersRepo               = new EloquentUserRepository($user);
        $this->repo   = new EloquentReportRepository(new Manuscript, $uersRepo);
        $start = date("d/m/Y",time());
        $result = $this->repo->getDataReport($start, null, REPORT_PUBLISH_IN_YEAR);
        
        $this->assertEquals($start, $result['end']);
    }
    //SECTION_EDITOR
    public function testManuscriptRePortYear5()
    {
        $user = User::where('actor_no',SECTION_EDITOR)->first();
        $this->be($user);
        $uersRepo               = new EloquentUserRepository($user);
        $this->repo   = new EloquentReportRepository(new Manuscript, $uersRepo);

        $start = date("d/m/Y",time());
        $result = $this->repo->getDataReport($start, null, REPORT_PUBLISH_IN_YEAR);
        
        $this->assertEquals($start, $result['end']);
    }
    //REVIEWER
    public function testManuscriptRePortYear6()
    {
        $user = User::where('actor_no',REVIEWER)->first();
        $this->be($user);
        $uersRepo               = new EloquentUserRepository($user);
        $this->repo   = new EloquentReportRepository(new Manuscript, $uersRepo);

        $start = date("d/m/Y",time());
        $result = $this->repo->getDataReport($start, null, REPORT_PUBLISH_IN_YEAR);
        
        $this->assertEquals($start, $result['end']);
    }
    //CHIEF_EDITOR
    public function testManuscriptRePortYear7()
    {
        $user = User::where('actor_no',CHIEF_EDITOR)->first();
        $this->be($user);
        $uersRepo               = new EloquentUserRepository($user);
        $this->repo   = new EloquentReportRepository(new Manuscript, $uersRepo);

        $start = date("d/m/Y",time());
        $result = $this->repo->getDataReport($start, null, REPORT_PUBLISH_IN_YEAR);
        
        $this->assertEquals($start, $result['end']);
    }
    //COPY_EDITOR
    public function testManuscriptRePortYear8()
    {
        $user = User::where('actor_no',COPY_EDITOR)->first();
        $this->be($user);
        $uersRepo               = new EloquentUserRepository($user);
        $this->repo   = new EloquentReportRepository(new Manuscript, $uersRepo);

        $start = date("d/m/Y",time());
        $result = $this->repo->getDataReport($start, null, REPORT_PUBLISH_IN_YEAR);
        
        $this->assertEquals($start, $result['end']);
    }
    //LAYOUT_EDITOR
    public function testManuscriptRePortYear9()
    {
        $user = User::where('actor_no',LAYOUT_EDITOR)->first();
        $this->be($user);
        $uersRepo               = new EloquentUserRepository($user);
        $this->repo   = new EloquentReportRepository(new Manuscript, $uersRepo);

        $start = date("d/m/Y",time());
        $result = $this->repo->getDataReport($start, null, REPORT_PUBLISH_IN_YEAR);
        
        $this->assertEquals($start, $result['end']);
    }
    //PRODUCTION_EDITOR
    public function testManuscriptRePortYear10()
    {
        $user = User::where('actor_no',PRODUCTION_EDITOR)->first();
        $this->be($user);
        $uersRepo               = new EloquentUserRepository($user);
        $this->repo   = new EloquentReportRepository(new Manuscript, $uersRepo);

        $start = date("d/m/Y",time());
        $result = $this->repo->getDataReport($start, null, REPORT_PUBLISH_IN_YEAR);
        
        $this->assertEquals($start, $result['end']);
    }

    /**
     * all
     */

    //ADMIN
    //AUTHOR
    public function testManuscriptAll2()
    {
        $user = User::where('actor_no',AUTHOR)->first();
        $this->be($user);
        $uersRepo               = new EloquentUserRepository($user);
        $EditorManuscript       = new EloquentEditorManuscriptRepository(new EditorManuscript);
        $this->repo   = new EloquentManuscriptRepository(new Manuscript, $EditorManuscript , $uersRepo);
        $result = $this->repo->getByStatus(ALL);
        
        $count1 = $result['data']->count();
        $count2 = DB::table('manuscripts')->where('author_id',$user->id)->count();

        $this->assertEquals($count1, $count2);
    }
    //MANAGING_EDITOR
    // public function testManuscriptAll3()
    // {
    //     $user = User::where('actor_no',MANAGING_EDITOR)->first();
    //     $this->be($user);
    //     $uersRepo               = new EloquentUserRepository($user);
    //     $EditorManuscript       = new EloquentEditorManuscriptRepository(new EditorManuscript);
    //     $this->repo   = new EloquentManuscriptRepository(new Manuscript, $EditorManuscript , $uersRepo);
    //     $result = $this->repo->getByStatus(ALL);
        
    //     $count1 = $result['data']->count();
    //     $count2 = DB::table('manuscripts')->where('editor_id',$user->id)->count();

    //     $this->assertEquals($count1, $count2);
    // }
    //SCREENING_EDITOR
    //SECTION_EDITOR
    public function testManuscriptAll5()
    {
        $user = User::where('actor_no',SECTION_EDITOR)->first();
        $this->be($user);
        $uersRepo               = new EloquentUserRepository($user);
        $EditorManuscript       = new EloquentEditorManuscriptRepository(new EditorManuscript);
        $this->repo   = new EloquentManuscriptRepository(new Manuscript, $EditorManuscript , $uersRepo);
        $result = $this->repo->getByStatus(ALL);
        
        $count1 = $result['data']->count();
        $count2 = DB::table('manuscripts')->where('section_editor_id',$user->id)->count();

        $this->assertEquals($count1, $count2);
    }
    //REVIEWER
    //CHIEF_EDITOR
    //COPY_EDITOR
    //LAYOUT_EDITOR
   
    //PRODUCTION_EDITOR
    
    /**
     * admin/manuscript/in-screening
     */

    //ADMIN
    //AUTHOR
    public function testManuscriptInInScreen1()
    {
        $user = User::where('actor_no',AUTHOR)->first();
        $this->be($user);
        $uersRepo               = new EloquentUserRepository($user);
        $EditorManuscript       = new EloquentEditorManuscriptRepository(new EditorManuscript);
        $this->repo   = new EloquentManuscriptRepository(new Manuscript, $EditorManuscript , $uersRepo);
        $result = $this->repo->getColumnTable(IN_SCREENING, $user->actor_no);
        
        
        $count1 = $result['data']->count();
        $count2 = DB::table('manuscripts')->where(['author_id'=>$user->id, 'status' =>IN_SCREENING,  ] , '=')->count();

        $this->assertEquals($count1, $count2);
    }
    //MANAGING_EDITOR
    // public function testManuscriptInInScreen2()
    // {
    //     $user = User::where('actor_no',MANAGING_EDITOR)->first();
    //     $this->be($user);
    //     $uersRepo               = new EloquentUserRepository($user);
    //     $EditorManuscript       = new EloquentEditorManuscriptRepository(new EditorManuscript);
    //     $this->repo   = new EloquentManuscriptRepository(new Manuscript, $EditorManuscript , $uersRepo);
    //     $result = $this->repo->getColumnTable(IN_SCREENING, $user->actor_no);
        
        
    //     $count1 = $result['data']->count();
    //     $count2 = DB::table('manuscripts')->where(['managing_id'=>$user->id, 'status' =>IN_SCREENING,  ] , '=')->count();
        
    //     $this->assertEquals($count1, $count2);
    // }
    //SCREENING_EDITOR
    // public function testManuscriptInInScreen3()
    // {
    //     $user = User::where('actor_no',SCREENING_EDITOR)->first();
    //     $this->be($user);
    //     $uersRepo               = new EloquentUserRepository($user);
    //     $EditorManuscript       = new EloquentEditorManuscriptRepository(new EditorManuscript);
    //     $this->repo   = new EloquentManuscriptRepository(new Manuscript, $EditorManuscript , $uersRepo);
    //     $result = $this->repo->getColumnTable(IN_SCREENING, $user->actor_no);
        
        
    //     $count1 = $result['data']->count();
    //     $count2 = DB::table('manuscripts')->where(['screening_id'=>$user->id, 'status' =>IN_SCREENING,  ] , '=')->count();
        
    //     $this->assertEquals($count1, $count2);
    // }
    //SECTION_EDITOR
    //REVIEWER
    //CHIEF_EDITOR
    public function testManuscriptInInScreen4()
    {
        $user = User::where('actor_no',CHIEF_EDITOR)->first();
        $this->be($user);
        $uersRepo               = new EloquentUserRepository($user);
        $EditorManuscript       = new EloquentEditorManuscriptRepository(new EditorManuscript);
        $this->repo   = new EloquentManuscriptRepository(new Manuscript, $EditorManuscript , $uersRepo);
        $result = $this->repo->getColumnTable(IN_SCREENING, $user->actor_no);
        
        
        $count1 = $result['data']->count();
        $count2 = DB::table('manuscripts')->where(['status' =>IN_SCREENING,  ] , '=')->count();
        
        $this->assertEquals($count1, $count2);
    }
    //COPY_EDITOR
    //LAYOUT_EDITOR
    //PRODUCTION_EDITOR
    
    /**
     * admin/manuscript/get_all
     */
    //ADMIN
    //AUTHOR
    //MANAGING_EDITOR
    //SCREENING_EDITOR
    //SECTION_EDITOR
    //REVIEWER
    //CHIEF_EDITOR
    //COPY_EDITOR
    //LAYOUT_EDITOR
    //PRODUCTION_EDITOR
    public function testManuscriptDelete()
    {
        $user = User::where('actor_no',CHIEF_EDITOR)->first();
        $this->be($user);
        $uersRepo               = new EloquentUserRepository($user);
        $EditorManuscript       = new EloquentEditorManuscriptRepository(new EditorManuscript);
        $this->repo   = new EloquentManuscriptRepository(new Manuscript, $EditorManuscript , $uersRepo);
        $result = $this->repo->ManuscriptSoftDeletes([20,21,22,32]);
                
        $this->assertEquals($result, true);
    }
}