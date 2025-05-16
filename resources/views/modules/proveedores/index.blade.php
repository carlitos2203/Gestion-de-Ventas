@extends('layouts.main')

@section('titulo', $titulo)

@section('contenido')
<main id="main" class="main">
  <div class="pagetitle">
    <h1>Proveedores</h1>
  </div><!-- End Page Title -->
  
  <section class="section">
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Administrar Proveedores</h5>
            <p>Administrar los proveedores de nuestros productos.</p>
            
            @if(session('success'))
              <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
            @endif
            
            @if(session('error'))
              <div class="alert alert-danger alert-dismissible fade show">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
            @endif

            <a href="{{ route('proveedores.create') }}" class="btn btn-primary">
              <i class="fa-solid fa-circle-plus"></i> Agregar nuevo proveedor
            </a>
            <hr>
            
            <table class="table datatable">
              <thead>
                <tr>
                  <th class="text-center">Nombre</th>
                  <th class="text-center">Teléfono</th>
                  <th class="text-center">Email</th>
                  <th class="text-center">Sitio web</th>
                  <th class="text-center">Notas</th>
                  <th class="text-center">Acciones</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($items as $item)
                <tr class="text-center">
                  <td>{{ $item->nombre }}</td>
                  <td>{{ $item->telefono }}</td>
                  <td>
                    <a href="mailto:{{ $item->email }}">{{ $item->email }}</a>
                  </td>
                  <td>
                    @if($item->sitio_web)
                      <a href="{{ $item->sitio_web }}" target="_blank">
                        {{ Str::limit($item->sitio_web, 20) }}
                      </a>
                    @else
                      N/A
                    @endif
                  </td>
                  <td>{{ Str::limit($item->notas, 30) }}</td>
                  <td>
                    <div class="btn-group" role="group">
                      <a href="{{ route('proveedores.edit', $item->id) }}" class="btn btn-warning btn-sm" title="Editar">
                        <i class="fa-solid fa-pen-to-square"></i>
                      </a>
                      <a href="{{ route('proveedores.show', $item->id) }}" class="btn btn-danger btn-sm" title="Eliminar">
                        <i class="fa-solid fa-trash-can"></i>
                      </a>
                    </div>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </section>
</main>
@endsection