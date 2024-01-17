<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\Enums\ContactType;
use App\Models\Enums\ContactShip;


class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:200',
            'password' => ['required', 'regex:/^(?=.*\d)(?=.*[A-Z]).{1,8}$/'],
        ]);

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }

        $credentials = $request->only('email', 'password');
        $remember = $request->has('remember');

        if (!Auth::attempt($credentials, $remember)) {
            // Authentication failed
            return back()
                ->withErrors(['error' => 'email/passowrd incorrect'])->withInput();
        }

        $user = Auth::user();

        $default_filter = ['type' => ContactType::HOME, 'ship'=>ContactShip::FAM];
        // sey default filter in session
        session(['default_filter' => $default_filter]);

        // pass success
        session()->flash('success', 'Login Succesfull');

        // Authentication passed
        return redirect()->route('get_contacts');
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fname' => 'required|string|max:200|min:5',
            'lname' => 'required|string|max:200|min:5',
            'aka' => 'string|max:200|min:5',
            'email' => 'required|email|unique:users|max:200',
            'age' => 'integer|max:100',
            'address' => 'string|max:500',
            'phone' => ['required', 'regex:/^(80|70|90|71|81|91)\d{8}$/'],
            'password' => [
                'required', 
                'regex:/^(?=.*\d)(?=.*[A-Z]).{1,8}$/'
            ],
            'password_confirmation' => 'required|same:password',
        ]);

        if($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator->errors())
                ->withInput();
        }

        $user = new User();
        $user->fname = $request->fname;
        $user->lname = $request->lname;
        $user->aka = $request->aka;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->age = $request->age;
        $user->address = $request->address;
        $user->setPasswordAttribute($request->password);
        
        // save user
        $user->save();

        $new_user = User::where('email', $request->email)
                        ->first();
        
        // log user in, cause why not
        Auth::login($new_user);

        $default_filter = ['type' => ContactType::HOME, 'ship'=>ContactShip::FAM];
        // sey default filter in session
        session(['default_filter' => $default_filter]);

        // pass success
        session()->flash('success', 'Registration Succesfull');

        // Authentication passed
        return redirect()->route('get_contacts');
    }
}