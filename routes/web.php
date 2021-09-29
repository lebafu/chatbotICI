<?php

use Illuminate\Support\Facades\Route;

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

Route::middleware(['auth'])->group(function () {

	Route::get('/', function () {
	    return view('dashboard');
	});

	Route::get('/home', function () {
	    return view('dashboard');
	});

	//Rutas livewire
	Route::view('/retroalimentacion','retroalimentacion')->name('retroalimentacion');
	Route::view('/qna_index','qna.qna_name_index')->name('qna_index');
	Route::view('/index_comentarios','comentarios.index')->name('index_comentarios');
	Route::view('/index_preguntas_sugeridas','qna.index_preguntas_sin_respuestas')->name('index_preguntas_sugeridas');
	
	Route::post('/pregunta_sin_respuesta','QnAController@pregunta_sin_respuesta')->name('qna.pregunta_sin_respuesta');
	Route::post('almacenado_comentario_sugerencia','QnAController@store_comentarios_y_sugerencias')->name('qna.store_comentarios_y_sugerencias');
	Route::get('/qna_index{id}','QnaController@index')->name('qna.index');
	Route::get('/qna_create', 'QnAController@create')->name('qna.create');
	Route::post('/qna','QnAController@store')->name('qna.store');
	Route::get('/qna_edit{id}', 'QnAController@edit')->name('qna.edit');
	Route::get('/qna_asignar_respuesta{id}', 'QnAController@asignar_preguntas_sin_respuestas')->name('qna.asignar_respuesta');
	Route::get('/qna_asignar_answer_input{id}', 'QnAController@asignar_pregunta_sin_answer_input')->name('qna.asignar_answer_input');
	Route::get('/qna_habilitada{id}', 'QnAController@habilitada')->name('qna.habilitada');
	Route::put('/actualizarqna{nlu_question}','QnAController@update')->name('qna.update');
	Route::post('/qna','QnAController@store')->name('qna.store');
});