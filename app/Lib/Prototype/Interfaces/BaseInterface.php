<?php
namespace App\Lib\Prototype\Interfaces;

interface BaseInterface {

    public function all();
    public function getById($id, array $with = array());
    public function getFirstBy($key, $value, array $with = array());
    public function getManyBy($key, $value, array $with = array());
    public function getByPage($page = 1, $limit = 10, $with = array());
    public function has($relation, array $with = array());
    public function create($data);
    public function formModify($data, $id = null);
    public function delete($id);
    public function getPermissions();//get all permissions of current user
    public function getPermission($index = 0); //get one permission of current user
    public function hasPermission($actor_id);//check if current user have a permission
    public function hasPermissions($actor_ids = array());//check if current user have one of some given permission
}
