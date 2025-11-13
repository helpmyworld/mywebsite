<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\User; // or App\Models\User

class CustomRegisterController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
    }

    // ----- Customers -----
    public function showCustomerForm()
    {
        return view('auth.register_customer');
    }

    public function registerCustomer(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = new User();
        $user->name     = $request->name;
        $user->email    = $request->email;
        $user->password = Hash::make($request->password);
        $user->role     = 'customer';
        $user->save();

        Auth::login($user);

        return redirect('/'); // or account page
    }

    // ----- Authors -----
    public function showAuthorForm()
    {
        return view('auth.register_author');
    }

    public function registerAuthor(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'g-recaptcha-response' => 'required|captcha',
        ]);

        $user = new User();
        $user->name     = $request->name;
        $user->email    = $request->email;
        $user->password = Hash::make($request->password);
        $user->role     = 'author';
        $user->save();

        Auth::login($user);

        return redirect()->route('author.dashboard');
    }
}
