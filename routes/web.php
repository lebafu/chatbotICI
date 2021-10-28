<?php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\IndexUsuarios;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
	    return view('dashboard');
	})->name('dashboard');

Route::view('/retroalimentacion','retroalimentacion')->name('retroalimentacion');

Route::middleware(['auth'])->group(function () {

	Route::get('/', function () {
	    return view('dashboard');
	});

	Route::get('/home', function () {
	    return view('dashboard');
	});

	Route::get('/send-email',[IndexUsuarios::class, 'sendEmail']);

	//Rutas livewire
	Route::view('/qna_index','qna.qna_name_index')->name('qna_index');
	Route::view('/index_comentarios','comentarios.index')->name('index_comentarios');
	Route::view('/index_preguntas_sugeridas','qna.index_preguntas_sin_respuestas')->name('index_preguntas_sugeridas');
	Route::view('/usuarios','users.index')->name('usuarios');
});