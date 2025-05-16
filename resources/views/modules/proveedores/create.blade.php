@extends('layouts.main')

@section('titulo', $titulo)

@section('contenido')
<main id="main" class="main">
  <div class="pagetitle">
    <h1>Agregar proveedor</h1>
  </div><!-- End Page Title -->
  
  <section class="section">
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Agregar Nuevo Proveedor</h5>
            
            @if ($errors->any())
              <div class="alert alert-danger">
                <ul>
                  @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                  @endforeach
                </ul>
              </div>
            @endif
            
            <form action="{{ route('proveedores.store') }}" method="POST" id="proveedorForm">
                @csrf
                
                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre de proveedor *</label>
                    <input type="text" class="form-control @error('nombre') is-invalid @enderror" 
                           name="nombre" id="nombre" required
                           value="{{ old('nombre') }}"
                           pattern="[A-Za-záéíóúÁÉÍÓÚñÑ\s\-]+"
                           oninvalid="this.setCustomValidity('Solo se permiten letras y espacios')"
                           oninput="this.setCustomValidity('')">
                    @error('nombre')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="form-text text-muted">Solo letras y espacios</small>
                </div>
                
                <div class="mb-3">
                    <label for="telefono" class="form-label">Teléfono *</label>
                    <input type="text" class="form-control @error('telefono') is-invalid @enderror" 
                           name="telefono" id="telefono" required
                           value="{{ old('telefono') }}"
                           pattern="[0-9]{8,15}"
                           oninvalid="this.setCustomValidity('Ingrese solo números (8-15 dígitos)')"
                           oninput="this.setCustomValidity('')">
                    @error('telefono')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="form-text text-muted">8-15 dígitos numéricos</small>
                </div>
                
                <div class="mb-3">
                    <label for="email" class="form-label">Email *</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                           name="email" id="email" required
                           value="{{ old('email') }}"
                           oninvalid="this.setCustomValidity('Ingrese un correo electrónico válido')"
                           oninput="this.setCustomValidity('')">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-3">
                    <label for="sitio_web" class="form-label">Sitio Web</label>
                    <input type="url" class="form-control @error('sitio_web') is-invalid @enderror" 
                           name="sitio_web" id="sitio_web"
                           value="{{ old('sitio_web') }}"
                           placeholder="https://ejemplo.com">
                    @error('sitio_web')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-3">
                    <label for="notas" class="form-label">Notas</label>
                    <textarea name="notas" id="notas" cols="30" rows="3" 
                              class="form-control @error('notas') is-invalid @enderror">{{ old('notas') }}</textarea>
                    @error('notas')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <button type="submit" class="btn btn-primary mt-3">Guardar</button>
                <a href="{{ route('proveedores') }}" class="btn btn-info mt-3">Cancelar</a>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>

</main>

<script>
document.getElementById('proveedorForm').addEventListener('submit', function(e) {
    // Validación adicional si es necesaria
    const telefono = document.getElementById('telefono').value;
    if (!/^[0-9]{8,15}$/.test(telefono)) {
        alert('El teléfono debe contener solo números (8-15 dígitos)');
        e.preventDefault();
    }
});
</script>
@endsection

