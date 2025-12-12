<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Redirect;
use App\Models\Medico;
use App\Models\Genero;
use App\Models\Paciente;

class PacienteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pacientes = Paciente::pacientesDisponibles();
        return view('pacientes.index')->with(['pacientes' => $pacientes]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function nuevo()
    {
        $paciente = new Paciente();
        $generos = Genero::generosActivos();

        return view('pacientes.nuevo')->with([
            'paciente' => $paciente, 
            'generos' => $generos
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function guardar(Request $request)
    {
        $request->validate([
            'nombre' => 'required|max:50',
            'apellidoPaterno' => 'required|max:50',
            'apellidoMaterno' => 'required|max:50',
            'telefono' => 'required|min:10|max:10',
            'idGenero' => 'required',
            'fechaNacimiento' => 'required|date',
            'correoElectronico' => 'nullable|email',
            'activo' => 'required|in:0,1'
        ],
        [
            'nombre.required' => 'Nombre obligatorio.',
            'apellidoPaterno.required' => 'Nombre Ap. Paterno obligatorio.',
            'apellidoMaterno.required' => 'Nombre Ap. Materno obligatorio.',
            'idGenero.required' => 'Género obligatorio.',
            'telefono.required' => 'Teléfono obligatorio.',
            'fechaNacimiento.required' => 'Fecha de macimiento obligatorio.',
            'correoElectronico.email' => 'Correo electrónico inválido.',
            'activo.required' => 'Estado obligatorio.'
        ]);

        $fechaActual = date('Y-m-d');
        if($request->fechaNacimiento >= $fechaActual) {
            $this->alerta("La fecha de nacimiento debe de ser menor a la fecha actual.", "warning");
            return back()->withInput();
        }

        $idGenero = $request->idGenero;
        if(!Genero::where("id", $idGenero)->exists()){
            $idGenero = 3;
        }

        $paciente = new Paciente();
        $paciente->genero_id = $request->idGenero;
        $paciente->nombre = $request->nombre;
        $paciente->apellido_paterno = $request->apellidoPaterno;
        $paciente->apellido_materno = $request->apellidoMaterno;
        $paciente->telefono = $request->telefono;
        $paciente->fecha_nacimiento = $request->fechaNacimiento;
        $paciente->correo_electronico = $request->correoElectronico;
        $paciente->activo = $request->activo;
        $paciente->save();

        $this->alerta("Se guardó correctamente.", "success");
        return redirect()->route("pacientes.index");
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function editar(string $id)
    {
        $paciente = Paciente::find($id);
        if(is_null($paciente)){
            $this->alerta("Ocurrió un error al buscar al paciente. Favor de intentar de nuevo.", "warning");
            return redirect()->route("pacientes.index");
        }
        $generos = Genero::generosActivos();

        return view('pacientes.nuevo')->with([
            'paciente' => $paciente, 
            'generos' => $generos
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function actualizar(Request $request, string $id)
    {
        $request->validate([
            'nombre' => 'required|max:50',
            'apellidoPaterno' => 'required|max:50',
            'apellidoMaterno' => 'required|max:50',
            'telefono' => 'required|min:10|max:10',
            'idGenero' => 'required',
            'fechaNacimiento' => 'required|date',
            'correoElectronico' => 'nullable|email',
            'activo' => 'required|in:0,1'
        ],
        [
            'nombre.required' => 'Nombre obligatorio.',
            'apellidoPaterno.required' => 'Nombre Ap. Paterno obligatorio.',
            'apellidoMaterno.required' => 'Nombre Ap. Materno obligatorio.',
            'idGenero.required' => 'Género obligatorio.',
            'telefono.required' => 'Teléfono obligatorio.',
            'fechaNacimiento.required' => 'Fecha de macimiento obligatorio.',
            'correoElectronico.email' => 'Correo electrónico inválido.',
            'activo.required' => 'Estado obligatorio.'
        ]);

        $fechaActual = date('Y-m-d');
        if($request->fechaNacimiento >= $fechaActual) {
            $this->alerta("La fecha de nacimiento debe de ser menor a la fecha actual.", "warning");
            return back()->withInput();
        }

        $idGenero = $request->idGenero;
        if(!Genero::where("id", $idGenero)->exists()){
            $idGenero = 3;
        }

        $paciente = Paciente::find($id);
        if(is_null($paciente)){
            $this->alerta("Ocurrió un error al encontrar al paciente. Favor de intentar de nuevo.", "warning");
            return back()->withInput();
        }
        $paciente->genero_id = $request->idGenero;
        $paciente->nombre = $request->nombre;
        $paciente->apellido_paterno = $request->apellidoPaterno;
        $paciente->apellido_materno = $request->apellidoMaterno;
        $paciente->telefono = $request->telefono;
        $paciente->fecha_nacimiento = $request->fechaNacimiento;
        $paciente->correo_electronico = $request->correoElectronico;
        $paciente->activo = $request->activo;
        $paciente->save();

        $this->alerta("Se actualizo correctamente.", "success");
        return redirect()->route("pacientes.index");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function eliminar(string $id)
    {
        $paciente = Paciente::find($id);
        if(is_null($paciente)){
            $this->alerta("Ocurrió un error al encontrar al paciente. Favor de intentar de nuevo.", "warning");
        }else{
            $paciente->delete();
            $this->alerta("Se eliminó correctamente.", "danger");
        }
        return redirect()->route("pacientes.index");
    }

    /**
     * Obtener los pacientes por nombre, apellidos y correo electrónico.
     */
    public function obtenerPacientes(Request $request)
    {
        $pacientes = [];
        if($request->valor && !is_null($request->valor)){
            $pacientes = Paciente::select('id', 'nombre','apellido_paterno', 'apellido_materno','telefono', 'correo_electronico')
            ->where('activo', env('REGISTRO_ACTIVO', 1))
			->where('nombre', 'like', '%' . $request->valor . '%')
			->orWhere('apellido_paterno', 'like', '%' . $request->valor . '%')
			->orWhere('apellido_materno', 'like', '%' . $request->valor . '%')
            ->orWhere('telefono', 'like', '%' . $request->valor . '%')
            ->orWhere('correo_electronico', 'like', '%' . $request->valor . '%')
            ->orderBy('nombre')
            ->get();
        }
        
        return response()->json([
            'pacientes' => $pacientes
        ]);
    }
}
