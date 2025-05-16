@extends('layouts.main')

@section('titulo', $titulo)

@section('contenido')
<main id="main" class="main">
  <div class="pagetitle">
    <h1>Editar Usuario</h1>
    
  </div><!-- End Page Title -->
  <section class="section">
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Editar Usuario</h5>
            
            <form action="{{ route('usuarios.update', $item->id) }}" method="POST" id="editUserForm">
    @csrf
    @method('PUT')
    
    <div class="mb-3">
        <label for="name" class="form-label">Nombre del usuario *</label>
        <input type="text" class="form-control @error('name') is-invalid @enderror" 
               name="name" id="name" required
               value="{{ old('name', $item->name) }}"
               oninvalid="this.setCustomValidity('Por favor ingrese el nombre del usuario')"
               oninput="this.setCustomValidity('')">
        @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="email" class="form-label">Email *</label>
        <input type="email" name="email" id="email" 
               class="form-control @error('email') is-invalid @enderror" required
               value="{{ old('email', $item->email) }}"
               pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$"
               oninvalid="this.setCustomValidity('Por favor ingrese un correo electrónico válido')"
               oninput="this.setCustomValidity('')">
        @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="rol" class="form-label">Rol de usuario *</label>
        <select name="rol" id="rol" class="form-select @error('rol') is-invalid @enderror" required
                oninvalid="this.setCustomValidity('Por favor seleccione un rol')"
                oninput="this.setCustomValidity('')">
            <option value="">Selecciona el rol</option>
            <option value="admin" {{ old('rol', $item->rol) == 'admin' ? 'selected' : '' }}>Admin</option>
            <option value="cajero" {{ old('rol', $item->rol) == 'cajero' ? 'selected' : '' }}>Cajero</option>
        </select>
        @error('rol')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <button type="submit" class="btn btn-warning mt-3">Actualizar</button>
    <a href="{{ route('usuarios') }}" class="btn btn-info mt-3">Cancelar</a>
</form>

@if ($errors->any())
    <div class="alert alert-danger mt-3">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
          </div>
        </div>
      </div>
    </div>
  </section>

</main>
@endsection

