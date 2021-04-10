<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class NluImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

          $images_qnas=DB::table('answer')->where('nombre','like','#!builtin_image%')->get();
        //dd($images_qnas);
        $res = array();

           $path_archivo="public/botpress12120/data/bots/ucm-botpress1/content-elements/builtin_image.json";
            $leer = fopen($path_archivo, 'r+');
            $numlinea=0;
      foreach($images_qnas as $image_qna){
      while ($linea = fgets($leer)) {
        //echo $linea.'<br/>';
            $aux[] = $linea;    
             $numlinea++;
        }
        //dd($aux);
        $i=0;
        $tam=sizeof($aux);
        while($i<$tam){
        	//$i=2;
        	//dd($aux[$i]);
        	$pos = strpos($aux[$i],'builtin_image');
        	//dd($pos);
        	//if($i==13){
        	//dd($pos,$aux[$i]);
        	//dd(substr($aux[$i],4,-2),'"id": "'.substr($image_qna->nombre,2).'"');
        	//}
        		if($pos!=false){
        			//dd('HOLAA');
            		if((substr($aux[$i],4,-2))=='"id": "'.substr($image_qna->nombre,2).'"'){
        				
            		}else{
            			$builtin_image=substr($aux[$i],11,-3);
            			$i=$i+3;
        				$nombre=substr($aux[$i],45,-2);
        				//dd($nombre);
        				DB::table('nlus_images')->insert(['nombre_imagen_nlu'=>$nombre,'codigo_imagen_nlu'=> $builtin_image]);

            		}
            	}
            $i=$i+1;
        }
            //$tam=sizeof($res);
  		    //dd($res);
        	

        }
    }
}
