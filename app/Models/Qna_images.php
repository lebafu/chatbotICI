<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class qna_images extends Model
{
    use HasFactory;
    protected $table = 'qnas_images';
    protected $primarykey = 'id';
    protected $fillable = [
        'nombre_imagen_qna',
        'id_answer'
    ];

    public $timestamps = false;
}
