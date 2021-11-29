<?php

namespace App\Console\Commands;

use Livewire\Component;
use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\Respuesta_caducada;
use Carbon\Carbon;
use DB;


class Deshabilitar_Fecha_Vencida extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'deshabilitar:fecha_vencida';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Deshabilita respuesta con fecha vencida';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $carbon = new \Carbon\Carbon();
        $fecha_actual = $carbon->now();
        $fecha_actual= strtotime($fecha_actual->format('Y-m-d'));
        $answers=DB::table('answer')->where('vence','=',1)->get();
         $users=DB::table('users')->get();
        //dd('HOLA');
        foreach($answers as $answer){
            //dd($answer,$fecha_actual);
            //var_dump($fecha_actual);
            $fecha_caducacion=strtotime($answer->fecha_caducacion);
            $vence=$answer->vence;
            if(($vence==1 and $fecha_caducacion <= $fecha_actual and $answer->habilitada==1)){
                //Log::info("true en archivo");
                $respuesta_caduca=$answer->nombre;
            $archivos=DB::table('answer')->where('id','=',$answer->id)->get();
            foreach($archivos as $archivo);
              $path_archivo=public_path("botpress12120/data/bots/icibot/qna/".$archivo->archivo_qna.".json");
              
        $leer = fopen($path_archivo, 'r+');
      //if(filesize($path_archivo) > 0){
      //SE ALMACENA LO QUE SE LEE INTERMANETE EN EL ARCHIVO
      //dd($path_archivo);
      //dd($path_archivo,$cadena_final_actual);
      $data = fread($leer, filesize($path_archivo));
      $encuentra2=strpos($data,'"enabled": true,');
      $encuentra3=strpos($data,'"enabled": false,');
      //dd($encuentra2,$encuentra3);
      //dd($data);
      //SE CIERRA EL ARCHIVO QUE SE LEE
      fclose($leer);
      //SI EN EL ARCHIVO ENCUENTRA $patron entonces lo cambiará por $sustitucion y copiará lo demas del archivo data en la variable $datosnuevos
      //EL STRING QUE SE ESTA BUSCANDO EN LOS ARCHIVOS DE LA CARPETA QNA, PARA MODIFICAR ALGUNA DE LAS PREGUNTAS, QUE COMO $patron como 
    //en este caso no lleva coma, sabemos que no será el ultimo del arreglo questions: es:[]
      if($encuentra3==false){
    $patron= '"enabled": true,';
    //dd($patron);
    // LO QUE SE DESEA ESCRIBIR COMO NUEVA PREGUNTA EN LA TABLA QUESTIONS Y EN LA BASE DE DATOS DE BOTPRESS
    $sustitucion='"enabled": false,';
    }
      $datosnuevos = str_replace($patron, $sustitucion, $data); //REEMPLAZA LO QUE CONTINE EL ARCHIVO VIEJO POR EL ARCHIVO NUEVO
      //dd($datosnuevos);
      $escribir = fopen($path_archivo, 'w');
      //dd($datosnuevos);
      //Se escribe en $datosnuevos los en el aarchivo que corresponde
      //dd($datosnuevos);
      fwrite($escribir, $datosnuevos);
      //cerramos la escritura en el archivo
      fclose($escribir);

       //Enviar mail personalizado a usuarios del sistema de chatbot tesis
       foreach($users as $user){
        $details=['nombre'=> $user->name,
                   'respuesta' => $answer->nombre];
                   //Log::info($users,$details);                        
       Mail::to($user->email)->send(new Respuesta_caducada($details));
       }
         DB::table('answer')->where('id','=',$answer->id)->update(['habilitada'=>0]);
          }else{

        }
        
    }
}
}
