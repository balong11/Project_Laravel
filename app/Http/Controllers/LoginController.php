<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function login(){
        return view('login.index');
    }

    public function loginCheck(Request $request){
        $valib = [
            'email'           => 'required|max:55|email',
            'password'        => 'required|string|min:8',
        ];

        $mess = [
            'email.required'                => 'Trương email không được bỏ trống !',
            'email.max'                     => 'Trương email chỉ được nhập tối đa 10 ký tự !',
            'email.email'                   => 'Email không đúng định dạng !',
            'password.required'             => 'trường password không được bỏ trống',
            'paswsword.min'                 => 'mật khẩu phải từ 8 ký tự trở lên',
        ];

        $this->validate($request, $valib,$mess);

        $credentials = $request->only('email','password');
        if(Auth::attempt($credentials)){
            if(Auth::user()->role=='admin') 
            return redirect()->route('admin.home');
        }
        else {
            return redirect()->route('login')->withErrors('Email address or password is incorrect!');
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }

    public function admin(){
        return view('Admin.home');
    }

    public function RegisterUser(){
        return view('login.register');
    }
    public function register(Request $request){
        $validate = [
            'name'               => 'required|max:20|min:3|',
            'surname'            => 'required|max:10',
            'email'              => 'required|max:55|email',
            'password'           => 'required|min:8',
            'retypepassword'     => 'required|same:password|min:8',
        ];

        $messenger = [
            'name.required'                 => 'trường name không được bỏ trống',
            'name.max'                      => 'trường name nhập tối đa 20 ký tự',
            'name.min'                      => 'trường name nhập ít nhất 3 ký tự',
            'surname.required'              => 'trường họ không được bỏ trống',
            'surname.max'                   => 'trường họ tối da nhập 10 ký tự',
            'email.required'                => 'trường email không được để trống',
            'email.max'                     => 'trường email chỉ được nhập tối đa 55 ký tự',
            'email.email'                   => 'email không đúng định dạng',
            'password.required'             => 'trường password không được bỏ trống',
            'paswsword.min'                 => 'mật khẩu phải từ 8 ký tự trở lên',
            'retypepassword.required'       => 'vui lòng mật khẩu',
            'retypepassword.same'           => 'xác nhận mật khẩu sai',

        ];
        $this->validate($request, $validate,$messenger);

        $email = User::where('email','=',$request->email)->first();
        if(true){ //$request->role=='user'
            if ($email==null) {
                $user = new User();
                $user->name = $request->name;
                $user->surname = $request->surname;
                $user->email = $request->email;
                $user->role = 'admin';
                $user->password = Hash::make($request->password);
                $user->save();
            }
            else{
                return redirect()->route('register.user')->withErrors('This email is registered. Please enter another email address.');
            }
        }
        return redirect()->route('login');
    }
    public function home(){
        dd(1);
    }
}
