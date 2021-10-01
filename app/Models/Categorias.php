<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categorias extends Model
{
    use HasFactory;

    protected $table = 'categorias';
    protected $primarykey = 'id';
    protected $fillable = [
        'nombre',
        'id_categoria'
    ];

    public $timestamps = false;
}
