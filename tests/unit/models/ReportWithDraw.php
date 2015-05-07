<?php

use App\User;
use App\Manuscript;
use App\Lib\Prototype\Interfaces\ReportInterface;
use App\Lib\Prototype\DBClasses\Eloquent\EloquentUserRepository;
use App\Lib\Prototype\DBClasses\Eloquent\EloquentReportRepository;

class ReportWithDraw extends TestCase {
	/**
	 * A basic functional test example.
	 *
	 * @return void
	 */
	protected $repo;
	// protected $auth;

	public function __construct()
	{
		
	}	

	public function testManuscriptReportWithDraw()
    {
        $user = User::where(['actor_no'=>AUTHOR,'id'=>5],'=')->first();
        $this->be($user);
        $uersRepo     = new EloquentUserRepository($user);
        $this->repo  = new EloquentReportRepository(new Manuscript, $uersRepo);
        $start = date("d/m/Y",time());
        $end = date("d/m/Y",strtotime('-4 month'));
       
        $result = $this->repo->getDataReport($end , $start, REPORT_WITHDRAWN);
        $this->assertEquals($end, $result['start']);
        $this->assertEquals($start, $result['end']);
    }


}