<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(Request $request): View
    {
        $request->session()->forget('auth.login_context');

        return view('auth.login');
    }

    /**
     * Display the admin login view.
     */
    public function createAdmin(Request $request): View
    {
        $request->session()->put('auth.login_context', 'admin');
        $request->session()->put('url.intended', route('admin.layouts.app', absolute: false));

        return view('auth.admin-login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        $isAdminLogin = $request->session()->pull('auth.login_context') === 'admin';

        if ($isAdminLogin && ! $request->user()?->hasRole('admin')) {
            Auth::guard('web')->logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            throw ValidationException::withMessages([
                'email' => 'У этой учетной записи нет доступа к панели администратора.',
            ]);
        }

        $defaultRoute = $isAdminLogin ? 'admin.layouts.app' : 'dashboard';

        return redirect()->intended(route($defaultRoute, absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
