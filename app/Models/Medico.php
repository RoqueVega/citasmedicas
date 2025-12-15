<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Medico extends Model
{
    use SoftDeletes;

    protected $table = 'medicos';

    protected $hidden = [
        'created_at', 'updated_at', 'deleted_at'
    ];

    public function genero()
    {
        return $this->belongsTo(Genero::class);
    }

    public function profesiones()
    {
        return $this->belongsToMany(Profesion::class, 'medicos_profesiones');
    }

    public function agendaCitas()
    {
        return $this->hasMany(AgendaCita::class, 'medico_id');
    }
    
    public static function medicosDisponibles()
    {
        $medicos = Medico::get();
        return $medicos;
    }

    public static function medicosActivos()
    {
        $medicos = Medico::where("activo", env('REGISTRO_ACTIVO', 1))->get();
        return $medicos;
    }

    public function profesionesIds()
    {
        $ids = [];
        $profesiones = $this->profesiones;
        if(!is_null($profesiones)){
            foreach ($profesiones as $key => $profesion) {
                array_push($ids, $profesion->id);
            }
        }
        
        return $ids;
    }
}
