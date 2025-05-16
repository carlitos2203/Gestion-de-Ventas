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
            'name' => 'required|string|max:255',
            'email' => 'required|email:rfc,dns|max:255|unique:users,email',
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]+$/'
            ],
            'rol' => 'required|in:admin,cajero'
        ], [
            'name.required' => 'El nombre es obligatorio',
            'email.required' => 'El correo electrónico es obligatorio',
            'email.email' => 'Debe ingresar un correo electrónico válido',
            'email.unique' => 'Este correo electrónico ya está registrado',
            'password.required' => 'La contraseña es obligatoria',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres',
            'password.confirmed' => 'Las contraseñas no coinciden',
            'password.regex' => 'La contraseña debe contener al menos una mayúscula, un número y un carácter especial',
            'rol.required' => 'El rol es obligatorio',
            'rol.in' => 'Seleccione un rol válido'
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'activo' => true,
            'rol' => $validated['rol']
        ]);

        return to_route('usuarios')->with('success', 'Usuario guardado con éxito!');
        
    } catch (Exception $e) {
        return to_route('usuarios.create')->with('error', 'Error al guardar usuario: ' . $e->getMessage())->withInput();
    }
}

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $item = User::find($id);
        $titulo = "Editar usuario";
        return view('modules.usuarios.edit', compact('item', 'titulo'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
{
    try {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email:rfc,dns|max:255|unique:users,email,'.$id,
            'rol' => 'required|in:admin,cajero'
        ], [
            'name.required' => 'El nombre es obligatorio',
            'email.required' => 'El correo electrónico es obligatorio',
            'email.email' => 'Debe ingresar un correo electrónico válido',
            'email.unique' => 'Este correo electrónico ya está registrado',
            'rol.required' => 'El rol es obligatorio',
            'rol.in' => 'Seleccione un rol válido'
        ]);

        $item = User::findOrFail($id);
        $item->name = $validated['name'];
        $item->email = $validated['email'];
        $item->rol = $validated['rol'];
        $item->save();

        return to_route('usuarios')->with('success', 'Usuario actualizado con éxito!');
    } catch (Exception $e) {
        return back()->with('error', 'Error al actualizar usuario: ' . $e->getMessage())->withInput();
    }
}

    /**
     * Remove the specified resource from storage.
     */
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
