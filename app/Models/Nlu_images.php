<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class nlu_images extends Model
{
    use HasFactory;

    protected $table = 'nlus_images';
    protected $primarykey = 'id';
    protected $fillable = [
        'codigo_imagen_nlu',
        'ruta_imagen_nlu'
    ];

    public $timestamps = false;
}
