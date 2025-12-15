@extends('disenos_base.index')

@section('title', 'Catálogo de Pacientes')

@section('content')
  <div class="container-fluid">
    <div class="page-header">
      <div class="row">
        <div class="col-lg-6">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="">Inicio</a></li>
            <li class="breadcrumb-item"><a href="{{ route('pacientes.index') }}">Pacientes</a></li>
            <li class="breadcrumb-item active"><a href="#">
              @if(@$paciente->id) Editar @else Nuevo @endif
            </a>
            </li>
          </ol>
        </div>
      </div>
    </div>    
  </div>

  <section>
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <a href="{{ route('pacientes.index') }}" class="btn btn-primary text-white mb-3 float-end">Regresar</a>
        </div>
        <div class="col-md-12">
          <div class="card">
            <div class="card-body">
              @include('disenos_base.alertas')
              @include('disenos_base.alertas_session')
              <h2 class="text-center mb-5">
                @if(@$paciente->id)Editar @else Crear @endif Paciente</h2>
              <div class="col-md-12" id="alertaLocal">
              </div>
              @if(@$paciente->id)
              <form class="row" action="{{ route('pacientes.actualizar', @$paciente->id) }}" method="POST" autocomplete="off" onsubmit="return validarFormulario()">
                @method("put")
              @else
              <form class="row" action="{{ route('pacientes.guardar') }}" method="POST" autocomplete="off" onsubmit="return validarFormulario()">
              @endif
                @csrf
                <div class="col-md-6 mb-3">
                  <label for="txtNombre" class="form-label">Nombre:</label>
                  <input type="text" class="form-control" name="nombre" id="txtNombre" placeholder="Nombre" maxlength="50" value="{{ old('nombre') ?? @$paciente->nombre ?? '' }}">
                </div>
                <div class="col-md-6 mb-3">
                  <label for="txtApellidoPaterno" class="form-label">Apellido Paterno:</label>
                  <input type="text" class="form-control" name="apellidoPaterno" id="txtApellidoPaterno" placeholder="Ap. Paterno" maxlength="50" value="{{ old('apellidoPaterno') ?? @$paciente->apellido_paterno ?? '' }}">
                </div>
                <div class="col-md-6 mb-3">
                  <label for="txtApellidoMaterno" class="form-label">Apellido Materno:</label>
                  <input type="text" class="form-control" name="apellidoMaterno" id="txtApellidoMaterno" placeholder="Ap. Materno" maxlength="50" value="{{ old('apellidoMaterno') ?? @$paciente->apellido_materno ?? '' }}">
                </div>
                <div class="col-md-6 mb-3">
                  <label for="txtTelefono" class="form-label">Teléfono:</label>
                  <input type="text" class="form-control" name="telefono" id="txtTelefono" placeholder="Teléfono" maxlength="10" value="{{ old('telefono') ?? @$paciente->telefono ?? '' }}">
                </div>
                <div class="col-md-6 mb-3">
                  <label for="txtCorreoElectronico" class="form-label">Correo electrónico:</label>
                  <input type="email" class="form-control" name="correoElectronico" id="txtCorreoElectronico" placeholder="paciente@correo.com" maxlength="100" value="{{ old('correoElectronico') ?? @$paciente->correo_electronico ?? '' }}">
                </div>
                <div class="col-md-6 mb-3">
                  <label for="dtFechaNacimiento" class="form-label">Fecha de Nacimiento:</label>
                  <input type="date" class="form-control" name="fechaNacimiento" id="dtFechaNacimiento" value="{{ old('fechaNacimiento') ?? @$paciente->fecha_nacimiento ?? '' }}">
                </div>
                <div class="col-md-6 mb-3">
                  <label for="cmbGenero" class="form-label">Genero:</label>
                  <select class="form-select" aria-label="Seleccione" name="idGenero" id="cmbGenero">
                    <option value="">Seleccione</option>
                    @foreach($generos as $genero)
                    <option value="{{ $genero->id }}" {{ ((old('idGenero') == $genero->id) || ($genero->id == @$paciente->genero_id) ? 'selected':'') }}>{{ $genero->nombre }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="col-md-3 mb-3">
                  <label for="status" class="form-label">Estado:</label><br>
                  <div class="btn-group" role="group">
                    <input type="radio" class="btn-check" name="activo" id="chkEstadoActivo" value="1" @if(@$paciente->id && $paciente->activo == 1) checked @else {{ old('activo') == "1" ? 'checked' : '' }} @endif>
                    <label class="btn btn-outline-primary" for="chkEstadoActivo">Activo</label>
                    <input type="radio" class="btn-check" name="activo" id="chkEstadoInactivo" value="0" @if(@$paciente->id && $paciente->activo == 0) checked @else {{ old('activo') == "0" ? 'checked' : '' }} @endif>
                    <label class="btn btn-outline-primary" for="chkEstadoInactivo">Inactivo</label>
                  </div>
                </div>
                <div class="col-md-12 mb-3">
                  <button class="btn btn-success float-end" type="submit">Guardar</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  
  <script type="text/javascript">
    function validarFormulario()
    {
      document.getElementById('alertaLocal').innerHTML = '';
      var txtNombre = document.getElementById('txtNombre').value;
      var txtApellidoPaterno = document.getElementById('txtApellidoPaterno').value;
      var txtApellidoMaterno = document.getElementById('txtApellidoMaterno').value;
      var cmbGenero = document.getElementById('cmbGenero').value;
      var dtFechaNacimiento = document.getElementById('dtFechaNacimiento').value;
      var txtTelefono = document.getElementById('txtTelefono').value;
      var txtCorreoElectronico = document.getElementById('txtCorreoElectronico').value;
      var chkEstadoActivo = document.getElementById('chkEstadoActivo');
      var chkEstadoInactivo = document.getElementById('chkEstadoInactivo');
      var send = true;
      var data = new Array();

      if(txtNombre == ''){
        data.push("Nombre Obligatorio.");
        send = false;
      }
      if(txtApellidoPaterno == ''){
        data.push("Ap. Paterno Obligatorio.");
        send = false;
      }
      if(txtApellidoMaterno == ''){
        data.push("Ap. Materno Obligatorio.");
        send = false;
      }
      if(cmbGenero == ''){
        data.push("Género Obligatorio.");
        send = false;
      }
      if(dtFechaNacimiento == ''){ 
        data.push("Fecha de nacimiento Obligatorio.");
        send = false;
      }
      if(txtTelefono == '' || txtTelefono.length != 10){
        data.push("Teléfono Obligatorio, y debe de ser una teléfono valido.");
        send = false;
      }
      if(txtCorreoElectronico != '' && txtCorreoElectronico.length > 100){ 
        data.push("Correo electrónico debe de ser menor a 100 caracteres.");
        send = false;
      }
      if(!chkEstadoActivo.checked && !chkEstadoInactivo.checked){
        data.push("Estado del registro Obligatorio.");
        send = false;
      }
      
      data.forEach(mensaje => {
        document.getElementById('alertaLocal').innerHTML += '<div class="alert alert-warning alert-dismissible fade show" role="alert">' + mensaje + '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
      });
      return send;
    }

    
  </script>
@endsection


