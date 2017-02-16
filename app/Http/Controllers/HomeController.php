<?php

namespace App\Http\Controllers;

use App\Proxy;
use Illuminate\Http\Request;

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

        $proxies = Proxy::paginate(15);

        return view('home', [
            'proxies' => $proxies
        ]);
    }
}
