<?php
use App\User;
use App\Lib\Prototype\DBClasses\Eloquent\UserReopsitory;

class UserControllerTestCreateNewUser extends TestCase {
 
    protected $mock;

    public function setUp()
    {
        parent::setUp();
        $this->mock = \Mockery::mock('App\Lib\Prototype\DBClasses\Eloquent\UserReopsitory')->makePartial();
        $user = User::find(1);
        $this->be($user);
    }

    public function tearDown()
    {
          Mockery::close();
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
    //AUTHOR
    public function testCreateUser2()
    {
      $randomString = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 10);
      $user = User::where('actor_no',AUTHOR)->first(); 
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
           ->shouldReceive('update');
        $response = $this->call('post', 'admin/user/form',$input);
        $this->assertRedirectedTo('admin');        
        $this->assertResponseStatus(302);
    }

    //MANAGING_EDITOR
    public function testCreateUser3()
    {
      $randomString = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 10);
      $user = User::where('actor_no',MANAGING_EDITOR)->first(); 
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
           ->shouldReceive('update');
        $response = $this->call('post', 'admin/user/form',$input);
        $this->assertRedirectedTo('admin');        
        $this->assertResponseStatus(302);
    }

    //SCREENING_EDITOR
    public function testCreateUser4()
    {
      $randomString = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 10);
      $user = User::where('actor_no',SCREENING_EDITOR)->first(); 
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
           ->shouldReceive('update');
        $response = $this->call('post', 'admin/user/form',$input);
        $this->assertRedirectedTo('admin');        
        $this->assertResponseStatus(302);
    }

    //SECTION_EDITOR
    public function testCreateUser5()
    {
      $randomString = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 10);
      $user = User::where('actor_no',SECTION_EDITOR)->first(); 
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
           ->shouldReceive('update');
        $response = $this->call('post', 'admin/user/form',$input);
        $this->assertRedirectedTo('admin');        
        $this->assertResponseStatus(302);
    }

    //REVIEWER
    public function testCreateUser6()
    {
      $randomString = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 10);
      $user = User::where('actor_no',REVIEWER)->first(); 
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
           ->shouldReceive('update');
        $response = $this->call('post', 'admin/user/form',$input);
        $this->assertRedirectedTo('admin');        
        $this->assertResponseStatus(302);
    }

    //CHIEF_EDITOR
    public function testCreateUser7()
    {
      $randomString = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 10);
      $user = User::where('actor_no',CHIEF_EDITOR)->first(); 
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
           ->shouldReceive('update');
        $response = $this->call('post', 'admin/user/form',$input);
        $this->assertRedirectedTo('admin');        
        $this->assertResponseStatus(302);
    }

    //COPY_EDITOR
    public function testCreateUser8()
    {
      $randomString = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 10);
      $user = User::where('actor_no',COPY_EDITOR)->first(); 
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
           ->shouldReceive('update');
        $response = $this->call('post', 'admin/user/form',$input);
        $this->assertRedirectedTo('admin');        
        $this->assertResponseStatus(302);
    }

    //LAYOUT_EDITOR
    public function testCreateUser9()
    {
      $randomString = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 10);
      $user = User::where('actor_no',LAYOUT_EDITOR)->first(); 
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
           ->shouldReceive('update');
        $response = $this->call('post', 'admin/user/form',$input);
        $this->assertRedirectedTo('admin');        
        $this->assertResponseStatus(302);
    }

    //PRODUCTION_EDITOR
    public function testCreateUser10()
    {
      $randomString = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 10);
      $user = User::where('actor_no',PRODUCTION_EDITOR)->first(); 
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
           ->shouldReceive('update')
           ->andReturn(true);
        $response = $this->call('post', 'admin/user/form',$input);

        $this->assertRedirectedTo('admin');        
        $this->assertResponseStatus(302);
    }


    
     //ADMIN
    public function testCreateUser11()
    {
      $randomString = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 10);
      $user = User::where('actor_no',ADMIN)->first(); 
      $this->be($user);
      Session::start(); 

      $input = [
                '_token' => csrf_token(),                        
                "username" => "Name!@#$%^&*()?",
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
                "phone" => "!@#$%^&*()?",
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
