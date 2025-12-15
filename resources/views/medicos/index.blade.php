@extends('disenos_base.index')

@section('title', 'Catálogo de Médicos')

@section('content')
    <div class="container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-lg-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="">Inicio</a></li>
                        <li class="breadcrumb-item active"><a href="{{ route('medicos.index') }}">Médicos</a></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <section>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <a href="{{ route('medicos.nuevo') }}" class="btn btn-primary text-white mb-3 float-end">Crear</a>
                </div>
                <div class="col-md-12">
                    @include('disenos_base.alertas_session')
                </div>
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h2 class="text-center mb-2">Catálogo de Médicos</h2>
                            <table class="table">
                                <thead>
                                    <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Nombre</th>
                                    <th scope="col">Ap. Paterno</th>
                                    <th scope="col">Ap. Materno</th>
                                    <th scope="col">Género</th>
                                    <th scope="col" class="text-center">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $contador = 0; @endphp
                                    @if(COUNT($medicos) > 0)
                                    @foreach($medicos as $medico)
                                    @php($contador++)
                                    <tr>
                                        <th scope="row">{{ $contador }}</th>
                                        <td>{{ $medico->nombre }}</td>
                                        <td>{{ $medico->apellido_paterno }}</td>
                                        <td>{{ $medico->apellido_materno }}</td>
                                        <td>{{ $medico->genero->nombre }}</td>
                                        <td class="d-flex justify-content-center">
                                            <a href=" {{ route('medicos.editar', $medico->id ) }}" class="btn btn-info text-white" style="margin-right: 10px;">Editar</a>
                                            <form action="{{ route('medicos.eliminar', $medico->id ) }}" method="POST">
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
                                        <td scope="row" colspan="7" class="text-danger text-center">Sin registros...</td>
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
