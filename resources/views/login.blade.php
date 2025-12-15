<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'Test Coppel') }}</title>
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
        <!-- Styles / Scripts -->
        <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
        <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    </head>
        <style>
            body, html {
                height: 100%;
                margin: 0;
                background-image: url("{{asset('assets/images/bannerMedico.jpg')}}");
                height: 100%;
                background-position: center;
                background-repeat: no-repeat;
                background-size: cover;
            }
        </style>
    </head>

    <body class="d-flex justify-content-center">
        <div class="row container">
            <div class="col-md-12 text-end">
                <a href="{{ url('/') }}" class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal">Regresar</a>
            </div>
            <div class="col-md-12 d-flex justify-content-center mt-5">
                <div class="w-50 text-center">
                    @include('disenos_base.alertas')
                    @include('disenos_base.alertas_session')
                </div>
            </div>
            <div class="col-md-12 text-center">
                <h1 style="color: black">Control de citas médicas</h1>
            </div>
            <div class="col-md-12" id="alertaLocal" style="text-align: -webkit-center;">
            </div>
            <div class="col-md-12 text-center">
                <form action="{{ route('signin') }}" method="POST" autocomplete="off" onsubmit="return validarFormulario()">
                    @csrf
                    <div class="row d-flex justify-content-center mb-3">
                        <div class="col-md-3">
                            <label for="txtEmail" class="d-flex none">Correo electrónico</label>
                            <input type="email" class="form-control" name="email" id="txtEmail" placeholder="Ingrese su correo...">
                        </div>
                    </div>
                    <div class="row d-flex justify-content-center mb-3">
                        <div class="col-md-3">
                            <label for="txtPassword" class="d-flex none">Contraseña</label>
                            <input type="password" class="form-control" name="password" id="txtPassword" placeholder="********" minlength="8" maxlength="12">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Inicia sesión</button>
                </form>
            </div>
            <div class="col-md-12 text-end mt-5 px-5">
                <p>Copyright 2025.</p>
            </div>
        </div>
    </body>
</html>
 <script type="text/javascript">
    function validarFormulario()
    {
      document.getElementById('alertaLocal').innerHTML = '';
      var txtEmail = document.getElementById('txtEmail').value;
      var txtPassword = document.getElementById('txtPassword').value;
      var send = true;
      var data = new Array();

      if(txtEmail == ''){
        data.push("Correo electrónico Obligatorio.");
        send = false;
      }
      if(!txtPassword || txtPassword == ''){
        data.push("Contraseña Obligatorio.");
        send = false;
      }

      if(txtPassword && txtPassword.length < 8 || txtPassword.length > 20){
        data.push("Contraseña inválida.");
        send = false;
      }

      data.forEach(mensaje => {
        document.getElementById('alertaLocal').innerHTML += '<div class="alert alert-warning alert-dismissible w-50 fade show" role="alert">' + mensaje + '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
      });
      return send;
    }
</script>