@extends('disenos_base.index')

@section('title', 'Programación de la cita')

@section('content')
  <section>
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-body">
              @include('disenos_base.alertas')
              @include('disenos_base.alertas_session')
              <h2 class="text-center mb-5">Programar Cita</h2>
              <div class="col-md-12" id="alertaLocal">
              </div>
              <form class="row" action="{{ route('agenda.citas.guardar') }}" method="POST" autocomplete="off" onsubmit="return validarFormulario()">
                @csrf
                <div class="col-md-8 mb-2">
                  <label for="txtBuscarPaciente" class="form-label">Paciente:</label>
                  <div class="d-flex justify-content-center">
                    <input type="text" class="form-control me-2" name="buscarPaciente" id="txtBuscarPaciente" placeholder="Buscar..." maxlength="30">
                    <button class="btn btn-light me-2" onclick="obtenerPacientes()" type="button">Buscar</button>
                    <a href=" {{ route('pacientes.nuevo') }}" class="btn btn-info text-white" style="margin-left: 20%;">Crear</a>
                  </div>
                </div>
                <div class="col-md-12 mb-5" id="alertaLocalPacientes"></div>
                <div class="col-md-6 mb-3">
                  <label for="dlFechaReserva" class="form-label">Fecha de Reserva:</label>
                  <input type="datetime-local" class="form-control" name="fechaReserva" id="dlFechaReserva" 
                  value="{{ old('fechaReserva') ?? @$agentaCita->fecha_reservacion ?? '' }}"/>
                </div>
                <div class="col-md-6 mb-3">
                  <label for="txtMotivoVisita" class="form-label">Motivo de visita</label>
                  <textarea class="form-control" name="motivoVisita" id="txtMotivoVisita" rows="1" maxlength="300" placeholder="Ingrese el motivo">{{ old('motivoVisita') ?? @$agentaCita->motivo_visita ?? '' }}</textarea>
                </div>
                <div class="col-md-6 mb-3">
                  <label for="cmbProfesion" class="form-label">Especialidad:</label>
                  <select class="form-select" aria-label="Seleccione" name="idProfesion" id="cmbProfesion">
                    <option value="">Seleccione</option>
                    @foreach($profesiones as $profesion)
                    <option value="{{ $profesion->id }}">{{ $profesion->nombre }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="col-md-6 mb-3">
                  <label for="cmbMedico" class="form-label">Médico:</label>
                  <select class="form-select" aria-label="Seleccione" name="idMedico" id="cmbMedico">
                    <option value="">Seleccione</option>
                  </select>
                  <small class="text-danger d-none" id="alertaLocalMedico">No existen médicos con esa especialidad.</small>
                </div>
                <div class="col-md-12 mb-3">
                  <button class="btn btn-success float-end" type="submit">Enviar</button>
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
      var rbPaciente = document.querySelector('input[name="idPaciente"]:checked');
      var dlFechaReserva = document.getElementById('dlFechaReserva').value;
      var txtMotivoVisita = document.getElementById('txtMotivoVisita').value;
      var cmbProfesion = document.getElementById('cmbProfesion').value;
      var cmbMedico = document.getElementById('cmbMedico').value;
      var send = true;
      var data = new Array();

      if(!rbPaciente || rbPaciente.value == '' || rbPaciente.value.length > 1){
        data.push("Seleccione un paciente válido.");
        send = false;
      }
      if(dlFechaReserva == ''){ 
        data.push("Fecha de reservación Obligatorio.");
        send = false;
      }
       if(txtMotivoVisita == ''){
        data.push("Ingrese el motivo de la visita.");
        send = false;
      }
      if(cmbProfesion == ''){ 
        data.push("Especialidad es Obligatorio.");
        send = false;
      }
      if(cmbMedico == ''){ 
        data.push("Médico es Obligatorio.");
        send = false;
      }
      
      data.forEach(mensaje => {
        document.getElementById('alertaLocal').innerHTML += '<div class="alert alert-warning alert-dismissible fade show" role="alert">' + mensaje + '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
      });
      return send;
    }

    function obtenerPacientes(){
      var txtBuscarPaciente = document.getElementById('txtBuscarPaciente').value;

      if(txtBuscarPaciente && txtBuscarPaciente.length > 3){
        document.getElementById('alertaLocalPacientes').innerHTML = '';
        $.ajax({
          type: 'POST',
          data: { valor: txtBuscarPaciente },
          url: "{{ route('pacientes.busqueda') }}",
          success: function(data){
            if(data.pacientes.length > 0){
              $("#alertaLocalPacientes").append('<table class="table table-success table-stripe"><thead><tr><th scope="col">#</th><th scope="col">Nombre</th><th scope="col">Teléfono</th><th scope="col">Correo electrónico</th><th scope="col" class="text-center">Acción</th></tr></thead><tbody id="tablePacientesEncontrados"><tr></tr></tbody></table>');
              $.each(data.pacientes, function(i,v){
                $("#tablePacientesEncontrados").append(
                  '<tr><th scope="row">'+(i+1)+'</th><td>'+v.nombre+' '+v.apellido_paterno+' '+v.apellido_materno+'</td><td>'+v.telefono+'</td><td>'+v.correo_electronico+'</td><td class="text-center"><input class="form-check-input" type="radio" name="idPaciente" id="idPaciente" value='+v.id+'></td></tr>'
                );
              });
            }else{
              document.getElementById('alertaLocalPacientes').innerHTML = '<small class="text-danger">No se encontrarón pacientes.</small>'; //'<div class="alert alert-warning alert-dismissible fade show" role="alert">No se encontraron registros<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
            }
          }, datatype: 'json'
        });
      }
    }

    document.getElementById('cmbProfesion').onchange = function() {
      let elem = document.getElementById("alertaLocalMedico");
      elem.classList.add("d-none");
      $("#cmbMedico").empty().append('<option value="">Seleccione</option>');

      $.ajax({
        type: 'POST',
        data: { idProfesion: this.value },
        url: "{{ route('medicos.profesion') }}",
        success: function(data){
          if(data.medicos.length > 0){
            $.each(data.medicos, function(i,v){
              $("#cmbMedico").append(
                '<option value="'+v.id+'">'+v.nombre+' '+v.apellido_paterno+' '+v.apellido_materno+'</option>'
              );
            });
          }else{
            elem.classList.remove("d-none");
          }
        }, datatype: 'json'
      });
    }
  </script>
@endsection


