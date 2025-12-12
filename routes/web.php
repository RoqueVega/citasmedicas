<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MedicoController;
use App\Http\Controllers\PacienteController;
use App\Http\Controllers\AgendaCitaController;

Route::get('/', function () {
    //return view('login');
    return view('welcome');
});

Route::prefix("medicos")->group(function(){
    Route::get("/", [MedicoController::class,"index"])->name("medicos.index");
    Route::get("/nuevo", [MedicoController::class,"nuevo"])->name("medicos.nuevo");
    Route::post("/guardar", [MedicoController::class,"guardar"])->name("medicos.guardar");
    Route::get("/editar/{id}", [MedicoController::class,"editar"])->name("medicos.editar");
    Route::put("/actualizar/{id}", [MedicoController::class,"actualizar"])->name("medicos.actualizar");
    Route::delete("/eliminar/{id}", [MedicoController::class,"eliminar"])->name("medicos.eliminar");
    Route::post("/profesiones", [MedicoController::class,"obtenerMedicoProfesion"])->name("medicos.profesion");
});

Route::prefix("pacientes")->group(function(){
    Route::get("/", [PacienteController::class,"index"])->name("pacientes.index");
    Route::get("/nuevo", [PacienteController::class,"nuevo"])->name("pacientes.nuevo");
    Route::post("/guardar", [PacienteController::class,"guardar"])->name("pacientes.guardar");
    Route::get("/editar/{id}", [PacienteController::class,"editar"])->name("pacientes.editar");
    Route::put("/actualizar/{id}", [PacienteController::class,"actualizar"])->name("pacientes.actualizar");
    Route::delete("/eliminar/{id}", [PacienteController::class,"eliminar"])->name("pacientes.eliminar");
    Route::post("/obtenerPacientes", [PacienteController::class,"obtenerPacientes"])->name("pacientes.busqueda");
});

Route::prefix("agendacitas")->group(function(){
    Route::get("/", [AgendaCitaController::class,"index"])->name("agenda.citas.index");
    Route::get("/nuevo", [AgendaCitaController::class,"nuevo"])->name("agenda.citas.nuevo");
    Route::post("/guardar", [AgendaCitaController::class,"guardar"])->name("agenda.citas.guardar");
    Route::get("/mostrar/{id}", [AgendaCitaController::class,"mostrar"])->name("agenda.citas.mostrar");
    Route::delete("/eliminar/{id}", [AgendaCitaController::class,"eliminar"])->name("agenda.citas.eliminar");
});

/*
$router->group(['middleware' => 'auth'], function() use ($router){
    $router->group(['prefix' => 'branches'], function() use ($router){
        $router->get('/', [BranchController::class,"index"])->name("branches.index");
        $router->get('/create', [BranchController::class,"create"])->name("branches.create");
        $router->post('/store', [BranchController::class,"store"])->name("branches.store");
        $router->get('/edit/{id}', [BranchController::class,"edit"])->name("branches.edit");
        $router->put('/update/{id}', [BranchController::class,"update"])->name("branches.update");
        $router->delete('/destroy/{id}', [BranchController::class,"destroy"])->name("branches.destroy");
    });
});*/
