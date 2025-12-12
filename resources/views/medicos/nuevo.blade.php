@extends('disenos_base.index')

@section('title', 'Catálogo de Médicos')

@section('content')
  <div class="container-fluid">
    <div class="page-header">
      <div class="row">
        <div class="col-lg-6">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="">Inicio</a></li>
            <li class="breadcrumb-item"><a href="{{ route('medicos.index') }}">Médicos</a></li>
            <li class="breadcrumb-item active"><a href="#">
              @if(@$medico->id) Editar @else Nuevo @endif
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
          <a href="{{ route('medicos.index') }}" class="btn btn-primary text-white mb-3 float-end">Regresar</a>
        </div>
        <div class="col-md-12">
          <div class="card">
            <div class="card-body">
              @include('disenos_base.alertas')
              @include('disenos_base.alertas_session')
              <h2 class="text-center mb-5">
                @if(@$medico->id)Editar @else Crear @endif Médico</h2>
              <div class="col-md-12" id="alertaLocal">
              </div>
              @if(@$medico->id)
              <form class="row" action="{{ route('medicos.actualizar', @$medico->id) }}" method="POST" autocomplete="off" onsubmit="return validarFormulario()">
                @method("put")
              @else
              <form class="row" action="{{ route('medicos.guardar') }}" method="POST" autocomplete="off" onsubmit="return validarFormulario()">
              @endif
                @csrf
                <div class="col-md-6 mb-3">
                  <label for="txtNombre" class="form-label">Nombre:</label>
                  <input type="text" class="form-control" name="nombre" id="txtNombre" placeholder="Nombre" maxlength="50" value="{{ old('nombre') ?? @$medico->nombre ?? '' }}">
                </div>
                <div class="col-md-6 mb-3">
                  <label for="txtApellidoPaterno" class="form-label">Apellido Paterno:</label>
                  <input type="text" class="form-control" name="apellidoPaterno" id="txtApellidoPaterno" placeholder="Ap. Paterno" maxlength="50" value="{{ old('apellidoPaterno') ?? @$medico->apellido_paterno ?? '' }}">
                </div>
                <div class="col-md-6 mb-3">
                  <label for="txtApellidoMaterno" class="form-label">Apellido Materno:</label>
                  <input type="text" class="form-control" name="apellidoMaterno" id="txtApellidoMaterno" placeholder="Ap. Materno" maxlength="50" value="{{ old('apellidoMaterno') ?? @$medico->apellido_materno ?? '' }}">
                </div>
                <div class="col-md-6 mb-3">
                  <label for="cmbGenero" class="form-label">Genero:</label>
                  <select class="form-select" aria-label="Seleccione" name="idGenero" id="cmbGenero">
                    <option value="">Seleccione</option>
                    @foreach($generos as $genero)
                    <option value="{{ $genero->id }}" {{ ((old('idGenero') == $genero->id) || ($genero->id == @$medico->genero_id) ? 'selected':'') }}>{{ $genero->nombre }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="col-md-3 mb-3">
                  <label for="dtFechaNacimiento" class="form-label">Fecha de Nacimiento:</label>
                  <input type="date" class="form-control" name="fechaNacimiento" id="dtFechaNacimiento" value="{{ old('fechaNacimiento') ?? @$medico->fecha_nacimiento ?? '' }}">
                </div>
                <div class="col-md-3 mb-3">
                  <label for="status" class="form-label">Estado:</label><br>
                  <div class="btn-group" role="group">
                    <input type="radio" class="btn-check" name="activo" id="chkEstadoActivo" value="1" @if(@$medico->id && $medico->activo == 1) checked @else {{ old('activo') == "1" ? 'checked' : '' }} @endif>
                    <label class="btn btn-outline-primary" for="chkEstadoActivo">Activo</label>
                    <input type="radio" class="btn-check" name="activo" id="chkEstadoInactivo" value="0" @if(@$medico->id && $medico->activo == 0) checked @else {{ old('activo') == "0" ? 'checked' : '' }} @endif>
                    <label class="btn btn-outline-primary" for="chkEstadoInactivo">Inactivo</label>
                  </div>
                </div>
                <div class="col-md-12 mt-1 mb-4 text-center">
                  <h3 class="text-center mb-3">Especialidades</h3>
                    <div class="overflow-auto" style="height:150px;">
                      @php $contador = 0; @endphp
                      @foreach($profesiones as $profesion)
                      @php $contador ++; @endphp
                      <div class="col-md-2 form-check-inline mb-3" align="left">
                        <div class="form-check">
                          <input class="form-check-input profesiones" name="profesiones[]" type="checkbox" id="chk_profesion_{{ $contador }}" value="{{ $profesion->id }}"
                          @if(@$medico->id && in_array($profesion->id, @$medico->profesionesIds())) checked @endif>
                          <label class="form-check-label w-100" for="chk_profesion_{{ $contador }}">{{ $profesion->nombre }}</label>
                        </div>
                      </div>
                      @endforeach
                    </div>
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
      if(!chkEstadoActivo.checked && !chkEstadoInactivo.checked){
        data.push("Estado del registro Obligatorio.");
        send = false;
      }
      if(!seleccionProfesiones()){
        data.push("Seleccione una o más profesiones.");
        send = false;
      }

      data.forEach(mensaje => {
        document.getElementById('alertaLocal').innerHTML += '<div class="alert alert-warning alert-dismissible fade show" role="alert">' + mensaje + '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
      });
      return send;
    }

    function seleccionProfesiones()
    {
      var profesiones = document.getElementsByClassName('profesiones');
      for (var profesion of profesiones) {
        var chkProfesion = document.getElementById(profesion.id);
        if(chkProfesion && chkProfesion.checked){
          return true;
        }
      }
      return false;
    }
  </script>
@endsection


