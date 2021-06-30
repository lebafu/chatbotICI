<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;


class QuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
                    //$directorio1="public/botpress12120/data/bots/ucm-botpress1/intents";
                 //$directorio2="public/botpress12120/data/bots/ucm-botpress1/qna/";
                 $directorio1="public/botpress12120/data/bots/icibot/intents";
                 $directorio2="public/botpress12120/data/bots/icibot/qna/";
         //dd($directorio1);
      //Se creaa arreglo para guadar direccion de archivos de carpeta
      $res = array();

  // Agregamos la barra invertida al final en caso de que no exista
  if(substr($directorio1, -1) != "/") $directorio1 .= "/";

  // Creamos un puntero al directorio y obtenemos el listado de archivos
  $dir1 = @dir($directorio1) or die("getFileList: Error abriendo el directorio $directorio1 para leerlo");
  while(($archivo1 = $dir1->read()) !== false) {
      // Obviamos los archivos ocultos
      if($archivo1[0] == ".") continue;
      if(is_dir($directorio1 . $archivo1)) {
          $res[] = array(
            "Nombre" => $directorio1 . $archivo1 . '"/"',
            "Tamaño" => 0,
            "Modificado" => filemtime($directorio1 . $archivo1)
          );
      } else if (is_readable($directorio1 . $archivo1)) {
          $res[] = array(
            "Nombre" => $directorio1 . $archivo1,
            "Tamaño" => filesize($directorio1 . $archivo1),
            "Modificado" => filemtime($directorio1 . $archivo1)
          );
      }
  }

  $tam=sizeof($res);

  //dd($res[$i]["Nombre"]);
  $array_nombre=array();
  $nombre_sin_qna=array();
  $res_nombres=array();
  $i=0;
  //Si el valor de i es menor a la cantidad de archivos entonces saldrá del ciclo while
  $j=0;
   while($i<$tam){
   		 if((strpos($res[$i]["Nombre"],'qna'))==false){
   		 }else{
 		 $res_nombres[$j]=substr($res[$i]["Nombre"],53,-5);
 		 $j=$j+1;
         /*if(($res[$i]["Nombre"])){
  		 	$path_archivo=("C:/Users/LI/Desktop/chatbot/public/".$res_nombre[$i]);
  		}*/
  	}
  		$i=$i+1;
    }
   
    $tam_nombres=sizeof($res_nombres);
    $i=0;
    //dd($res_nombres[$i]);
    while($i<$tam_nombres){
    	$path_archivo=$directorio2.$res_nombres[$i].'.json';
    	//dd($path_archivo);
    	$aux=null;
    	if($i==1){
    		//dd($path_archivo);
    	}
    	$leer = fopen($path_archivo, 'r+');

    	$numlinea=0;
    	while ($linea = fgets($leer)) {
    		//echo $linea.'<br/>';
            $aux[] = $linea;    
             $numlinea++;
        }
        //if($i==4){
        //dd($path_archivo,$leer,$i,$aux);
        //}
        //$largo_archivo=sizeof($aux);
        $pos1=strpos($aux[11],']');
        if($pos1!=false){
        	//dd($aux);
        	//dd(substr($aux[10],-1));
        	$nombre=substr($aux[10],9,-2);
        	/*if($i==4){
    		dd($nombre);
    	    }*/
        	//dd($nombre);
        	$answers=DB::table('answer')->where('nombre','=',$nombre)->get();
        	foreach($answers as $answer);
        	$j=15;
        	$pos2=strpos($aux[$j],']');
        	while($pos2==false){
        		$pos2=strpos($aux[$j],']');
        		$pos3=strpos($aux[$j+1],']');
        		if($pos2==false and $pos3!=false){
        		$pregunta=(substr($aux[$j],9,-2));
        		}else{
        			$pregunta=(substr($aux[$j],9,-3));
        			//dd($pregunta)
        		}
        	    //if($pregunta==0){
                for($k=0;$k<strlen($pregunta);$k++){
	                if($k==0 and $pregunta[$k]=='?'){
	                	$pregunta[$k]='¿';
	                }
 				}
 				$tam_pregunta=strlen($pregunta);
 				if($tam_pregunta!=0){
        		DB::table('questions')->insert(['pregunta'=>$pregunta,'id_answers'=>$answer->id]);
        	    }
        		//dd($aux);
        		//PROBLEMA ERAN LOS IFS
        		$j=$j+1;
        	//}
        	 
    	}
    }else{
    	//dd($aux);

    	$nombre=substr($aux[9],14,-4);
    	$question=substr($aux[12],15,-5);
      //dd($nombre,$question,$path_archivo);
      if($nombre==false and $question==false){
            //dd($nombre,$question,$answer,$path_archivo);
            $l=13;
            $nombre=substr($aux[$numlinea-4],21,-3);
            $question=substr($aux[$l],9,-3);
            //dd($nombre,$question,$answer,$path_archivo);
          $answers=DB::table('answer')->where('nombre','=',$nombre)->get();
          foreach($answers as $answer);
          //dd($nombre,$question,$answer,$path_archivo);
            $buscar_coma=strpos($aux[$l],',');
              while($buscar_coma!=false){
                $pregunta=substr($aux[$l],9,-3);
                //dd($nombre,$question,$answer,$path_archivo);
                DB::table('questions')->insert(['pregunta'=>$pregunta,'id_answers'=>$answer->id]);
                $l=$l+1;
                $buscar_coma=strpos($aux[$l],',');
              }
              $question=substr($aux[$l],9,-2);
              DB::table('questions')->insert(['pregunta'=>$pregunta,'id_answers'=>$answer->id]);
            }
          //}
          //break;
    	    //dd(substr($nombre,14,-6));
    		//dd($nombre,$question);
          
        	$answers=DB::table('answer')->where('nombre','=',$nombre)->get();
        	foreach($answers as $answer){

          /*if($nombre==false){
            $nombre=substr($aux[$numlinea-4],21,-3);
            $question=substr($aux[15],9,-2);
            dd($nombre,$question,$answer,$path_archivo);
          }*/
        }
        	//if($i==4){
    		//dd($i,$nombre,$answer);
    	    //}
    	    //dd($nombre,$question,$answer);
    	    $largo=strlen($question);
    	    if($question[$largo-1]=='?'){
    	    	//dd($question[$largo-1]);
    	    if($largo!=0){
        			        	DB::table('questions')->insert(['pregunta'=>'¿'.$question,'id_answers'=>$answer->id]);
        			 }
        	}else{

               DB::table('questions')->insert(['pregunta'=>$question,'id_answers'=>$answer->id]);
        	//$j=12;
            //dd($aux,$j);
        	//while($pos2==false){
        		//$pos2=strpos($aux[$j],']');
        	    
        		
        		//dd($question);
        		
        		//$j=$j+1;
        	//}
        	 
    	}
    }
            //dd($nombre,$archivo_qna->id,$habilitada);			
     		//DB::table('answer')->insert([e,'id_archivo'=> $archivo_qna->id,'habilitada'=> $habilitada,'id_answers'=>$answer->id]);
    
    	//DB::table('answer')->insert(['nombre'=>$res_nombres[$i]]);
     		fclose($leer);
    	$i=$i+1;
    }
    }
   }





