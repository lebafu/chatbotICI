<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class preguntas_sin_respuestas extends Model
{
    use HasFactory;

    protected $table = 'preguntas_sin_respuestas';
    protected $primarykey = 'id';
    protected $fillable = [
        'nombre',
        'email',
        'pregunta_sin_respuesta'
    ];

    public $timestamps = true;
}



