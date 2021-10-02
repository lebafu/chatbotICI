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
        'nombre'
    ];

    public $timestamps = false;

    public function Answers() {
      return $this->hasOne('App\Models\Answers','id_categoria');
    }
}
