<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Lib\Prototype\DbClasses\Eloquent\EloquentUserRepository;

use Illuminate\Http\Request;
use Session;

class DashboardController extends Controller {

    protected $userRepo;

    public function __construct(EloquentUserRepository $userRepo)
    {
        $this->middleware('auth');
        $this->userRepo = $userRepo;
    }

    public function index()
    {
        $permissions = $this->userRepo->getPermission();
        
        return view('dashboard.dashboard')->with('permissions', $permissions);
    }

    
    public function userDashboard()
    {
        $permissions = $this->userRepo->getPermission();

        return view('dashboard.user-dashboard')->with('permissions', $permissions);
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
