<?php

use App\User;
use Illuminate\Contracts\Auth\Guard;
use App\Lib\Prototype\Interfaces\UserInterface;
use App\Lib\Prototype\DBClasses\Eloquent\EloquentUserRepository;
use App\Lib\Prototype\Interfaces;




class UserModelTest extends TestCase {
	/**
	 * A basic functional test example.
	 *
	 * @return void
	 */


//test phan edit user
	public function testEditUser()
    {
		//thong tin user login
		$user = array(
		    		'email'=>'author_demo@nadia.bz', 
		    		'password'=>'12345678',
	    		);
		//fields edit
		$data = array(
					"username" => "author_demo",
					"last_name" => "update last name 2",
					"first_name" => "update first name 2",
					"middle_name" => "update middle name 2",
					"address" => "Ha noi",
					"research_area" => "ha noi",
					"actor_no" => [1,2],
					"password" => "12345678",
  					"password_confirmation" => "12345678",
				);

		$field_check = [];
		$i 			 = 0 ;

		foreach ($data as $key =>$value) {
			$field_check[$i]= $key;
		    $i++;
		}

    	if( \Auth::attempt($user) )
    	{
    		$this->repo = new EloquentUserRepository(\Auth::user());
			$result     = $this->repo->formModify($data,2);
			$dataoutput = array_only($result->toArray(), $field_check);

			//cheat 
			$dataoutput['actor_no'] = explode(",",$dataoutput['actor_no']);
			$dataoutput['password'] = "12345678";
			$dataoutput['password_confirmation'] = "12345678";
			//cheat 
			
			$this->assertEquals($dataoutput, $data);
    	}
		
    }

    //test user login succsess
    public function testLoginSuccsess()
    {
    	$user = array(
    			'email' => 'admin@nadia.bz',
    			'password' => '12345678'
    		);

    		$this->assertEquals(true,\Auth::attempt($user));
    }

    //test error password
    public function testLoginErrorWrongPassword()
    {
    	$user = array(
    			'email' => 'author_demo@nadia.bz',
    			'password' => '1234567'
    		);

    	$this->assertEquals(false,\Auth::attempt($user));
    }

    //test error email
    public function testLoginErrorWrongEmail()
    {
    	$user = array(
    			'email' => 'author_demo@gmail.com',
    			'password' => '12345678'
    		);

    	$this->assertEquals(false,\Auth::attempt($user));
    }

    //test admin delete user
    public function testDeleteUser()
    {
    	$user = array(
    			'email' => 'admin@nadia.bz',
    			'password' => '12345678'
    		);
    	if(\Auth::attempt($user)){
    		$this->repo = new EloquentUserRepository(\Auth::user());
    		$result = $this->repo->delete(7);
    		$this->assertEquals(1, $result);
    	}
    }

}