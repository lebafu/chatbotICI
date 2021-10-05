<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answers extends Model
{
    use HasFactory;

    protected $table = 'answer';
    protected $primarykey = 'id';
    protected $fillable = [
        'nombre',
        'vence',
        'fecha_caducacion',
        'id_categoria',
        'archivo_qna',
        'habilitada'
    ];

    public $timestamps = true;

    public function Categorias()
    {
        return $this->belongsTo('App\Models\Categorias','id_categoria','id');
    }

    public function Question() {
      return $this->hasMany('App\Models\Question','id_answers');
    }

}