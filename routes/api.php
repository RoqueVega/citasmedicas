<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MedicoController;
use App\Http\Controllers\PacienteController;
use App\Http\Controllers\AgendaCitaController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application.
|
*/

Route::get("/login", [AuthController::class,"login"])->name("login"); //MOD
Route::post("/sign-in", [AuthController::class,"signIn"])->name("signin");
Route::post("/register", [AuthController::class,"register"])->name("register");
//Route::post("/logout", [AuthController::class,"logout"])->middleware(["auth:api", "addHeaders"])->name("logout");
//Route::post("/refresh", [AuthController::class,"refresh"])->middleware(["auth:api", "addHeaders"])->name("refresh");

//Route::middleware(["auth:api", "addHeaders"])->get('/user', function (Request $request) {
    //return $request->user();
//});

// INICIO RUTAS PARA AUTENTICAR CON TOKEN JWT
$router->group(['middleware' => ['auth:api', 'addHeaders']], function() use ($router){
//$router->group(['middleware' => 'auth:api'], function() use ($router){
    $router->post("/logout", [AuthController::class,"logout"])->name("logout");
    $router->post("/refresh", [AuthController::class,"refresh"])->name("refresh");

    if(env('TEST_MOD_API', 0) == 1){
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
            $router->get("/", [AgendaCitaController::class,"index"])->name("agenda.citas.index");
            $router->get("/nuevo", [AgendaCitaController::class,"nuevo"])->name("agenda.citas.nuevo");
            $router->post("/guardar", [AgendaCitaController::class,"guardar"])->name("agenda.citas.guardar");
            $router->get("/mostrar/{id}", [AgendaCitaController::class,"mostrar"])->name("agenda.citas.mostrar");
            $router->delete("/eliminar/{id}", [AgendaCitaController::class,"eliminar"])->name("agenda.citas.eliminar");
        });
    }
});
// FIN RUTAS PARA AUTENTICAR CON TOKEN JWT