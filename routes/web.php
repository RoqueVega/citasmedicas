<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MedicoController;
use App\Http\Controllers\PacienteController;
use App\Http\Controllers\AgendaCitaController;

Route::get('/', function () {
    //return view('login');
    //return view('welcome');
    return view('auth.login');
});

Route::get('/hola-mundo', function(){
    return "Holaa mundo";
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

$router->group(['middleware' => 'auth'], function() use ($router){

    $router->group(['prefix' => 'medicos'], function() use ($router){
        //$router->get('/hola-mundo', function(){ return "Ruta test, hola."; });
        $router->get("/", [MedicoController::class,"index"])->name("medicos.index");
        $router->get("/nuevo", [MedicoController::class,"nuevo"])->name("medicos.nuevo");
        $router->post("/guardar", [MedicoController::class,"guardar"])->name("medicos.guardar");
        $router->get("/editar/{id}", [MedicoController::class,"editar"])->name("medicos.editar");
        $router->put("/actualizar/{id}", [MedicoController::class,"actualizar"])->name("medicos.actualizar");
        $router->delete("/eliminar/{id}", [MedicoController::class,"eliminar"])->name("medicos.eliminar");
        $router->post("/profesiones", [MedicoController::class,"obtenerMedicoProfesion"])->name("medicos.profesion");
    });

    $router->group(['prefix' => 'pacientes'], function() use ($router){
        $router->get("/", [PacienteController::class,"index"])->name("pacientes.index");
        $router->get("/nuevo", [PacienteController::class,"nuevo"])->name("pacientes.nuevo");
        $router->post("/guardar", [PacienteController::class,"guardar"])->name("pacientes.guardar");
        $router->get("/editar/{id}", [PacienteController::class,"editar"])->name("pacientes.editar");
        $router->put("/actualizar/{id}", [PacienteController::class,"actualizar"])->name("pacientes.actualizar");
        $router->delete("/eliminar/{id}", [PacienteController::class,"eliminar"])->name("pacientes.eliminar");
        $router->post("/obtenerPacientes", [PacienteController::class,"obtenerPacientes"])->name("pacientes.busqueda");
    });

    $router->group(['prefix' => 'agendacitas'], function() use ($router){
        Route::get("/", [AgendaCitaController::class,"index"])->name("agenda.citas.index");
        Route::get("/nuevo", [AgendaCitaController::class,"nuevo"])->name("agenda.citas.nuevo");
        Route::post("/guardar", [AgendaCitaController::class,"guardar"])->name("agenda.citas.guardar");
        Route::get("/mostrar/{id}", [AgendaCitaController::class,"mostrar"])->name("agenda.citas.mostrar");
        Route::delete("/eliminar/{id}", [AgendaCitaController::class,"eliminar"])->name("agenda.citas.eliminar");
    });
});

/*
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
*/