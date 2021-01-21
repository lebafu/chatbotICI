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
        'habilitada'
    ];

    public $timestamps = false;
}
