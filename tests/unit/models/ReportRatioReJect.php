<?php

use App\User;
use App\Manuscript;
 use App\EditorManuscript;
use App\Lib\Prototype\Interfaces\ReportInterface;
use App\Lib\Prototype\DBClasses\Eloquent\EloquentUserRepository;
use App\Lib\Prototype\DBClasses\Eloquent\EloquentReportRepository;
use App\Lib\Prototype\DbClasses\Eloquent\EloquentManuscriptRepository;
use App\Lib\Prototype\DbClasses\Eloquent\EloquentEditorManuscriptRepository;

class ReportRatioReject extends TestCase {
	/**
	 * A basic functional test example.
	 *
	 * @return void
	 */
	protected $repo;
	// protected $auth;



	public function testManuscriptReportWithDraw()
    {
        $user = User::where(['actor_no'=>AUTHOR,'id'=>5],'=')->first();
        $this->be($user);
        $uersRepo     = new EloquentUserRepository($user);
        $this->repo  = new EloquentReportRepository(new Manuscript, $uersRepo);
        $start = date("d/m/Y",time());
        $end = date("d/m/Y",strtotime('-4 month'));
       
        $result = $this->repo->getDataReport($end , $start, REPORT_REJECTED);
        $this->assertEquals($end, $result['start']);
        $this->assertEquals($start, $result['end']);
    }
    /**
     * admin/manuscript/published
     */
    public function testManuscriptPublished()
    {
        $user = User::where(['actor_no'=>AUTHOR,'id'=>2],'=')->first();
        $this->be($user);
        $uersRepo               = new EloquentUserRepository($user);
        $EditorManuscript       = new EloquentEditorManuscriptRepository(new EditorManuscript);
        $this->repo   = new EloquentManuscriptRepository(new Manuscript, $EditorManuscript , $uersRepo);
       
        $result = $this->repo->getColumnTable(PUBLISHED, AUTHOR);
       
        $mnid = $result['data']->first()->id;
        $manuid = DB::table('manuscripts')->where('id',$mnid)->first();

        $this->assertEquals($manuid->status, PUBLISHED);
    }

    /**
     * admin/manuscript/rejected-review
     */
    public function testManuscriptRejectedReview()
    {
        $user = User::where('actor_no',REVIEWER)->first(); 
        $this->be($user);
        $uersRepo               = new EloquentUserRepository($user);
        $EditorManuscript       = new EloquentEditorManuscriptRepository(new EditorManuscript);
        $this->repo   = new EloquentManuscriptRepository(new Manuscript, $EditorManuscript , $uersRepo);
       
        $result = $this->repo->getColumnTable(REJECTED_REVIEW, REVIEWER, REJECTED_REVIEW);
       
        $mnid = $result['data']->first()->id;
        $manuid = DB::table('manuscripts')->where('id',$mnid)->first();

       // $this->assertEquals($manuid->status, REVIEWER);
        $this->assertEquals($manuid->reject_reviewer_ids, $user->id);
    }

    /**
     * admin/manuscript/all
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
    public function testManuscriptAll()
    {
        $user = User::where('actor_no',AUTHOR)->first(); 
        $this->be($user);
        $uersRepo               = new EloquentUserRepository($user);
        $EditorManuscript       = new EloquentEditorManuscriptRepository(new EditorManuscript);
        $this->repo   = new EloquentManuscriptRepository(new Manuscript, $EditorManuscript , $uersRepo);
       
        $result = $this->repo->getByStatus(ALL);
       
        $manuid = DB::table('manuscripts')->where( ['author_id'=>$user->id] , '=' )->count('id');
        
        $this->assertEquals($manuid, $result['data']->count());
    }
}

