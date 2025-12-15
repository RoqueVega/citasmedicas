<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MedicoProfesion extends Model
{
    protected $table = 'medicos_profesiones';
    protected $primaryKey = ['medico_id', 'profesion_id'];
    protected $incrementing = false;
    protected $fillable = ['medico_id', 'profesion_id'];
}
