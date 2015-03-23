<?php

class UserControllerTest extends TestCase {
 
protected $mock;

public function setUp()
{
    parent::setUp();

    $this->mock = Mockery::mock('App\Lib\Prototype\DBClasses\Eloquent\EloquentUserRepository');
    $this->app->instance('App\Lib\Prototype\DBClasses\Eloquent\EloquentUserRepository', $this->mock);
}
  public function tearDown()
{
      Mockery::close();
}

    public function testUserIndex()
    {
        $this->mock
           ->shouldReceive('all')
           ->once()
           ->andReturn(array());
        $this->call('get', 'admin/user');
        // $this->assertViewHas('index');
    }

    public function testUserForm()
    {
        $this->mock
           ->shouldReceive('getById')
           ->once()
           ->andReturn(array());
        $this->call('get', 'admin/user/form/1');
    }
}
