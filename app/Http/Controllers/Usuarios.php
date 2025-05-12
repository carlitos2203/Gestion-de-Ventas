<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Hash;

class Usuarios extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $titulo = "Usuarios";
        $items = User::all();
        return view('modules.usuarios.index', compact('items','titulo'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $titulo = 'Usuario nuevo';
        return view('modules.usuarios.create', compact('titulo'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255|unique:users,name|regex:/^\S.*/',
                'email' => 'required|email|max:255|unique:users,email|regex:/^[^\s]+@gmail\.com$/i',
                'password' => 'required|string|min:8|regex:/^(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).+$/',
                'rol' => 'required|in:admin,cajero',
            ], [
                'name.regex' => 'El nombre no puede comenzar con espacios.',
                'email.regex' => 'Solo se permiten cuentas de Gmail (ejemplo@gmail.com)',
                'password.regex' => 'La contraseña debe tener al menos 8 caracteres, una mayúscula, un número y un símbolo.',
            ]);
    
            
            User::create([
                'name' => preg_replace('/^\s+/', '', $request->name),
                'email' => preg_replace('/^\s+/', '', $request->email),
                'password' => Hash::make($request->password),
                'activo' => true,
                'rol' => $request->rol
            ]);
    
            return to_route('usuarios')->with('success', 'Usuario guardado con éxito!');
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->validator)->withInput();
        } catch (Exception $e) {
            return to_route('usuarios')->with('error', 'Error al guardar usuario: ' . $e->getMessage());
        }
    }

    
    public function show(string $id)
    {
        //
    }


    public function edit(string $id)
    {
        $item = User::find($id);
        $titulo = "Editar usuario";
        return view('modules.usuarios.edit', compact('item', 'titulo'));
    }

    
    public function update(Request $request, string $id)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255|unique:users,name,'.$id.'|regex:/^\S.*/',
                'email' => 'required|email|max:255|unique:users,email,'.$id.'|regex:/^\S+@\S+\.\S+$/',
                'rol' => 'required|in:admin,cajero',
            ], [
                'name.regex' => 'El nombre no puede comenzar con espacios.',
                'email.regex' => 'El email no puede comenzar con espacios.',
            ]);
    
            $item = User::find($id);
            $item->name = preg_replace('/^\s+/', '', $request->name);
            $item->email = preg_replace('/^\s+/', '', $request->email);
            $item->rol = $request->rol;
            $item->save();
            
            return to_route('usuarios')->with('success', 'Usuario actualizado con éxito!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->validator)->withInput();
        } catch (Exception $e) {
            return to_route('usuarios')->with('error', 'Error al actualizar usuario: ' . $e->getMessage());
        }
    }

   
    public function destroy(string $id)
    {
        //
    }

    public function tbody(){
        $items = User::all();
        return view('modules.usuarios.tbody', compact('items'));
    }

    public function estado($id, $estado) {
        $item = User::find($id);
        $item->activo = $estado;
        return $item->save();
    }

    public function cambio_password($id, $password){
        $item = User::find($id);
        $item->password = Hash::make($password);
        return $item->save();
    }

}
