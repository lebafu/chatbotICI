<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
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
    protected $description = 'Deshabilita respuesta con fechaa vencida';

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
        $answers=DB::table('answer')->get();
        //dd('HOLA');
        foreach($answers as $answer){
            //dd($answer,$fecha_actual);
            //var_dump($fecha_actual);
            $fecha_caducacion=strtotime($answer->fecha_caducacion);
            if(($fecha_caducacion <= $fecha_actual)){
                DB::table('answer')->where('id','<=',$answer->id)->update(['habilitada'=>0]);

            $archivos=DB::table('answer')->where('id','=',$answer->id)->get();
            foreach($archivos as $archivo);
              $path_archivo=public_path("botpress12120/data/icibot/qna/".$archivo->archivo_qna.".json");
              
        $leer1 = fopen($path_archivo, 'r');
        $numlinea=0;
        while ($linea = fgets($leer1)){
        //echo $linea.'<br/>';
            if((substr($linea,15,-2))==true){
                Log::info("true en archivo");
            $aux[] = str_replace("true","false",$aux[$numlinea]);    
             $numlinea++;
            }
        }
        fclose($leer1);
        unlink($path_archivo);

        //$contenido=file_get_contents($path_archivo);
         $contenido=null;
         $tam_array_aux=count($aux);
      while($i<$tam_array_aux){
        $contenido .=$aux_[$i];
        $i=$i+1;
      }
        
        $escribir = fopen($path_archivo, 'w+');
         //fwrite($escribir1, $data1);
        fwrite($escribir, $contenido);
       fclose($escribir);
          }else{

          }
        }
        
    }
}
