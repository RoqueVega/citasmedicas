@extends('disenos_base.index')

@section('title', 'Detalle de la cita')

@section('content')
  <section>
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <a href="{{ route('agenda.citas.index') }}" class="btn btn-primary text-white mb-3 float-end">Regresar</a>
        </div>
        <div class="col-md-12">
          <div class="card">
            <div class="card-body">
              @include('disenos_base.alertas_session')
              <h2 class="text-center mb-5">Detalle de la Cita</h2>
              <div class="col-md-12" id="alertaLocal">
              </div>
              <div class="row">
                <div class="col-md-3 mb-5">
                  <label for="txtFechaReserva" class="form-label">Fecha de Reserva:</label>
                  <input type="text" class="form-control" id="txtFechaReserva" value="{{ @$agendaCita->fecha_reservacion }}" disabled>
                </div>
                <div class="col-md-12">
                  <h3>Paciente</h3>
                </div>
                <div class="col-md-6 mb-3">
                  <label for="txtPaciente" class="form-label">Nombre:</label>
                  <input type="text" class="form-control" id="txtPaciente" value="{{ @$agendaCita->paciente->nombre }}" disabled>
                </div>
                <div class="col-md-6 mb-3">
                  <label for="txtTelefono" class="form-label">Teléfono:</label>
                  <input type="text" class="form-control" id="txtTelefono" value="{{ @$agendaCita->paciente->telefono }}" disabled>
                </div>
                <div class="col-md-6 mb-3">
                  <label for="txtCorreoElectronico" class="form-label">Correo electrónico:</label>
                  <input type="text" class="form-control" id="txtCorreoElectronico" value="{{ @$agendaCita->paciente->correo_electronico }}" disabled>
                </div>
                <div class="col-md-6 mb-3">
                  <label for="txtMotivoVisita" class="form-label">Motivo de visita</label>
                  <textarea class="form-control" id="txtMotivoVisita" rows="1" disabled>{{ $agendaCita->motivo_visita }}</textarea>
                </div>
                <div class="col-md-12">
                  <h3>Médico</h3>
                </div>
                <div class="col-md-6 mb-3">
                  <label for="txtMedico" class="form-label">Nombre:</label>
                  <input type="text" class="form-control" id="txtMedico" value="{{ @$agendaCita->medico->nombre }}" disabled>
                </div>
                <div class="col-md-6 mb-3">
                  <label for="txtEspecialidad" class="form-label">Especialidad:</label>
                  <input type="text" class="form-control" id="txtEspecialidad" value="{{ @$agendaCita->profesion->nombre }}" disabled>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection


