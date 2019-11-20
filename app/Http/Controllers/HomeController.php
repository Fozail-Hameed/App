<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }
    public function Dashboard(){
        return view('dashboard');
    }
    public function Profile(){
        return view('profile');
    }
    public function LogOut(){
        echo "Fuck you Naik";
        // Auth::logout();
        // return redirect('home');
    }

}
