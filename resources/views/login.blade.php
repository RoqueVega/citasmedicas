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
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
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

    <body class="text-center">
        <div class="row">
            <div class="col-md-12 mt-5">
                <p><h1 style="color: black">Control de citas médicas</h1></p>
            </div>
            <div class="col-md-12">
                <form>
                    <div class="row d-flex justify-content-center mb-3">
                        <div class="col-md-3">
                            <label for="txtCorreoElectronico" class="d-flex none">Correo electrónico</label>
                            <input type="email" class="form-control" id="txtCorreoElectronico" placeholder="Ingrese su correo...">
                        </div>
                    </div>
                    <div class="row d-flex justify-content-center mb-3">
                        <div class="col-md-3">
                            <label for="txtContrasena" class="d-flex none">Contraseña</label>
                            <input type="password" class="form-control" id="txtContrasena" placeholder="********">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Inicia sesión</button>
                </form>
            </div>

            <div class="col-md-12 mt-auto text-end">
                <p>Copyright 2025.</p>
            </div>
        </div>
    </body>
</html>
