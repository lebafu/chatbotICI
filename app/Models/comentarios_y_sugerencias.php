<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class comentarios_y_sugerencias extends Model
{
    use HasFactory;

    protected $table = 'comentarios_y_sugerencias';
    protected $primarykey = 'id';
    protected $fillable = [
        'nombre',
        'email',
        'comentarios_y_sugerencias'
    ];

    public $timestamps = false;    
}