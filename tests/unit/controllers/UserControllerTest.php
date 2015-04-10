<?php
use App\User;
use App\Lib\Prototype\Interfaces\UserInterface;
class UserControllerTest extends TestCase {
 
    protected $mock;

    public function setUp()
    {
        parent::setUp();
        /*$this->mock = Mockery::mock('App\Lib\Prototype\Interfaces\UserInterface');
        $this->app->instance('App\Lib\Prototype\Interfaces\UserInterface', $this->mock);*/
        $this->mock = \Mockery::mock('App\Lib\Prototype\Interfaces\UserInterface')->makePartial();
        $user = User::find(1);
        $this->be($user);
    }

    public function tearDown()
    {
          Mockery::close();
    }

    public function testUserIndex()
    {
        $this->mock
           ->shouldReceive('all')
           ->andReturn(array());
        $this->call('get', 'admin/user');
        /*dd(
            $this->mock
           ->shouldReceive('all')
           ->once()
          );*/
        //$this->assertResponseOk();
         $this->assertViewHas('users');
    }

    /*public function testUserForm()
    {
        $this->mock
           ->shouldReceive('getById')
           ->once()
           ->andReturn(array());
        $this->call('get', 'admin/user/form/8');
        $this->assertResponseOk();
    }

    public function testDeleteUser()
    {
      
        $this->mock
           ->shouldReceive('delete')
           ->once();
        $this->call('get','admin/user/8');
    }*/
}
