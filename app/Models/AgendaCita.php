<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AgendaCita extends Model
{
    use SoftDeletes;

    protected $table = 'agenda_citas';

    protected $hidden = [
        'created_at', 'updated_at', 'deleted_at'
    ];

    public function genero()
    {
        return $this->belongsTo(Genero::class);
    }

    public function paciente()
    {
        return $this->belongsTo(Paciente::class);
    }

    public function medico()
    {
        return $this->belongsTo(Medico::class);
    }

    public function profesion()
    {
        return $this->belongsTo(Profesion::class);
    }
}
