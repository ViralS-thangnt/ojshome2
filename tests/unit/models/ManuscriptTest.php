<?php

 use App\Manuscript;
 use App\EditorManuscript;
 use App\Lib\Prototype\Interfaces\UserInterface as UserReopsitory;
 use App\Lib\Prototype\DbClasses\Eloquent\EloquentManuscriptRepository;
// use Illuminate\Contracts\Auth\Guard;


use App\User;
use Illuminate\Contracts\Auth\Guard;
use App\Lib\Prototype\Interfaces\UserInterface;
use App\Lib\Prototype\DBClasses\Eloquent\EloquentUserRepository;
use App\Lib\Prototype\Interfaces;


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
    	$uersRepo     = new EloquentUserRepository($user);
        $this->repo   = new EloquentManuscriptRepository(new Manuscript, new EditorManuscript, $uersRepo);
       
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
        $uersRepo     = new EloquentUserRepository($user);
        $this->repo   = new EloquentManuscriptRepository(new Manuscript, new EditorManuscript, $uersRepo);
       
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
        $uersRepo     = new EloquentUserRepository($user);
        $this->repo   = new EloquentManuscriptRepository(new Manuscript, new EditorManuscript, $uersRepo);
       
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
        $uersRepo     = new EloquentUserRepository($user);
        $this->repo   = new EloquentManuscriptRepository(new Manuscript, new EditorManuscript, $uersRepo);
       
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
        $uersRepo     = new EloquentUserRepository($user);
        $this->repo   = new EloquentManuscriptRepository(new Manuscript, new EditorManuscript, $uersRepo);
       
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
        $uersRepo     = new EloquentUserRepository($user);
        $this->repo   = new EloquentManuscriptRepository(new Manuscript, new EditorManuscript, $uersRepo);
       
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
     * testManuscriptReviewed
     */
    public function testManuscriptReviewed()
    {
        $user = User::where('actor_no',REVIEWER)->first();
        $this->be($user);
        $uersRepo     = new EloquentUserRepository($user);
        $this->repo   = new EloquentManuscriptRepository(new Manuscript, new EditorManuscript, $uersRepo);
       
        $result = $this->repo->getColumnTable(WAIT_REVIEW, REVIEWER, WAIT_REVIEW);
        $status     = $result['data']->first()->status;
           // dd($status);
        $this->assertEquals($status, IN_REVIEW);
        //$this->assertEquals($user->actor_no, AUTHOR);
    }
    /**
     * report publish 
     * 1 year
     */
    //ADMIN
    public function testManuscriptRePortYear1()
    {
        $user = User::where('actor_no',ADMIN)->first();
        $this->be($user);
        $uersRepo     = new EloquentUserRepository($user);
        $this->repo   = new EloquentManuscriptRepository(new Manuscript, new EditorManuscript, $uersRepo);
        $start = date("d/m/Y",time());
        $result = $this->repo->getDataReport($start, null, REPORT_PUBLISH_IN_YEAR);
        
        $this->assertEquals($start, $result['end']);
    }
    //AUTHOR
    public function testManuscriptRePortYear2()
    {
        $user = User::where('actor_no',AUTHOR)->first();
        $this->be($user);
        $uersRepo     = new EloquentUserRepository($user);
        $this->repo   = new EloquentManuscriptRepository(new Manuscript, new EditorManuscript, $uersRepo);
        $start = date("d/m/Y",time());
        $result = $this->repo->getDataReport($start, null, REPORT_PUBLISH_IN_YEAR);
        
        $this->assertEquals($start, $result['end']);
    }
    //MANAGING_EDITOR
    public function testManuscriptRePortYear3()
    {
        $user = User::where('actor_no',MANAGING_EDITOR)->first();
        $this->be($user);
        $uersRepo     = new EloquentUserRepository($user);
        $this->repo   = new EloquentManuscriptRepository(new Manuscript, new EditorManuscript, $uersRepo);
        $start = date("d/m/Y",time());
        $result = $this->repo->getDataReport($start, null, REPORT_PUBLISH_IN_YEAR);
        
        $this->assertEquals($start, $result['end']);
    }
    //SCREENING_EDITOR
    public function testManuscriptRePortYear4()
    {
        $user = User::where('actor_no',SCREENING_EDITOR)->first();
        $this->be($user);
        $uersRepo     = new EloquentUserRepository($user);
        $this->repo   = new EloquentManuscriptRepository(new Manuscript, new EditorManuscript, $uersRepo);
        $start = date("d/m/Y",time());
        $result = $this->repo->getDataReport($start, null, REPORT_PUBLISH_IN_YEAR);
        
        $this->assertEquals($start, $result['end']);
    }
    //SECTION_EDITOR
    public function testManuscriptRePortYear5()
    {
        $user = User::where('actor_no',SECTION_EDITOR)->first();
        $this->be($user);
        $uersRepo     = new EloquentUserRepository($user);
        $this->repo   = new EloquentManuscriptRepository(new Manuscript, new EditorManuscript, $uersRepo);
        $start = date("d/m/Y",time());
        $result = $this->repo->getDataReport($start, null, REPORT_PUBLISH_IN_YEAR);
        
        $this->assertEquals($start, $result['end']);
    }
    //REVIEWER
    public function testManuscriptRePortYear6()
    {
        $user = User::where('actor_no',REVIEWER)->first();
        $this->be($user);
        $uersRepo     = new EloquentUserRepository($user);
        $this->repo   = new EloquentManuscriptRepository(new Manuscript, new EditorManuscript, $uersRepo);
        $start = date("d/m/Y",time());
        $result = $this->repo->getDataReport($start, null, REPORT_PUBLISH_IN_YEAR);
        
        $this->assertEquals($start, $result['end']);
    }
    //CHIEF_EDITOR
    public function testManuscriptRePortYear7()
    {
        $user = User::where('actor_no',CHIEF_EDITOR)->first();
        $this->be($user);
        $uersRepo     = new EloquentUserRepository($user);
        $this->repo   = new EloquentManuscriptRepository(new Manuscript, new EditorManuscript, $uersRepo);
        $start = date("d/m/Y",time());
        $result = $this->repo->getDataReport($start, null, REPORT_PUBLISH_IN_YEAR);
        
        $this->assertEquals($start, $result['end']);
    }
    //COPY_EDITOR
    public function testManuscriptRePortYear8()
    {
        $user = User::where('actor_no',COPY_EDITOR)->first();
        $this->be($user);
        $uersRepo     = new EloquentUserRepository($user);
        $this->repo   = new EloquentManuscriptRepository(new Manuscript, new EditorManuscript, $uersRepo);
        $start = date("d/m/Y",time());
        $result = $this->repo->getDataReport($start, null, REPORT_PUBLISH_IN_YEAR);
        
        $this->assertEquals($start, $result['end']);
    }
    //LAYOUT_EDITOR
    public function testManuscriptRePortYear9()
    {
        $user = User::where('actor_no',LAYOUT_EDITOR)->first();
        $this->be($user);
        $uersRepo     = new EloquentUserRepository($user);
        $this->repo   = new EloquentManuscriptRepository(new Manuscript, new EditorManuscript, $uersRepo);
        $start = date("d/m/Y",time());
        $result = $this->repo->getDataReport($start, null, REPORT_PUBLISH_IN_YEAR);
        
        $this->assertEquals($start, $result['end']);
    }
    //PRODUCTION_EDITOR
    public function testManuscriptRePortYear10()
    {
        $user = User::where('actor_no',PRODUCTION_EDITOR)->first();
        $this->be($user);
        $uersRepo     = new EloquentUserRepository($user);
        $this->repo   = new EloquentManuscriptRepository(new Manuscript, new EditorManuscript, $uersRepo);
        $start = date("d/m/Y",time());
        $result = $this->repo->getDataReport($start, null, REPORT_PUBLISH_IN_YEAR);
        
        $this->assertEquals($start, $result['end']);
    }
    
}