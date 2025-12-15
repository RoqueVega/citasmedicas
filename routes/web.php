<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MedicoController;
use App\Http\Controllers\PacienteController;
use App\Http\Controllers\AgendaCitaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    //return view('login');
    return view('welcome');
});
Route::get("/access-login", [UserController::class,"accessLogin"])->name("access.login");
Route::get("/access-register", [UserController::class,"accessRegister"])->name("access.register");

// SIN TOKEN JWT 
if(env('TEST_MOD_API', 0) == 0){
    $router->group(['prefix' => 'medicos'], function() use ($router){
        $router->get("/", [MedicoController::class,"index"])->middleware(["addHeaders"])->name("medicos.index");
        $router->get("/nuevo", [MedicoController::class,"nuevo"])->middleware(["addHeaders"])->name("medicos.nuevo");
        $router->post("/guardar", [MedicoController::class,"guardar"])->middleware(["addHeaders"])->name("medicos.guardar");
        $router->get("/editar/{id}", [MedicoController::class,"editar"])->middleware(["addHeaders"])->name("medicos.editar");
        $router->put("/actualizar/{id}", [MedicoController::class,"actualizar"])->middleware(["addHeaders"])->name("medicos.actualizar");
        $router->delete("/eliminar/{id}", [MedicoController::class,"eliminar"])->middleware(["addHeaders"])->name("medicos.eliminar");
        $router->post("/profesiones", [MedicoController::class,"obtenerMedicoProfesion"])->middleware(["addHeaders"])->name("medicos.profesion");
    });


    $router->group(['prefix' => 'pacientes'], function() use ($router){
        $router->get("/", [PacienteController::class,"index"])->middleware(["addHeaders"])->name("pacientes.index");
        $router->get("/nuevo", [PacienteController::class,"nuevo"])->middleware(["addHeaders"])->name("pacientes.nuevo");
        $router->post("/guardar", [PacienteController::class,"guardar"])->middleware(["addHeaders"])->name("pacientes.guardar");
        $router->get("/editar/{id}", [PacienteController::class,"editar"])->middleware(["addHeaders"])->name("pacientes.editar");
        $router->put("/actualizar/{id}", [PacienteController::class,"actualizar"])->middleware(["addHeaders"])->name("pacientes.actualizar");
        $router->delete("/eliminar/{id}", [PacienteController::class,"eliminar"])->middleware(["addHeaders"])->name("pacientes.eliminar");
        $router->post("/obtenerPacientes", [PacienteController::class,"obtenerPacientes"])->middleware(["addHeaders"])->name("pacientes.busqueda");
    });


    $router->group(['prefix' => 'agendacitas'], function() use ($router){
        $router->get("/", [AgendaCitaController::class,"index"])->middleware(["addHeaders"])->name("agenda.citas.index");
        $router->get("/nuevo", [AgendaCitaController::class,"nuevo"])->middleware(["addHeaders"])->name("agenda.citas.nuevo");
        $router->post("/guardar", [AgendaCitaController::class,"guardar"])->middleware(["addHeaders"])->name("agenda.citas.guardar");
        $router->get("/mostrar/{id}", [AgendaCitaController::class,"mostrar"])->middleware(["addHeaders"])->name("agenda.citas.mostrar");
        $router->delete("/eliminar/{id}", [AgendaCitaController::class,"eliminar"])->middleware(["addHeaders"])->name("agenda.citas.eliminar");
    });
}