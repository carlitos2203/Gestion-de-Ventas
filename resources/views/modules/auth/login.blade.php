@extends('layouts.login')

@section('titulo', $titulo )
@section('contenido')
<main>
    <div class="container">

      <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

              <div class="d-flex justify-content-center py-4">
                <a href="#" class="logo d-flex align-items-center w-auto">
                  
                </a>
              </div><!-- End Logo -->

              <div class="card mb-3">

                <div class="card-body">
                  <img src="{{ asset('img/login.jpg') }}" alt="" class="img-fluid">
                  <div class="pt-4 pb-2">
                    <h5 class="card-title text-center pb-0 fs-4">Ingresa tu email y password para acceder</h5>
                    
                  </div>
                  <form class="row g-3 needs-validation" novalidate method="POST" action="{{ route('logear') }}">
                    @csrf
                    <div class="col-12">
                       <label for="email" class="form-label">Email</label>
                         <div class="input-group has-validation">
                           <input type="email" name="email" class="form-control" id="email" 
                                    required pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$">
                         <div class="invalid-feedback">Ingrese un correo electrónico válido</div>
                    </div>
                    </div>
                        <div class="col-12">
                        <label for="password" class="form-label">Password</label>
                           <input type="password" name="password" class="form-control" id="password" 
                                required minlength="8">
                         <div class="invalid-feedback">La contraseña debe tener al menos 8 caracteres</div>
                    </div>
                    <div class="col-12">
                      <button class="btn btn-primary w-100" type="submit">Login</button>
                    </div>
                  </form>
                  <!--Validacion que viene de logear-->
                  <div>
                    @if ($errors->any())
                      <p>
                        <ul>
                          @foreach ($errors->all() as $error)
                          <li>{{ $error }}</li>
                          @endforeach
                        </ul>
                      </p>
                    @endif
                  </div>
                </div>
              </div>

             

            </div>
          </div>
        </div>

      </section>

    </div>
  </main>
@endsection