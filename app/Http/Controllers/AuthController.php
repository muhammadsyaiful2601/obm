<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function index()
    {
        return view('auth.login');
    }

    public function register()
    {
        return view('auth.register');
    }

    public function register_process(Request $request)
    {
        $validated = $request->validate([
            'name'      => ['required'],
            'email'     => ['required', 'email', 'unique:users'],
            'password'  => [
                'required',
                'confirmed',
                Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
                    ->uncompromised(),
            ]
        ]);

        try {
            $response = $this->authService->register($validated);
            if (!$response) {
                return redirect()->back()->with('error', trans('messages.registration_failed'));
            }

            return redirect()->route('login')->with('success', trans('messages.registration_success'));
        } catch (\Throwable $th) {
            Log::error([
                'line'      => $th->getLine(),
                'file'      => $th->getFile(),
                'message'   => $th->getMessage()
            ]);

            return redirect()->back()->with('error', trans('messages.system_error'));
        }
    }

    public function login(Request $request)
    {
        $validated = $request->validate([
            'email'     => ['required', 'email', 'exists:users'],
            'password'  => ['required']
        ], [
            'email.required' => trans('messages.email_required'),
            'email.email'    => trans('messages.email_invalid'),
            'email.exists'    => trans('messages.email_exists'),
            'password.required' => trans('messages.password_required')
        ]);

        try {
            $response = $this->authService->login($validated);

            if (!$response) {
                return redirect()->back()->with('error', trans('messages.invalid_credentials'));
            }
            return redirect()->route('dashboard')->with('success', trans('messages.login_success'));
        } catch (\Throwable $th) {
            Log::error([
                'line'      => $th->getLine(),
                'file'      => $th->getFile(),
                'message'   => $th->getMessage(),
            ]);

            return redirect()->back()->with('error', trans('messages.system_error'));
        }
    }
    public function logout()
    {
        try {
            session()->flush();
            return redirect('/')->with('success', trans('messages.logout_success'));
        } catch (\Throwable $th) {
            Log::error([
                'line'      => $th->getLine(),
                'file'      => $th->getFile(),
                'message'   => $th->getMessage(),
            ]);

            return redirect()->back()->with('error', trans('messages.system_error'));
        }
    }
    public function switchLang($locale)
    {
        if (in_array($locale, ['en', 'id'])) {
            session(['locale' => $locale]);
        }
        return redirect()->back();
    }
}
