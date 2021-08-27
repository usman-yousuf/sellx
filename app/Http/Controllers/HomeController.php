<?php

namespace App\Http\Controllers;

use App;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('admin.index');
    }

    public function homeindex()
    {
        return view('index');
    }

    public function contactus()
    {

        App::setLocale(Session::get('locale'));

        return view('contact_us');
    }

    public function aboutus()
    {
        App::setLocale(Session::get('locale'));

        return view('about_us');
    }

    public function privacymobpage()
    {
        return view('pages_general.privacy');
    }

    public function termsmobpage()
    {
        return view('pages_general.terms');
    }

    public function partnermobpage()
    {
        return view('pages_general.partner');
    }

    public function refundmobpage()
    {
        return view('pages_general.refund');
    }

    public function change(Request $request)
    {
        App::setLocale($request->lang);
        session()->put('locale', $request->lang);
        
  
        return redirect()->back();
    }
}
