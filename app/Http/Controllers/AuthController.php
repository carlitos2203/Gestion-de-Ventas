<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function index() {
        $titulo = "Login de usuarios";
        return view("modules.auth.login", compact("titulo"));
    }

    public function logear(Request $request) {
        //validar datos de las credenciales
        $credenciales = $request->validate([
            'email' => 'required|email|ends_with:@gmail.com',
            'password' => [
                'required',
                'min:8',
                'regex:/^(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).+$/'
            ]
        ], [
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'password.regex' => 'La contraseña debe contener al menos una mayúscula, un número y un símbolo (ej: ., -_).',
        ]);

        //buscar el email
        $user = User::where('email', $request->email)->first();

        //validar usuario y contraseña
        if(!$user || !Hash::check($request->password, $user->password)){
            return back()->withErrors(['email' => 'Credencial incorrecta!'])->withInput();
        }

        //el usuario este activo
        if (!$user->activo) {
            return back()->withErrors(['email' => 'Tu cuenta esta inactiva!']);
        }

        //crear la sesion de usuario
        Auth::login($user);
        $request->session()->regenerate();

        return to_route('home');
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
