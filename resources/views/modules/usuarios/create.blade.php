@extends('layouts.main')

@section('titulo', $titulo)

@section('contenido')
<main id="main" class="main">
  <div class="pagetitle">
    <h1>Agregar Usuario</h1>
    
  </div>
  <section class="section">
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Agregar Nuevo Usuario</h5>
            
            <form action="{{ route('usuarios.store') }}" method="POST">
              @csrf
              <label for="name">Nombre del usuario <span class="text-danger">*</span></label>
              <input type="text" class="form-control" required name="name" id="name"
                    pattern="^[^\d]*$" 
                    title="No se permiten números en el nombre"
                    oninput="this.value = this.value.replace(/[0-9]/g, '').replace(/^\s+/g, '')">
              
              <label for="email">Email <span class="text-danger">*</span></label>
              <input type="email" name="email" id="email" class="form-control" required
                     pattern="^[^\s]+@gmail\.com$" 
                    title="Solo se permiten cuentas de Gmail (ejemplo@gmail.com)"
                     oninput="this.value = this.value.toLowerCase().replace(/^\s+/g, '').replace(/\s+/g, '')">
              
              <label for="password">Password <span class="text-danger">*</span></label>
              <input type="password" name="password" class="form-control" id="password" required
                     minlength="8" pattern="^(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).+$"
                     title="Mínimo 8 caracteres, una mayúscula, un número y un símbolo (ej: ., -_)">
              
              <label for="rol">Rol de usuario <span class="text-danger">*</span></label>
              <select name="rol" id="rol" class="form-select" required>
                  <option value="">Selecciona el rol</option>
                  <option value="admin">Administrador</option>
                  <option value="cajero">Cajero</option>
              </select>
              
              <button class="btn btn-primary mt-3">Guardar</button>
              <a href="{{ route('usuarios') }}" class="btn btn-info mt-3">
                  Cancelar
              </a>
          </form>
          </div>
        </div>
      </div>
    </div>
  </section>

</main>
@endsection

