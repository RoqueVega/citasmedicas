<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/general.css') }}">
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <script src="{{ asset('assets/js/jquery-3.7.1.min.js') }}"></script>
    <script>
      $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
    </script>
  </head>
  <body>
    <div class="page">
      
      <!-- Inicia encabezado de las vistas-->
      @includeIf('disenos_base.encabezado')
      <!-- Fin encabezado de las vistas-->

      <div class="page-body m-5">
        <!-- Inicia el contenido de las vistas-->
        @yield('content')
        <!-- Fin el contenido de las vistas-->
        
        <!-- Inicia el pie de pagina-->
        <footer class="footer">
          <div class="container-fluid">
            <div class="row">
              <div class="col-md-12 text-end">
                <p>Evaluación Coppel Lider Técnico</p>
              </div>
            </div>
          </div>
        </footer>
        <!-- Fin el pie de pagina-->
      </div>
    </div>
  </body>
</html>
