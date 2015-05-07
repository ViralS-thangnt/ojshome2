<?php


use App\User;
use App\Lib\Prototype\Interfaces\ManuscriptInterface;

class ManuScriptReportRatioReJected extends TestCase {

	protected $mock;

	public function setUp()
	{
		parent::setUp();

		$this->mock = \Mockery::mock('App\Lib\Prototype\Interfaces\ManuscriptInterface')->makePartial();
		
	}

  	public function tearDown()
	{
		\Mockery::close();
	}

  
  /**
   * report rejected
   */
  //ADMIN
  //AUTHOR
  
  public function testReject()
  {
    
    $user = User::where('actor_no',AUTHOR)->first(); 
    $this->be($user);
    Session::start(); 

    $this->mock
           ->shouldReceive('showReportRejected')->andReturn();
        $response = $this->call('get', 'admin/report/ratio_rejected');
        
    $this->assertResponseOk();
    $this->assertViewHas('data');
    $this->assertViewHas('url');
    $this->assertViewHas('report');
    $this->assertViewHas('permissions');
  }

  //MANAGING_EDITOR
  //SCREENING_EDITOR
  //SECTION_EDITOR
  //REVIEWER
  //CHIEF_EDITOR
  //COPY_EDITOR
  //LAYOUT_EDITOR
  //PRODUCTION_EDITOR



}