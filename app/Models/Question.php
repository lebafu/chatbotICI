<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $table = 'questions';
    protected $primarykey = 'id';
    protected $fillable = [
        'pregunta',
        'id_answers',
            ];

    public $timestamps = false;

    public function Answers()
    {
        return $this->belongsTo('App\Models\Answers','id_answers','id');
    }
}
