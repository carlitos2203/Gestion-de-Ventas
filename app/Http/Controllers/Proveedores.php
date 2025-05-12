<?php

namespace App\Http\Controllers;

use App\Models\Proveedor;
use Illuminate\Http\Request;

class Proveedores extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $titulo = 'Proveedores';
        $items = Proveedor::all();
        return view('modules.proveedores.index', compact('items', 'titulo'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $titulo = 'Agregar proveedor';
        return view('modules.proveedores.create', compact('titulo'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'nombre' => 'required|string|max:255|unique:proveedores,nombre|regex:/^\S.*/',
                'telefono' => 'required|string|max:20|regex:/^\+?\d+$/',
                'email' => 'required|email|max:255|unique:users,email|regex:/^[^\s]+@gmail\.com$/i',
                'sitio_web' => 'required|string|max:255|regex:/^\S.*/',
                'notas' => 'nullable|string',
            ], [
                'nombre.regex' => 'El nombre no puede comenzar con espacios.',
                'email.regex' => 'El email no puede comenzar con espacios.',
                'sitio_web.regex' => 'El sitio web no puede comenzar con espacios.',
            ]);
    
            // Eliminar espacios al inicio pero mantener al final
            $item = new Proveedor();
            $item->nombre = preg_replace('/^\s+/', '', $request->nombre);
            $item->telefono = $request->telefono;
            $item->email = preg_replace('/^\s+/', '', $request->email);          
            $item->sitio_web = preg_replace('/^\s+/', '', $request->sitio_web);
            $item->notas = $request->notas;
            $item->save();
            
            return to_route('proveedores')->with("success", "Proveedor agregado con éxito!");
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->validator)->withInput();
        } catch (\Throwable $th) {
            return to_route('proveedores')->with("error", "Fallo al agregar proveedor: " . $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $titulo = "Eliminar un proveedor";
        $item = Proveedor::find($id);
        return view("modules.proveedores.show", compact('titulo', 'item'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $item = Proveedor::find($id);
        $titulo = "Editar Proveedor";
        return view('modules.proveedores.edit', compact('item', 'titulo'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $validated = $request->validate([
                'nombre' => 'required|string|max:255|unique:proveedores,nombre,'.$id.'|regex:/^\S.*/',
                'telefono' => 'required|string|max:20|regex:/^\+?\d+$/',
                'email' => 'required|email|max:255|unique:users,email,'.$id.'|regex:/^[^\s]+@gmail\.com$/i',
                'sitio_web' => 'required|string|max:255|regex:/^\S.*/',
                'notas' => 'nullable|string',
            ], [
                'nombre.regex' => 'El nombre no puede comenzar con espacios.',
                'email.regex' => 'El email no puede comenzar con espacios.',
                'sitio_web.regex' => 'El sitio web no puede comenzar con espacios.',
            ]);
    
            $item = Proveedor::find($id);
            $item->nombre = preg_replace('/^\s+/', '', $request->nombre);
            $item->telefono = $request->telefono;
            $item->email = preg_replace('/^\s+/', '', $request->email);
            $item->sitio_web = preg_replace('/^\s+/', '', $request->sitio_web);
            $item->notas = $request->notas;
            $item->save();
            
            return to_route('proveedores')->with('success', 'Actualizado con éxito!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->validator)->withInput();
        } catch (\Throwable $th) {
            return to_route('proveedores')->with('error', 'No se pudo actualizar: ' . $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $item = Proveedor::find($id);
            $item->delete();
            return to_route('proveedores')->with('success', 'Proveedor Eliminado con exito!');
        } catch (\Throwable $th) {
            return to_route('proveedores')->with('error', 'Fallo al eliminar!!', $th->getMessage());
        }
    }
}
