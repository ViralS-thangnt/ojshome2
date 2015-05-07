<?php


use App\User;
use App\Lib\Prototype\Interfaces\ManuscriptInterface;

class ManuScriptReportWithdraw extends TestCase {

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
   * admin/report/withdraw 
   *
   */
  
  //ADMIN
  public function testWithDraw1()
  {
    
    $user = User::where('actor_no',ADMIN)->first(); 
    $this->be($user);
    Session::start(); 

    $this->mock
           ->shouldReceive('withdrawnManuscript')->andReturn();
        $response = $this->call('get', 'admin/report/withdraw');
     $this->assertResponseOk();
    $this->assertViewHas('data');
    $this->assertViewHas('url');
    $this->assertViewHas('report');
    $this->assertViewHas('permissions');   
    
  }
  //AUTHOR
  public function testWithDraw2()
  {
    
    $user = User::where('actor_no',AUTHOR)->first(); 
    $this->be($user);
    Session::start(); 

    $this->mock
           ->shouldReceive('withdrawnManuscript')->andReturn();
        $response = $this->call('get', 'admin/report/withdraw');
    $this->assertResponseStatus(333);    
    
  }
  //MANAGING_EDITOR
  public function testWithDraw3()
  {
    
    $user = User::where('actor_no',MANAGING_EDITOR)->first(); 
    $this->be($user);
    Session::start(); 

    $this->mock
           ->shouldReceive('withdrawnManuscript')->andReturn();
        $response = $this->call('get', 'admin/report/withdraw');
        
    $this->assertResponseStatus(333);
  }
  //SCREENING_EDITOR
  //SECTION_EDITOR
  //REVIEWER
  //CHIEF_EDITOR
  //COPY_EDITOR
  //LAYOUT_EDITOR
  //PRODUCTION_EDITOR


/**
 * /admin/report/submited
 */
  //ADMIN
  public function testReportSubmited()
  {
    
    $user = User::where('actor_no',ADMIN)->first(); 
    $this->be($user);
    Session::start(); 

    $this->mock
         ->shouldReceive('showReportSubmited')->andReturn();
        $response = $this->call('get', 'admin/report/submited');
        
    $this->assertResponseOk();
    $this->assertViewHas('data');
    $this->assertViewHas('url');
    $this->assertViewHas('report');
    $this->assertViewHas('permissions');
  }
  //AUTHOR
  //MANAGING_EDITOR
  //SCREENING_EDITOR
  //SECTION_EDITOR
  //REVIEWER
  //CHIEF_EDITOR
  //COPY_EDITOR
  //LAYOUT_EDITOR
  //PRODUCTION_EDITOR
  

/**
*  admin/manuscript/all
*/
  //ADMIN
  public function testManuscriptAll()
  {
    
    $user = User::where('actor_no',AUTHOR)->first(); 
    $this->be($user);
    Session::start(); 

    $this->mock
         ->shouldReceive('all')->andReturn();
        $response = $this->call('get', 'admin/manuscript/all');
        
    $this->assertResponseOk();
    $this->assertViewHas('result');  
    $this->assertViewHas('permissions');
  }
  //AUTHOR
  //MANAGING_EDITOR
  //SCREENING_EDITOR
  //SECTION_EDITOR
  //REVIEWER
  //CHIEF_EDITOR
  //COPY_EDITOR
  //LAYOUT_EDITOR
  //PRODUCTION_EDITOR
  
}