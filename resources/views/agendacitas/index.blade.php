@extends('disenos_base.index')

@section('title', 'Agenda de Citas')

@section('content')
    <section>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    @include('disenos_base.alertas_session')
                </div>
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h2 class="text-center mb-2">Agenda de citas</h2>
                            <table class="table">
                                <thead>
                                    <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Paciente</th>
                                    <th scope="col">Médico</th>
                                    <th scope="col">Especialidad</th>
                                    <th scope="col">Fecha</th>
                                    <th scope="col">Télefono</th>
                                    <th scope="col" class="text-center">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $contador = 0; @endphp
                                    @if(COUNT($agendaCitas) > 0)
                                    @foreach($agendaCitas as $agendaCita)
                                    @php($contador++)
                                    <tr>
                                        <th scope="row">{{ $contador }}</th>
                                        <td>{{ $agendaCita->paciente->nombre }} {{ $agendaCita->paciente->apellido_paterno }} {{ $agendaCita->paciente->apellido_materno }}</td>
                                        <td>{{ $agendaCita->medico->nombre }} {{ $agendaCita->medico->apellido_paterno }} {{ $agendaCita->medico->apellido_materno }}</td>
                                        <td>{{ $agendaCita->profesion->nombre }}</td>
                                        <td>{{ $agendaCita->fecha_reservacion }}</td>
                                        <td>{{ $agendaCita->paciente->telefono }}</td>
                                        <td class="d-flex justify-content-center">
                                            <a href=" {{ route('agenda.citas.mostrar', $agendaCita->id ) }}" class="btn btn-secondary text-white" style="margin-right: 10px;">Ver</a>
                                            <form action="{{ route('agenda.citas.eliminar', $agendaCita->id ) }}" method="POST">
                                                @csrf
                                                @method("delete")
                                                <button class="btn btn-danger">
                                                    Eliminar
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                    @else
                                    <tr>
                                        <td scope="row" colspan="8" class="text-danger text-center">Sin registros...</td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
