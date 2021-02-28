<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Archivo_nlu extends Model
{
    use HasFactory;

    protected $table = 'archivo_nlu';
    protected $primarykey = 'id';
    protected $fillable = [
        'nombre',
    ];

    public $timestamps = false;
}
