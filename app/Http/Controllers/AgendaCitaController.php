<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Redirect;
use App\Models\AgendaCita;
use App\Models\Medico;
use App\Models\Paciente;
use App\Models\Profesion;

class AgendaCitaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $agendaCitas = AgendaCita::all();
        return view('agendacitas.index')->with(['agendaCitas' => $agendaCitas]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function nuevo()
    {
        $medicos = Medico::medicosDisponibles();
        $pacientes = Paciente::pacientesDisponibles();
        $profesiones = Profesion::profesionesActivos();

        return view('agendacitas.nuevo')->with([
            'profesiones' => $profesiones, 
            'medicos' => $medicos, 
            'pacientes' => $pacientes
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function guardar(Request $request)
    {
        $request->validate([
            'idPaciente' => 'required',
            'idMedico' => 'required',
            'idProfesion' => 'required',
            'motivoVisita' => 'required|max:300',
            'fechaReserva' => 'required|date',
        ],
        [
            'idPaciente.required' => 'Paciente obligatorio.',
            'idMedico.required' => 'Médico obligatorio.',
            'idProfesion.required' => 'Especialidad obligatorio.',
            'motivoVisita.required' => 'Género obligatorio.',
            'motivoVisita.max' => 'El motivo de la vistia excede el limite de caracteres.',
            'fechaReserva.required' => 'Fecha de reservación obligatorio.',
            'fechaReserva.date' => 'Ingrese un valor valido en la fecha de reservación.',
        ]);

        $fechaActual = date('Y-m-d H:i:s');
        $fechaReserva = date('Y-m-d H:i:s',((new \DateTime($request->fechaReserva))->getTimestamp()));
        if($fechaReserva < $fechaActual) {
            $this->alerta("La fecha de reserva debe ser mayor o igual a la fecha actual.", "warning");
            return back()->withInput();
        }

        if(!Paciente::where("id", $request->idPaciente)->exists()){
            $this->alerta("Ocurrió un error al encontrar el paciente, actualice e intente nuevamente.", "warning");
            return back()->withInput();
        }

        $profesion = Profesion::where('activo', env('REGISTRO_ACTIVO', 1))->where("id", $request->idProfesion)->first();
        if(!$profesion || is_null($profesion)){
            $this->alerta("Ocurrió un error al encontrar la especialidad, actualice e intente nuevamente.", "warning");
            return back()->withInput();
        }

        $medico = Medico::where("id", $request->idMedico)->first();
        if(!$medico || is_null($medico)){
            $this->alerta("Ocurrió un error al encontrar el médico, actualice e intente nuevamente.", "warning");
            return back()->withInput();
        }

        if(!in_array($profesion->id, $medico->profesionesIds())){
            $this->alerta("Ocurrió un error al encontrar la relacion del médico con la especialidad, actualice e intente nuevamente.", "warning");
            return back()->withInput();
        }
        
        $agendaCita = new AgendaCita();
        $agendaCita->paciente_id = $request->idPaciente;
        $agendaCita->medico_id = $request->idMedico;
        $agendaCita->profesion_id = $request->idProfesion;
        $agendaCita->fecha_reservacion = $request->fechaReserva;
        $agendaCita->motivo_visita = $request->motivoVisita;
        $agendaCita->save();

        $this->alerta("Se agendó la cita correctamente.", "success");
        return redirect()->route('agenda.citas.mostrar', $agendaCita->id);
    }

    /**
     * Display the specified resource.
     */
    public function mostrar(string $id)
    {
        $agendaCita = AgendaCita::find($id);
        if(is_null($agendaCita)){
            $this->alerta("Ocurrió un error al encontrar la cita. Actualice e intente de nuevo.", "warning");
            return redirect()->route("agendacita.index");
        }
        
        return view('agendacitas.mostrar')->with([
            'agendaCita' => $agendaCita
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function eliminar(string $id)
    {
        $agendaCita = AgendaCita::find($id);
        if(is_null($agendaCita)){
            $this->alerta("Ocurrió un error al encontrar al médico. Favor de intentar de nuevo.", "warning");
        }else{
            $agendaCita->delete();
            $this->alerta("Se eliminó correctamente.", "danger");
        }
        return redirect()->route("agenda.citas.index");
    }
}
