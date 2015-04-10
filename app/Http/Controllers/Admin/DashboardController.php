<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Lib\Prototype\Interfaces\UserInterface;

use Illuminate\Http\Request;
use Session;

class DashboardController extends Controller {

    protected $userRepo;

    public function __construct(UserInterface $userRepo)
    {
        $this->middleware('auth');
        $this->userRepo = $userRepo;
    }

    public function index()
    {
        return view('dashboard.dashboard');
    }

    
    public function userDashboard()
    {
        return view('dashboard.user-dashboard');
    }

    public function setLocale() {
        // TODO check lang is valid or exist
        $lang = $_GET['lang'];

        if($lang != '') {
            \Session::put('lang', $lang);
            \App::setLocale($lang);
            return json_encode($lang);
        }
        return json_encode($lang);
    }

}
