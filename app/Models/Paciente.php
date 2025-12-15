<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Paciente extends Model
{
    use SoftDeletes;

    protected $table = 'pacientes';

    protected $hidden = [
        'created_at', 'updated_at', 'deleted_at'
    ];

    public function genero()
    {
        return $this->belongsTo(Genero::class);
    }

    public function agendaCitas()
    {
        return $this->hasMany(AgendaCita::class, 'paciente_id');
    }

    public static function pacientesDisponibles()
    {
        $pacientes = Paciente::get();
        return $pacientes;
    }

    public static function pacientesActivos()
    {
        $pacientes = Paciente::where("activo", env('REGISTRO_ACTIVO', 1))->get();
        return $pacientes;
    }
}
