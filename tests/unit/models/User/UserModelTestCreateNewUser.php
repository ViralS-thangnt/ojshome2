<?php

use App\User;
use Illuminate\Contracts\Auth\Guard;
use App\Lib\Prototype\Interfaces\UserInterface;
use App\Lib\Prototype\DBClasses\Eloquent\EloquentUserRepository;
use App\Lib\Prototype\Interfaces;

class UserModelTestCreateNewUser extends TestCase {

	public function testCreateNewUser(){
        $randomString = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 10);
		$input = [                      
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
        $model = new User ;
        $this->repo = new EloquentUserRepository($model);
		$result     = $this->repo->formModify($input);
        dd($result);
		//$dataoutput = array_only($result->toArray(), 'ủ');
}
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

}