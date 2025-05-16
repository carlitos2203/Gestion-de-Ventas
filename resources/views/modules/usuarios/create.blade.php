@extends('layouts.main')

@section('titulo', $titulo)

@section('contenido')
<main id="main" class="main">
  <div class="pagetitle">
    <h1>Agregar Usuario</h1>
    
  </div><!-- End Page Title -->
  <section class="section">
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Agregar Nuevo Usuario</h5>
            
          <form action="{{ route('usuarios.store') }}" method="POST" id="userForm">
    @csrf
    <div class="mb-3">
        <label for="name" class="form-label">Nombre del usuario *</label>
        <input type="text" class="form-control" name="name" id="name" required
               oninvalid="this.setCustomValidity('Por favor ingrese el nombre del usuario')"
               oninput="this.setCustomValidity('')">
        <div class="invalid-feedback">Este campo es obligatorio</div>
    </div>

    <div class="mb-3">
        <label for="email" class="form-label">Email *</label>
        <input type="email" name="email" id="email" class="form-control" required
               pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$"
               oninvalid="this.setCustomValidity('Por favor ingrese un correo electrónico válido')"
               oninput="this.setCustomValidity('')">
        <div class="invalid-feedback">Ingrese un correo electrónico válido</div>
    </div>

    <div class="mb-3">
        <label for="password" class="form-label">Password *</label>
        <input type="password" name="password" id="password" class="form-control" required
               minlength="8" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]+$"
               oninvalid="this.setCustomValidity('La contraseña debe tener al menos 8 caracteres, incluyendo una mayúscula, un número y un carácter especial')"
               oninput="this.setCustomValidity('')">
        <div class="invalid-feedback">La contraseña debe tener al menos 8 caracteres, incluyendo una mayúscula, un número y un carácter especial</div>
        <small class="form-text text-muted">Mínimo 8 caracteres con al menos una mayúscula, un número y un carácter especial</small>
    </div>

    <div class="mb-3">
        <label for="password_confirmation" class="form-label">Confirmar Password *</label>
        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
        <div class="invalid-feedback">Las contraseñas deben coincidir</div>
    </div>

    <div class="mb-3">
        <label for="rol" class="form-label">Rol de usuario *</label>
        <select name="rol" id="rol" class="form-select" required
                oninvalid="this.setCustomValidity('Por favor seleccione un rol')"
                oninput="this.setCustomValidity('')">
            <option value="">Selecciona el rol</option>
            <option value="admin">Admin</option>
            <option value="cajero">Cajero</option>
        </select>
        <div class="invalid-feedback">Este campo es obligatorio</div>
    </div>

    <button type="submit" class="btn btn-primary mt-3">Guardar</button>
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

<script>
document.getElementById('userForm').addEventListener('submit', function(event) {
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('password_confirmation').value;
    
    if (password !== confirmPassword) {
        alert('Las contraseñas no coinciden');
        event.preventDefault();
    }
});
</script>
          </div>
        </div>
      </div>
    </div>
  </section>

</main>
@endsection

