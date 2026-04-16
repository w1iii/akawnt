<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\AdminWhitelist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function showAdminLogin()
    {
        return view('auth.admin-login');
    }

    public function showApplicantLogin()
    {
        return view('auth.applicant-login');
    }

    public function showAdminRegister()
    {
        return view('auth.admin-register');
    }

    public function adminLogin(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::guard('admin')->attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->route('admin.dashboard');
        }

        throw ValidationException::withMessages([
            'email' => __('auth.failed'),
        ]);
    }

    public function applicantLogin(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt([
            'email' => $credentials['email'],
            'password' => $credentials['password'],
            'role' => 'accountant',
        ])) {
            $request->session()->regenerate();

            return redirect()->route('applicant.dashboard');
        }

        throw ValidationException::withMessages([
            'email' => __('auth.failed'),
        ]);
    }

    public function adminRegister(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:admins',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $whitelisted = AdminWhitelist::where('email', $request->email)->exists();

        if (! $whitelisted) {
            throw ValidationException::withMessages([
                'email' => 'This email is not authorized to register as an admin.',
            ]);
        }

        $admin = Admin::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::guard('admin')->login($admin);

        return redirect()->route('admin.dashboard');
    }

    public function logout(Request $request)
    {
        $guard = Auth::guard('admin')->check() ? 'admin' : null;

        if ($guard === 'admin') {
            Auth::guard('admin')->logout();
        } else {
            Auth::logout();
        }

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        if ($guard === 'admin') {
            return redirect()->route('admin.login');
        }

        return redirect()->route('login');
    }
}
