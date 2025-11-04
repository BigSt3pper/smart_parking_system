<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Use Hamza's User table (PascalCase)
        $credentials = $request->only('email', 'password');
        
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            // Check if user is admin
            if (Auth::user()->role === 'Admin') {
                return redirect()->intended('/admin/dashboard');
            }
            
            // If not admin, logout and show error
            Auth::logout();
            throw ValidationException::withMessages([
                'email' => 'Admin access required.',
            ]);
        }

        throw ValidationException::withMessages([
            'email' => 'Invalid credentials.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/admin/login');
    }
}
