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
            
            <form action="{{ route('proveedores.store') }}" method="POST">
              @csrf
              <label for="name">Nombre de proveedor <span class="text-danger">*</span></label>
              <input type="text" class="form-control" required name="name" id="name"
                    pattern="^[^\d]*$" 
                    title="No se permiten números en el nombre"
                    oninput="this.value = this.value.replace(/[0-9]/g, '').replace(/^\s+/g, '')">
              
              <label for="telefono">Teléfono<span class="text-danger">*</span></label>
              <input type="tel" class="form-control" required name="telefono" id="telefono"
                     pattern="\+?\d*" title="Solo se permiten números y el símbolo +"
                     oninput="this.value = this.value.replace(/[^0-9+]/g, '');">
              
              <label for="email">Email <span class="text-danger">*</span></label>
              <input type="email" name="email" id="email" class="form-control" required
                     pattern="^[^\s]+@gmail\.com$" 
                     title="Solo se permiten cuentas de Gmail (ejemplo@gmail.com)"
                     oninput="this.value = this.value.toLowerCase().replace(/^\s+/g, '').replace(/\s+/g, '')">
                     
              <label for="sitio_web">Sitio Web<span class="text-danger">*</span></label>
              <input type="text" class="form-control" required name="sitio_web" id="sitio_web"
                     pattern="^\S.*" title="No se permiten espacios al inicio"
                     oninput="this.value = this.value.replace(/^\s+/g, '')">
              
              <label for="notas">Notas</label>
              <textarea name="notas" id="notas" cols="30" rows="10" class="form-control"></textarea>
              
              <button class="btn btn-primary mt-3">Guardar</button>
              <a href="{{ route('proveedores') }}" class="btn btn-info mt-3">
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

