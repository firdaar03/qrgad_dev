<?php

namespace App\Http\Controllers\Auth\Qrgad;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Table\Qrgad\User;

class LoginController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        //
    }

    public function index(){
        return view("Qrgad/login/index");
    }

    public function authenticate(Request $request){
        $validate = $request->validate([
            'username' => 'required',
            'password' => 'required'

        ]);

        $breadcrumb = [
            "menu" => "Dashboard"
        ];

        if(Auth::attempt($validate)){
            $request->session()->regenerate();
            return redirect()->intended('/dashboard');
        } 
    
        return back()->with('error_msg', 'Login Gagal!');
    }

    public function logout(Request $request){
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect("/");
    }
}
