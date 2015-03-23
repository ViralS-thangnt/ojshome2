<?php

use App\User;

class ManuScriptsControllerTest extends TestCase {
 
protected $manuMock;

public function setUp()
	{
		parent::setUp();

		$this->mock = Mockery::mock('App\Lib\Prototype\DBClasses\Eloquent\EloquentManuscriptRepository');
		$this->app->instance('App\Lib\Prototype\DBClasses\Eloquent\EloquentManuscriptRepository' , $this->mock);
		dd($this->mock);
	}

  	public function tearDown()
	{
		Mockery::close();
	}

	public function testShowManuscriptInReview(){
		// // authenticate
		// $user = new User(['email' => 'toanthang1988@gmail.com']);
		// $this->be($user);

		// $this->mock->shouldReceive('form')
		// 			->once();
		// 			// ->andReturn(array());

		// $this->call('get', '/admin');
  //       $this->assertViewHas('/admin');

	}


	// public function testCreateManuscript(){

	// }

	public function testShowManuscriptInScreening(){
		// authenticate
		$user = new User(['email' => 'toanthang1988@gmail.com']);
		$this->be($user);

		$this->mock->shouldReceive('inScreening')
					->once()
					// ->andReturn(array())
					;

		// $this->call('GET', 'manuscripts.manuscript');

		// $this->assertViewHas('result');
		// $this->assertViewHas('permissions');

		$this->call('GET', 'manuscripts.permission_denied');

		$this->assertViewHas('message');
		$this->assertViewHas('permissions');
		$this->assertTrue(true);

		//$posts = $response->original->getData()['result'];

	}
}








