<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class PetugasPeralatanLoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest:petugas_peralatan', ['except' => ['logout']]);
    }

    public function showLoginForm()
    {
        return view('auth.petugas_peralatan_login');
    }

    public function login(Request $request)
    {
        // Validate the form data
        $this->validate($request, [
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        // Attempt to log the user in
        if (Auth::guard('petugas_peralatan')->attempt(['username' => $request->input('username'), 'password' => $request->input('password')])) {
            // if successful, then redirect to their intended location
            return redirect()->intended(route('petugas_peralatan.dashboard'));
        } else {
            return redirect()->back()
            ->with('error_message', 'Username atau password salah!');
        }
    }

    public function logout()
    {
        Auth::guard('petugas_peralatan')->logout();
        return redirect()->route('petugas_peralatan.login');
    }
}
