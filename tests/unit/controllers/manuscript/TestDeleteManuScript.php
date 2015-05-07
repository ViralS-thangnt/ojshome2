<?php


use App\User;
use App\Manuscript;
use App\Lib\Prototype\Interfaces\ManuscriptInterface;
use App\EditorManuscript;
use App\Lib\Prototype\Interfaces\UserInterface as UserReopsitory;

class DeleteManuScript extends TestCase {

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

	public function testDeleteManuScript()
	{
		
		$user = User::where('actor_no',ADMIN)->first(); 
		$this->be($user);
		Session::start(); 

		$this->mock
           ->shouldReceive('all')->andReturn();
        $response = $this->call('get', 'admin/manuscript/get_all');
        $this->assertResponseOk();
		$this->assertViewHas('result');
		$this->assertViewHas('permissions');
	}
	public function testDeleteManuScript()
	{
		$user = User::where('actor_no',ADMIN)->first(); 
		$this->be($user);
		Session::start(); 

		$this->mock
           ->shouldReceive('SoftDeletes')->andReturn();
        $response = $this->call('post', 'admin/manuscript/get_all',40);
        $this->assertRedirectedTo('admin/user');
        $this->assertResponseStatus(302);
	}

	//ADMIN
    public function testCreateUser1()
    {
      $randomString = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 10);
      $user = User::where('actor_no',ADMIN)->first(); 
      $this->be($user);

      Session::start(); 

      $input = [
                '_token' => csrf_token(),                        
                "username" => "Name",
                "email" => $randomString."@gmail.com",
                "degree_id" => "5",
                "academic_id" => "6",
                "password" => "123456789",
                "password_confirmation" => "123456789",
                "actor_no" => [1],
                "last_name" => "Last Name",
                "first_name" => "First Name",
                "middle_name" => "Middle Name",
                "year" => "1987",
                "phone" => "",
                "address" => "",
                "nation" => "",
                "research_area" => "",
                "research" => "",
              ];

        $this->mock
           ->shouldReceive('update')->andReturn();
        $response = $this->call('post', 'admin/user/form',$input);
        $this->assertRedirectedTo('admin/user');
        $this->assertResponseStatus(302);
    }
}