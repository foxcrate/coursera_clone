<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Student;
use App\Models\Admin;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('guest:admin')->except('logout');
        $this->middleware('guest:student')->except('logout');
    }

    public function showAdminLoginForm()
    {
        return view('auth.login', ['url' => 'admin']);
    }

    public function adminLogin(Request $request)
    {
        //return 'alo2';

        $this->validate($request, [
            'email'   => 'required|email',
            'password' => 'required|min:6'
        ]);

        // $the_admin = Admin::where( 'email', $request->email ) -> first();
        //     return $the_admin->password;
        if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password], $request->get('remember'))) {



            // if($request->level == 0){
            //     return redirect()->intended('/admin0');
            // }
            // elseif($request->level == 1){
            //     return redirect()->intended('/admin1');
            // }
            // elseif($request->level == 2){
            //     return redirect()->intended('/admin2');
            // }
            //return "right";
            $the_admin = Admin::where( 'email', $request->email ) -> first();
            session(['loggedID' => $the_admin->id ]);
            session(['loggedName' => $the_admin->name ]);
            session(['loggedType' => 'admin' ]);

            return redirect()->intended('/dashboard');
        }

        return back()->withInput($request->only('email', 'remember'))->with('error', 'You are not registered !');
        //return redirect()->route('admin_login')->withInput($request->only('email', 'remember'))->with(['error'=> 'You are not registered !']);
        //return view('auth.login', ['url' => 'admin'])->with(['error'=> 'You are not registered !']);
    }

    public function showStudentLoginForm()
    {
        return view('auth.login', ['url' => 'student']);
    }

    public function studentLogin(Request $request)
    {

        // Add values to the session.

        $this->validate($request, [
            'email'   => 'required|email',
            'password' => 'required|min:6'
        ]);
        // $the_student = Student::where( 'email', $request->email ) -> first();
        //     return $the_student->password;

        if (Auth::guard('student')->attempt(['email' => $request->email, 'password' => $request->password], $request->get('remember'))) {

            $the_student = Student::where( 'email', $request->email ) -> first();
            //return $the_student;
            session(['loggedID' => $the_student->id ]);
            session(['loggedName' => $the_student->name ]);
            session(['loggedType' => 'student' ]);
            if($the_student->status != 'blocked'){
                return redirect()->intended( route( 'my_courses', $the_student->id ) );
            }else{
                $this->guard()->logout();
                $request->session()->invalidate();

                return back()->with('error', 'You are blocked !');
            }

        }
        return back()->withInput($request->only('email', 'remember'))->with('error', 'You are not registered !');


    }



    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        return $this->loggedOut($request) ?: redirect('/index');
    }


}
