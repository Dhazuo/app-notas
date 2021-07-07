<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;
use App\Models\User;
use Illuminate\Http\Request;
class MainIndexController extends Controller
{
    public function main_index()
    {
        if (Auth::check()) {
            return redirect()->route('notes.index');
        } else {
            return Inertia::render('Index');
        }
    }

    public function login(LoginRequest $request)
    {
        $request->all();

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended(route('notes.index'));
        }

        return response('Invalid data', 401);
    }

}
