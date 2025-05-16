<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function index() {
        $titulo = "Login de usuarios";
        return view("modules.auth.login", compact("titulo"));
    }

    public function logear(Request $request) {
        // Verificar límite de intentos
        if (RateLimiter::tooManyAttempts($this->throttleKey($request), 5)) {
            $seconds = RateLimiter::availableIn($this->throttleKey($request));
            return back()->withErrors(['email' => "Demasiados intentos. Por favor espere $seconds segundos."]);
        }

        // Validar datos
        $credenciales = $request->validate([
            'email' => 'required|email:rfc,dns|max:100',
            'password' => 'required|min:8|max:50'
        ], [
            'email.required' => 'El correo electrónico es obligatorio',
            'email.email' => 'Debe ingresar un correo electrónico válido',
            'password.required' => 'La contraseña es obligatoria',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres',
            'password.max' => 'La contraseña no debe exceder los 50 caracteres'
        ]);

        // Incrementar contador de intentos
        RateLimiter::hit($this->throttleKey($request));

        // Buscar usuario
        $user = User::where('email', $request->email)->first();

        // Validar credenciales
        if(!$user || !Hash::check($request->password, $user->password)){
            return back()->withErrors(['email' => 'Credenciales incorrectas'])->withInput();
        }

        // Validar usuario activo
        if (!$user->activo) {
            return back()->withErrors(['email' => 'Tu cuenta está inactiva']);
        }

        // Limpiar intentos y crear sesión
        RateLimiter::clear($this->throttleKey($request));
        Auth::login($user);
        $request->session()->regenerate();

        return to_route('home');
    }

    protected function throttleKey(Request $request)
    {
        return Str::transliterate(Str::lower($request->email).'|'.$request->ip());
    }

    public function crearAdmin(){
        //crear directamente un admin
        User::create([
            'name' => 'Gerente',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('Admin12.'),
            'activo' => true,
            'rol' => 'admin'
        ]);

        return "Admin creado con exito!!";
    }

    public function logout() {
        Auth::logout();
        return to_route('login');
    }

}
