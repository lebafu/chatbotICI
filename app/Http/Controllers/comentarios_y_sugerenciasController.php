<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\comentarios_y_sugerencias;
use Redirect;

class comentarios_y_sugerenciasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(){
      $datos=DB::table('comentarios_y_sugerencias')->paginate(7);
      return view('comentarios.index',compact('datos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request){
      //dd($request);
      DB::table('comentarios_y_sugerencias')->insert(['nombre'=>$request->nombre,'email'=>$request->email,'comentarios_y_sugerencias'=>$request->comentarios]);
      return view('qna.comentario_almacenado_correctamente');
    }


    public function show_comentario($id)
    {
        $comentario=DB::table('comentarios_y_sugerencias')->where('id','=',$id)->first();
        //dd($comentario);
        return view('qna.show',compact('comentario'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    public function destroy($id){
        //dd($id);
        $comentarios=DB::table('comentarios_y_sugerencias')->where('id','=',$id)->get();
        foreach($comentarios as $comentario);
        DB::table('comentarios_y_sugerencias')->where('id','=',$id)->delete();
        return view('qna.mensaje_eliminar_comentario',compact('comentario'));
    }
}    