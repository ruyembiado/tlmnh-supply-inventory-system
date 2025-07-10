<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Carbon\Carbon;
use App\Models\Visitor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function index()
    {
        if (auth()->check()) {
            return redirect('/dashboard');
        }

        return view('welcome');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('username', 'password');
        if (auth()->attempt($credentials)) {
            return redirect('/dashboard')->with('success', 'Login successful');
        }

        return back()->withErrors(['error' => 'The provided credentials do not match our records.']);
    }

    public function dashboard()
    {

        $items = Item::all();

        return view('dashboard', compact('items'));
    }

    public function logout()
    {
        auth()->logout();
        return redirect('/')->with('success', 'Logout successful');
    }
}
