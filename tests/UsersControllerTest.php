<?php
class UsersControllerTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->mock = Mockery::mock('App\Lib\Prototype\DBClasses\Eloquent\EloquentUserRepository');
        $this->app->instance('App\Lib\Prototype\DBClasses\Eloquent\EloquentUserRepository', $this->mock);
    }

    // public function testUserFormCreate()
    // {
    //     $this->call('GET', 'admin/user/form');
    //     $this->assertResponseOk();
    // }

    public function testUserFormEdit()
    {
        $response = $this->call('GET', 'admin/user/form', ['id' => 37]);
        $this->assertViewHas('user');
    }
}
