<?php

namespace App\Http\Controllers;

use App\Models\AdminWhitelist;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Show admin login form
     */
    public function showAdminLogin()
    {
        return view('auth.admin-login');
    }

    /**
     * Show applicant login form
     */
    public function showApplicantLogin()
    {
        return view('auth.applicant-login');
    }

    /**
     * Show admin registration form
     */
    public function showAdminRegister()
    {
        return view('auth.admin-register');
    }

    /**
     * Handle admin login
     */
    public function adminLogin(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt([
            'email' => $credentials['email'],
            'password' => $credentials['password'],
            'role' => 'admin',
        ])) {
            $request->session()->regenerate();

            return redirect()->route('admin.dashboard');
        }

        throw ValidationException::withMessages([
            'email' => __('auth.failed'),
        ]);
    }

    /**
     * Handle applicant login
     */
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

    /**
     * Handle admin registration
     */
    public function adminRegister(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Check if email is whitelisted
        $whitelisted = AdminWhitelist::where('email', $request->email)->exists();

        if (! $whitelisted) {
            throw ValidationException::withMessages([
                'email' => 'This email is not authorized to register as an admin.',
            ]);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'admin',
        ]);

        Auth::login($user);

        return redirect()->route('admin.dashboard');
    }

    /**
     * Handle logout
     */
    public function logout(Request $request)
    {
        // Get user role before logging out
        $userRole = Auth::user()?->role;

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redirect to appropriate login page based on user role
        if ($userRole === 'admin') {
            return redirect()->route('admin.login');
        }

        return redirect()->route('login');
    }
}
