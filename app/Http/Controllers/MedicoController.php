<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Redirect;
use App\Models\Medico;
use App\Models\Genero;
use App\Models\Profesion;
use App\Models\MedicoProfesion;

class MedicoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $medicos = Medico::medicosDisponibles();
        return view('medicos.index')->with(['medicos' => $medicos]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function nuevo()
    {
        $medico = new Medico();
        $generos = Genero::generosActivos();
        $profesiones = Profesion::profesionesActivos();
        return view('medicos.nuevo')->with(['medico' => $medico, 'generos' => $generos, 'profesiones' => $profesiones]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function guardar(Request $request)
    {
        $request->validate([
            'nombre' => 'required|min:3|max:50',
            'apellidoPaterno' => 'required|min:3|max:50',
            'apellidoMaterno' => 'required|min:3|max:50',
            'idGenero' => 'required',
            'fechaNacimiento' => 'required|date',
            'activo' => 'required|in:0,1',
            "profesiones"  => 'required|distinct'
        ],
        [
            'nombre.required' => 'Nombre obligatorio.',
            'apellidoPaterno.required' => 'Nombre Ap. Paterno obligatorio.',
            'apellidoMaterno.required' => 'Nombre Ap. Materno obligatorio.',
            'idGenero.required' => 'Género obligatorio.',
            'fechaNacimiento.required' => 'Fecha de macimiento obligatorio.',
            'activo.required' => 'Estado obligatorio.',
            "profesiones.required"  => 'Especialidad obligatorio.'
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

        $profesiones = Profesion::where('activo', env('REGISTRO_ACTIVO', 1))->whereIn("id", $request->profesiones)->get();
        if(COUNT($profesiones) != COUNT($request->profesiones)){
            $this->alerta("Las especialidades seleccionadas no coinciden, actualice e intente de nuevo.", "warning");
            return back()->withInput();
        }

        try {
            $medico = new Medico();
            $medico->genero_id = $request->idGenero;
            $medico->nombre = $request->nombre;
            $medico->apellido_paterno = $request->apellidoPaterno;
            $medico->apellido_materno = $request->apellidoMaterno;
            $medico->fecha_nacimieno = $request->fechaNacimiento;
            $medico->activo = $request->activo;
            $medico->save();
            $medico->profesiones()->sync($request->profesiones);

            $this->alerta("Se guardó correctamente.", "success");
            return redirect()->route("medicos.index");
        } catch (\Throwable $th) {
            $this->alerta("Se presento un error, favor de intentar nuevamente.", "warning");
            return back()->withInput();
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function editar(string $id)
    {
        $medico = Medico::find($id);
        if(is_null($medico)){
            $this->alerta("Ocurrió un error al buscar al médico. Favor de intentar de nuevo.", "warning");
            return redirect()->route("medicos.index");
        }
        $generos = Genero::generosActivos();
        $profesiones = Profesion::profesionesActivos();
        
        return view('medicos.nuevo')->with([
            'medico' => $medico, 
            'generos' => $generos, 
            'profesiones' => $profesiones
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function actualizar(Request $request, string $id)
    {
        $request->validate([
            'nombre' => 'required|min:3|max:50',
            'apellidoPaterno' => 'required|min:3|max:50',
            'apellidoMaterno' => 'required|min:3|max:50',
            'idGenero' => 'required',
            'fechaNacimiento' => 'required|date',
            'activo' => 'required|in:0,1',
            "profesiones"  => 'required|distinct'
        ],
        [
            'nombre.required' => 'Nombre obligatorio.',
            'apellidoPaterno.required' => 'Nombre Ap. Paterno obligatorio.',
            'apellidoMaterno.required' => 'Nombre Ap. Materno obligatorio.',
            'idGenero.required' => 'Género obligatorio.',
            'fechaNacimiento.required' => 'Fecha de macimiento obligatorio.',
            'activo.required' => 'Estado obligatorio.',
            "profesiones.required"  => 'Especialidad obligatorio.'
        ]);

        $idGenero = $request->idGenero;
        if(!Genero::where("id", $idGenero)->exists()){
            $idGenero = 3;
        }

        $profesiones = Profesion::where('activo', env('REGISTRO_ACTIVO', 1))->whereIn("id", $request->profesiones)->get();
        if(COUNT($profesiones) != COUNT($request->profesiones)){
            $this->alerta("Las especialidades seleccionadas no coinciden, actualice e intente de nuevo.", "warning");
            return back()->withInput();
        }
        
        $medico = Medico::find($id);
        if(is_null($medico)){
            $this->alerta("Ocurrió un error al encontrar al médico. Favor de intentar de nuevo.", "warning");
            return back()->withInput();
        }

        $medico->genero_id = $request->idGenero;
        $medico->nombre = $request->nombre;
        $medico->apellido_paterno = $request->apellidoPaterno;
        $medico->apellido_materno = $request->apellidoMaterno;
        $medico->fecha_nacimiento = $request->fechaNacimiento;
        $medico->activo = $request->activo;
        $medico->save();
        $medico->profesiones()->sync($request->profesiones);

        $this->alerta("Se actualizo correctamente.", "success");
        return redirect()->route("medicos.index");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function eliminar(string $id)
    {
        $medico = Medico::find($id);
        if(is_null($medico)){
            $this->alerta("Ocurrió un error al encontrar al médico. Favor de intentar de nuevo.", "warning");
        }else{
            if(COUNT($medico->agendaCitas) > 0){
                $this->alerta("No puede eliminar al médico, ya que tiene citas activas.", "warning");
            }else{
                $medico->delete();
                $medico->profesiones()->sync([]);
                $this->alerta("Se eliminó correctamente.", "danger");
            }
        }
        return redirect()->route("medicos.index");
    }

    /**
     * Obtener los médicos por profesión/especialidad
     */
    public function obtenerMedicoProfesion(Request $request)
    {
        $medicos = [];
        if($request || $request->idProfesion){
            $medicos = Medico::select('medicos.id', 'medicos.nombre', 'medicos.apellido_paterno', 'medicos.apellido_materno')
            ->join('medicos_profesiones', 'medicos_profesiones.medico_id', '=', 'medicos.id')
            ->where('medicos_profesiones.profesion_id', '=', $request->idProfesion)
            ->orderBy('medicos.nombre')
            ->get();
        }
        return response()->json([
            'medicos' => $medicos
        ]);
    }
}
