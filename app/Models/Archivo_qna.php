<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Archivo_qna extends Model
{
    use HasFactory;

    protected $table = 'archivo_qna';
    protected $primarykey = 'id';
    protected $fillable = [
        'nombre',
    ];

    public $timestamps = false;
}