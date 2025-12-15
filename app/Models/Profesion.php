<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Profesion extends Model
{
    use SoftDeletes;

    protected $table = 'profesiones';

    protected $hidden = [
        'created_at', 'updated_at', 'deleted_at'
    ];

    public function medicos()
    {
        return $this->belongsToMany(Medico::class, 'medicos_profesiones');
    }

    public static function profesionesActivos()
    {
        $profesiones = Profesion::where("activo", env('REGISTRO_ACTIVO', 1))->get();
        return $profesiones;
    }
}
