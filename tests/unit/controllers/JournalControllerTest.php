<?php


use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\JournalRequest;
use Illuminate\Support\Facades\Session;
use App\Lib\Prototype\Interfaces\JournalInterface;

use App\User;

use Illuminate\Http\Request;


class JournalsControllerTest extends TestCase {

	protected $mock;

	public function setUp()
	{
		parent::setUp();

		$this->mock = \Mockery::mock('App\Lib\Prototype\Interfaces\JournalInterface')->makePartial();
		
	}

  	public function tearDown()
	{
		\Mockery::close();
	}


	/**
	 * test index function  
	 */
	
	//ADMIN
	public function testIndex1()
	{
		
		$user = User::where('actor_no',ADMIN)->first(); 
		$this->be($user);
		Session::start(); 

		$this->mock
           ->shouldReceive('index')->andReturn();
        $response = $this->call('get', 'admin/journal');
        $this->assertResponseOk();
		$this->assertViewHas('message');
	}
	//AUTHOR
	public function testIndex2()
	{
		
		$user = User::where('actor_no',AUTHOR)->first(); 
		$this->be($user);
		Session::start(); 

		$this->mock
           ->shouldReceive('index')->andReturn();
        $response = $this->call('get', 'admin/journal');
        $this->assertResponseOk();
		$this->assertViewHas('message');
	}
	//MANAGING_EDITOR
	public function testIndex3()
	{
		
		$user = User::where('actor_no',MANAGING_EDITOR)->first(); 
		$this->be($user);
		Session::start(); 

		$this->mock
           ->shouldReceive('index')->andReturn();
        $response = $this->call('get', 'admin/journal');
        $this->assertResponseOk();
		$this->assertViewHas('message');
	}
	//SCREENING_EDITOR
	public function testIndex4()
	{
		
		$user = User::where('actor_no',SCREENING_EDITOR)->first(); 
		$this->be($user);
		Session::start(); 

		$this->mock
           ->shouldReceive('index')->andReturn();
        $response = $this->call('get', 'admin/journal');
        $this->assertResponseOk();
		$this->assertViewHas('message');
	}
	//SECTION_EDITOR
	public function testIndex5()
	{
		
		$user = User::where('actor_no',SECTION_EDITOR)->first(); 
		$this->be($user);
		Session::start(); 

		$this->mock
           ->shouldReceive('index')->andReturn();
        $response = $this->call('get', 'admin/journal');
        $this->assertResponseOk();
		$this->assertViewHas('message');
	}
	//REVIEWER
	public function testIndex6()
	{
		
		$user = User::where('actor_no',REVIEWER)->first(); 
		$this->be($user);
		Session::start(); 

		$this->mock
           ->shouldReceive('index')->andReturn();
        $response = $this->call('get', 'admin/journal');
        $this->assertResponseOk();
		$this->assertViewHas('message');
	}
	//CHIEF_EDITOR
	public function testIndex7()
	{
		
		$user = User::where('actor_no',CHIEF_EDITOR)->first(); 
		$this->be($user);
		Session::start(); 

		$this->mock
           ->shouldReceive('index')->andReturn();
        $response = $this->call('get', 'admin/journal');
        $this->assertResponseOk();
		$this->assertViewHas('journals');
	}
	//COPY_EDITOR
	public function testIndex8()
	{
		
		$user = User::where('actor_no',COPY_EDITOR)->first(); 
		$this->be($user);
		Session::start(); 

		$this->mock
           ->shouldReceive('index')->andReturn();
        $response = $this->call('get', 'admin/journal');
        $this->assertResponseOk();
		$this->assertViewHas('message');
	}
	//LAYOUT_EDITOR
	public function testIndex9()
	{
		
		$user = User::where('actor_no',LAYOUT_EDITOR)->first(); 
		$this->be($user);
		Session::start(); 

		$this->mock
           ->shouldReceive('index')->andReturn();
        $response = $this->call('get', 'admin/journal');
        $this->assertResponseOk();
		$this->assertViewHas('message');
	}
	//PRODUCTION_EDITOR
	public function testIndex10()
	{
		
		$user = User::where('actor_no',PRODUCTION_EDITOR)->first(); 
		$this->be($user);
		Session::start(); 

		$this->mock
           ->shouldReceive('index')->andReturn();
        $response = $this->call('get', 'admin/journal');
        $this->assertResponseOk();
		$this->assertViewHas('message');
	}

	/**
	 * test function unpublish
	 */
	
	//ADMIN
	public function testUnpublish1()
	{
		
		$user = User::where('actor_no',ADMIN)->first(); 
		$this->be($user);
		Session::start(); 

		$this->mock
           ->shouldReceive('unpublish')->andReturn();
        $response = $this->call('get', 'admin/journal/unpublish');
        $this->assertResponseOk();
		$this->assertViewHas('message');
	}
	//AUTHOR
	public function testUnpublish2()
	{
		
		$user = User::where('actor_no',AUTHOR)->first(); 
		$this->be($user);
		Session::start(); 

		$this->mock
           ->shouldReceive('unpublish')->andReturn();
        $response = $this->call('get', 'admin/journal/unpublish');
        $this->assertResponseOk();
		$this->assertViewHas('message');
	}
	//MANAGING_EDITOR
	public function testUnpublish3()
	{
		
		$user = User::where('actor_no',MANAGING_EDITOR)->first(); 
		$this->be($user);
		Session::start(); 

		$this->mock
           ->shouldReceive('unpublish')->andReturn();
        $response = $this->call('get', 'admin/journal/unpublish');
        $this->assertResponseOk();
		$this->assertViewHas('message');
	}
	//SCREENING_EDITOR
	public function testUnpublish4()
	{
		
		$user = User::where('actor_no',SCREENING_EDITOR)->first(); 
		$this->be($user);
		Session::start(); 

		$this->mock
           ->shouldReceive('unpublish')->andReturn();
        $response = $this->call('get', 'admin/journal/unpublish');
        $this->assertResponseOk();
		$this->assertViewHas('message');
	}
	//SECTION_EDITOR
	public function testUnpublish5()
	{
		
		$user = User::where('actor_no',SECTION_EDITOR)->first(); 
		$this->be($user);
		Session::start(); 

		$this->mock
           ->shouldReceive('unpublish')->andReturn();
        $response = $this->call('get', 'admin/journal/unpublish');
        $this->assertResponseOk();
		$this->assertViewHas('message');
	}
	//REVIEWER
	public function testUnpublish6()
	{
		
		$user = User::where('actor_no',REVIEWER)->first(); 
		$this->be($user);
		Session::start(); 

		$this->mock
           ->shouldReceive('unpublish')->andReturn();
        $response = $this->call('get', 'admin/journal/unpublish');
        $this->assertResponseOk();
		$this->assertViewHas('message');
	}
	//CHIEF_EDITOR
	public function testUnpublish7()
	{
		
		$user = User::where('actor_no',CHIEF_EDITOR)->first(); 
		$this->be($user);
		Session::start(); 

		$this->mock
           ->shouldReceive('unpublish')->andReturn();
        $response = $this->call('get', 'admin/journal/unpublish');
        $this->assertResponseOk();
		$this->assertViewHas('journals');
	}
	//COPY_EDITOR
	public function testUnpublish8()
	{
		
		$user = User::where('actor_no',COPY_EDITOR)->first(); 
		$this->be($user);
		Session::start(); 

		$this->mock
           ->shouldReceive('unpublish')->andReturn();
        $response = $this->call('get', 'admin/journal/unpublish');
        $this->assertResponseOk();
		$this->assertViewHas('message');
	}
	//LAYOUT_EDITOR
	public function testUnpublish9()
	{
		
		$user = User::where('actor_no',LAYOUT_EDITOR)->first(); 
		$this->be($user);
		Session::start(); 

		$this->mock
           ->shouldReceive('unpublish')->andReturn();
        $response = $this->call('get', 'admin/journal/unpublish');
        $this->assertResponseOk();
		$this->assertViewHas('message');
	}
	//PRODUCTION_EDITOR
	public function testUnpublish10()
	{
		
		$user = User::where('actor_no',PRODUCTION_EDITOR)->first(); 
		$this->be($user);
		Session::start(); 

		$this->mock
           ->shouldReceive('unpublish')->andReturn();
        $response = $this->call('get', 'admin/journal/unpublish');
        $this->assertResponseOk();
		$this->assertViewHas('message');
	}


	/**
	 * test function published
	 */
	//ADMIN
	public function testPublish1()
	{
		
		$user = User::where('actor_no',ADMIN)->first(); 
		$this->be($user);
		Session::start(); 

		$this->mock
           ->shouldReceive('published')->andReturn();
        $response = $this->call('get', 'admin/journal/published');
        $this->assertResponseOk();
		$this->assertViewHas('message');
	}
	//AUTHOR
	public function testPublish2()
	{
		
		$user = User::where('actor_no',AUTHOR)->first(); 
		$this->be($user);
		Session::start(); 

		$this->mock
           ->shouldReceive('published')->andReturn();
        $response = $this->call('get', 'admin/journal/published');
        $this->assertResponseOk();
		$this->assertViewHas('message');
	}
	//MANAGING_EDITOR
	public function testPublish3()
	{
		
		$user = User::where('actor_no',MANAGING_EDITOR)->first(); 
		$this->be($user);
		Session::start(); 

		$this->mock
           ->shouldReceive('published')->andReturn();
        $response = $this->call('get', 'admin/journal/published');
        $this->assertResponseOk();
		$this->assertViewHas('message');
	}
	//SCREENING_EDITOR
	public function testPublish4()
	{
		
		$user = User::where('actor_no',SCREENING_EDITOR)->first(); 
		$this->be($user);
		Session::start(); 

		$this->mock
           ->shouldReceive('published')->andReturn();
        $response = $this->call('get', 'admin/journal/published');
        $this->assertResponseOk();
		$this->assertViewHas('message');
	}
	//SECTION_EDITOR
	public function testPublish5()
	{
		
		$user = User::where('actor_no',SECTION_EDITOR)->first(); 
		$this->be($user);
		Session::start(); 

		$this->mock
           ->shouldReceive('published')->andReturn();
        $response = $this->call('get', 'admin/journal/published');
        $this->assertResponseOk();
		$this->assertViewHas('message');
	}
	//REVIEWER
	public function testPublish6()
	{
		
		$user = User::where('actor_no',REVIEWER)->first(); 
		$this->be($user);
		Session::start(); 

		$this->mock
           ->shouldReceive('published')->andReturn();
        $response = $this->call('get', 'admin/journal/published');
        $this->assertResponseOk();
		$this->assertViewHas('message');
	}
	//CHIEF_EDITOR
	public function testPublish7()
	{
		
		$user = User::where('actor_no',CHIEF_EDITOR)->first(); 
		$this->be($user);
		Session::start(); 

		$this->mock
           ->shouldReceive('published')->andReturn();
        $response = $this->call('get', 'admin/journal/published');
        $this->assertResponseOk();
		$this->assertViewHas('journals');
	}
	//COPY_EDITOR
	public function testPublish8()
	{
		
		$user = User::where('actor_no',COPY_EDITOR)->first(); 
		$this->be($user);
		Session::start(); 

		$this->mock
           ->shouldReceive('published')->andReturn();
        $response = $this->call('get', 'admin/journal/published');
        $this->assertResponseOk();
		$this->assertViewHas('message');
	}
	//LAYOUT_EDITOR
	public function testPublish9()
	{
		
		$user = User::where('actor_no',LAYOUT_EDITOR)->first(); 
		$this->be($user);
		Session::start(); 

		$this->mock
           ->shouldReceive('published')->andReturn();
        $response = $this->call('get', 'admin/journal/published');
        $this->assertResponseOk();
		$this->assertViewHas('message');
	}
	//PRODUCTION_EDITOR
	public function testPublish10()
	{
		
		$user = User::where('actor_no',PRODUCTION_EDITOR)->first(); 
		$this->be($user);
		Session::start(); 

		$this->mock
           ->shouldReceive('published')->andReturn();
        $response = $this->call('get', 'admin/journal/published');
        $this->assertResponseOk();
		$this->assertViewHas('message');
	}

	/**
	 *  test function update
	 * 
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
	public function testUpdate()
	{
		
		$user = User::where('actor_no',ADMIN)->first(); 
		$this->be($user);
		Session::start();
		$params =  [
						"num" => "9",
						'_token' => csrf_token(),
				   ];
		$this->mock
           	 ->shouldReceive('update')->andReturn();

        $response = $this->call('POST', 'admin/journal/form/1', $params);
        $this->assertResponseStatus(302);
	}


	/**
	 *  test function form with $id
	 *  
	 */
	
	//ADMIN
	public function testForm1()
	{
		
		$user = User::where('actor_no',ADMIN)->first(); 
		$this->be($user);
		Session::start();
		$this->mock
           	 ->shouldReceive('form')->andReturn();
        $response = $this->call('get', 'admin/journal/form');
        $this->assertResponseOk();
		$this->assertViewHas('message');
	}
	//AUTHOR
	public function testForm2()
	{
		
		$user = User::where('actor_no',AUTHOR)->first(); 
		$this->be($user);
		Session::start();
		$this->mock
           	 ->shouldReceive('form')->andReturn();
        $response = $this->call('get', 'admin/journal/form');
        $this->assertResponseOk();
		$this->assertViewHas('message');
	}
	//MANAGING_EDITOR
	public function testForm3()
	{
		
		$user = User::where('actor_no',MANAGING_EDITOR)->first(); 
		$this->be($user);
		Session::start();
		$this->mock
           	 ->shouldReceive('form')->andReturn();
        $response = $this->call('get', 'admin/journal/form');
        $this->assertResponseOk();
		$this->assertViewHas('message');
	}
	//SCREENING_EDITOR
	public function testForm4()
	{
		
		$user = User::where('actor_no',SCREENING_EDITOR)->first(); 
		$this->be($user);
		Session::start();
		$this->mock
           	 ->shouldReceive('form')->andReturn();
        $response = $this->call('get', 'admin/journal/form');
        $this->assertResponseOk();
		$this->assertViewHas('message');
	}
	//SECTION_EDITOR
	public function testForm5()
	{
		
		$user = User::where('actor_no',SECTION_EDITOR)->first(); 
		$this->be($user);
		Session::start();
		$this->mock
           	 ->shouldReceive('form')->andReturn();
        $response = $this->call('get', 'admin/journal/form');
        $this->assertResponseOk();
		$this->assertViewHas('message');
	}
	//REVIEWER
	public function testForm6()
	{
		
		$user = User::where('actor_no',REVIEWER)->first(); 
		$this->be($user);
		Session::start();
		$this->mock
           	 ->shouldReceive('form')->andReturn();
        $response = $this->call('get', 'admin/journal/form');
        $this->assertResponseOk();
		$this->assertViewHas('message');
	}
	//CHIEF_EDITOR
	public function testForm7()
	{
		
		$user = User::where('actor_no',CHIEF_EDITOR)->first(); 
		$this->be($user);
		Session::start();
		$this->mock
           	 ->shouldReceive('form')->andReturn();
        $response = $this->call('get', 'admin/journal/form');
        $this->assertResponseOk();
		$this->assertViewHas('permissions');
	}
	//COPY_EDITOR
	public function testForm8()
	{
		
		$user = User::where('actor_no',COPY_EDITOR)->first(); 
		$this->be($user);
		Session::start();
		$this->mock
           	 ->shouldReceive('form')->andReturn();
        $response = $this->call('get', 'admin/journal/form');
        $this->assertResponseOk();
		$this->assertViewHas('message');
	}
	//LAYOUT_EDITOR
	public function testForm9()
	{
		
		$user = User::where('actor_no',LAYOUT_EDITOR)->first(); 
		$this->be($user);
		Session::start();
		$this->mock
           	 ->shouldReceive('form')->andReturn();
        $response = $this->call('get', 'admin/journal/form');
        $this->assertResponseOk();
		$this->assertViewHas('message');
	}
	//PRODUCTION_EDITOR
	public function testForm10()
	{
		
		$user = User::where('actor_no',PRODUCTION_EDITOR)->first(); 
		$this->be($user);
		Session::start();
		$this->mock
           	 ->shouldReceive('form')->andReturn();
        $response = $this->call('get', 'admin/journal/form');
        $this->assertResponseOk();
		$this->assertViewHas('message');
	}
	
}