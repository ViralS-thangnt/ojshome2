<?php

use App\User;
use App\Manuscript;
use App\Lib\Prototype\Interfaces\ReportInterface;
use App\Lib\Prototype\DBClasses\Eloquent\EloquentUserRepository;
use App\Lib\Prototype\DBClasses\Eloquent\EloquentReportRepository;

class ReportReject extends TestCase {


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
     * report journal
     */
    public function testManuscriptReportJournal1()
    {
        $user = User::where(['actor_no'=>AUTHOR,'id'=>5],'=')->first();
        $this->be($user);
        $uersRepo     = new EloquentUserRepository($user);
        $this->repo  = new EloquentReportRepository(new Manuscript, $uersRepo);
        $start = date("d/m/Y",time());
        $end = date("d/m/Y",strtotime('-12 month'));
       
        $result = $this->repo->getDataReport($end , $start, REPORT_JOURNAL_IN_YEAR);
        $this->assertEquals($end, $result['start']);
        $this->assertEquals($start, $result['end']);
    } 

    /**
     * admin/report/review_loop
     */
    public function testManuscriptReportLoop()
    {
        $user = User::where(['actor_no'=>AUTHOR,'id'=>5],'=')->first();
        $this->be($user);
        $uersRepo     = new EloquentUserRepository($user);
        $this->repo  = new EloquentReportRepository(new Manuscript, $uersRepo);
        $start = date("d/m/Y",time());
        $end = date("d/m/Y",strtotime('-12 month'));
       
        $result = $this->repo->getDataReport($end , $start, REPORT_REVIEW_LOOP);
        $this->assertEquals($end, $result['start']);
        $this->assertEquals($start, $result['end']);
    }

    /**
     * admin/report/review_time
     */
     public function testManuscriptReportTime()
    {
        $user = User::where(['actor_no'=>AUTHOR,'id'=>5],'=')->first();
        $this->be($user);
        $uersRepo     = new EloquentUserRepository($user);
        $this->repo  = new EloquentReportRepository(new Manuscript, $uersRepo);
        $start = date("d/m/Y",time());
        $end = date("d/m/Y",strtotime('-12 month'));
       
        $result = $this->repo->getDataReport($end , $start, REPORT_REVIEW_TIME);
        $this->assertEquals($end, $result['start']);
        $this->assertEquals($start, $result['end']);
    }
}