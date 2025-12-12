<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Genero extends Model
{
    use SoftDeletes;

    protected $table = 'generos';

    protected $hidden = [
        'created_at', 'updated_at', 'deleted_at'
    ];

    public static function generosActivos()
    {
        $generos = Genero::where("activo", env('REGISTRO_ACTIVO', 1))->get();
        return $generos;
    }
}
