<?php

namespace App\Http\Controllers;

use App\Models\Proveedor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

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
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|regex:/^[\pL\s\-]+$/u|max:100',
            'telefono' => 'required|numeric|digits_between:8,15',
            'email' => 'required|email:rfc,dns|max:100',
            'sitio_web' => 'nullable|url|max:255',
            'notas' => 'nullable|string|max:500'
        ], [
            'nombre.required' => 'El nombre es obligatorio',
            'nombre.regex' => 'El nombre solo puede contener letras y espacios',
            'nombre.max' => 'El nombre no debe exceder los 100 caracteres',
            'telefono.required' => 'El teléfono es obligatorio',
            'telefono.numeric' => 'El teléfono solo puede contener números',
            'telefono.digits_between' => 'El teléfono debe tener entre 8 y 15 dígitos',
            'email.required' => 'El correo electrónico es obligatorio',
            'email.email' => 'Debe ingresar un correo electrónico válido',
            'email.max' => 'El correo no debe exceder los 100 caracteres',
            'sitio_web.url' => 'Ingrese una URL válida para el sitio web',
            'notas.max' => 'Las notas no deben exceder los 500 caracteres'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }

        try {
            $item = new Proveedor();
            $item->nombre = $request->nombre;
            $item->telefono = $request->telefono;
            $item->email = $request->email;
            $item->sitio_web = $request->sitio_web;
            $item->notas = $request->notas;
            $item->save();
            
            return to_route('proveedores')->with("success", "Proveedor agregado con éxito!");
        } catch (\Throwable $th) {
            return to_route('proveedores')->with("error", "Error al agregar proveedor: " . $th->getMessage());
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
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|regex:/^[\pL\s\-]+$/u|max:100',
            'telefono' => 'required|numeric|digits_between:8,15',
            'email' => [
                'required',
                'email:rfc,dns',
                'max:100',
                Rule::unique('proveedores')->ignore($id)
            ],
            'sitio_web' => 'nullable|url|max:255',
            'notas' => 'nullable|string|max:500'
        ], [
            'nombre.required' => 'El nombre es obligatorio',
            'nombre.regex' => 'El nombre solo puede contener letras y espacios',
            'nombre.max' => 'El nombre no debe exceder los 100 caracteres',
            'telefono.required' => 'El teléfono es obligatorio',
            'telefono.numeric' => 'El teléfono solo puede contener números',
            'telefono.digits_between' => 'El teléfono debe tener entre 8 y 15 dígitos',
            'email.required' => 'El correo electrónico es obligatorio',
            'email.email' => 'Debe ingresar un correo electrónico válido',
            'email.unique' => 'Este correo electrónico ya está registrado',
            'email.max' => 'El correo no debe exceder los 100 caracteres',
            'sitio_web.url' => 'Ingrese una URL válida para el sitio web',
            'notas.max' => 'Las notas no deben exceder los 500 caracteres'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }

        try {
            $item = Proveedor::find($id);
            $item->nombre = $request->nombre;
            $item->telefono = $request->telefono;
            $item->email = $request->email;
            $item->sitio_web = $request->sitio_web;
            $item->notas = $request->notas;
            $item->save();
            
            return to_route('proveedores')->with('success', 'Proveedor actualizado con éxito!');
        } catch (\Throwable $th) {
            return to_route('proveedores')->with('error', 'Error al actualizar proveedor: ' . $th->getMessage());
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
            return to_route('proveedores')->with('success', 'Proveedor eliminado con éxito!');
        } catch (\Throwable $th) {
            return to_route('proveedores')->with('error', 'Error al eliminar proveedor: ' . $th->getMessage());
        }
    }
}