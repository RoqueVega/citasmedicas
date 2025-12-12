<nav class="navbar navbar-expand-lg navbar navbar-dark bg-primary">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ route('agenda.citas.nuevo') }}"><img src="{{ asset('assets/images/icono-medicina1.png') }}" alt="" style="width: 50px;"></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link fs-5 active" aria-current="page" href="{{ route('agenda.citas.nuevo') }}">Cita</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fs-5" aria-current="page" href="{{ route('agenda.citas.index') }}">Agenda</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link fs-5 dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Catálogos
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="{{ route('medicos.index') }}">Médicos</a></li>
                        <li><a class="dropdown-item" href="{{ route('pacientes.index') }}">Pacientes</a></li>
                    </ul>
                </li>
            </ul>
            <form class="d-flex">
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success" type="submit">Search</button>
            </form>
        </div>
    </div>
</nav>