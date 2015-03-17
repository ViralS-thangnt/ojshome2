<?php

use App\User;

class ManuScriptsControllerTest extends TestCase {
 
protected $manuMock;

public function setUp()
	{
		parent::setUp();

		$this->mock = Mockery::mock('App\Lib\Prototype\DBClasses\Eloquent\EloquentManuscriptRepository');
		$this->app->instance('App\Lib\Prototype\DBClasses\Eloquent\EloquentManuscriptRepository' , $this->mock);
	}

	public function tearDown()
	{
		Mockery::close();
	}

	public function testShowManuscriptUnsubmit(){
		// authenticate
		$user = new User(['email' => 'toanthang1988@gmail.com']);
		$this->be($user);

		// Mock
		$this->mock->shouldReceive('unsubmit')
					->once();
					// ->andReturn(array('manuscripts' => [], 'permissions' => ''));

		$response = $this->call('GET', 'manuscripts/index');
		$this->assertTrue($response->isOk());


		// $this->assertViewHas('manuscripts');
		// $this->assertViewHas('permissions');



	}


	public function testCreateManuscript(){
		

	}
}








