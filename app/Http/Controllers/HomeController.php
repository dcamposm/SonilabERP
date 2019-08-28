<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $auth = Auth::user();

        if (($auth->hasAnyRole([1, 5]))){
            $user = User::with('missatgeDay')->get();

            return view('home', array('user' => $user));
        }
        
        $user = User::with('missatgeDay')->find($auth->id_usuari);

        return view('home', array('user' => $user));
    }
}
