<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

/**
 * Class AuthController
 *
 * Handles user authentication and registration.
 */
class AuthController extends Controller
{
    /**
     * Register a new user.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response()->json(['user' => $user], 201);
    }

    /**
     * Log in a user and return an authentication token.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function loginApi(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json(['token' => $token], 200);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        Auth::login($user);
        return response()->redirectTo(route('tasks.tasks'));
    }

    /**
     * Log out the authenticated user.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        if (auth('web')->check()) {
            auth('web')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect()->route('auth.login');
        } elseif ($request->user()) {
            $request->user()->currentAccessToken()->delete();
            return response()->json(['message' => 'Logged out'], 200);
        }

        return response()->json(['message' => 'Not authenticated'], 401);
    }

    /**
     * Log out the authenticated user via API.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logoutApi(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logged out'], 200);
    }

    /**
     * Show the login view.
     *
     * @return \Illuminate\View\View
     */
    public function showLogin()
    {
        return view('auth.login');
    }

    /**
     * Show the register view.
     *
     * @return \Illuminate\View\View
     */
    public function showRegister()
    {
        return view('auth.register');
    }
}
