<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\Nlu_name;
use App\Models\Nlu_question;
use Auth;
use Redirect;

class IntentsController extends Controller
{
    //

    public function modify_despedida(Request $request){

      //$path_archivo = public_path('botpress12120/ucm-botpress1/intents/despedida.json');
      //Ruta de archivo a abrir
      $path_archivo = public_path('botpress12120\data\bots\ucm-botpress1\intents\despedida.json'); 

      //Se abre el archivo y se lee
      $leer = fopen($path_archivo, 'r+');

      //Se guarda texto del archivo en data
      $data = fread($leer, filesize($path_archivo));

      //se cieerra archivo
      fclose($leer);

      //Texto a buscar en el archivo de texto .json
      $patron = '"Bye Bye",';
      //Texto a colocar en el archivo .json
	  $sustitucion = '"byeeee byeeee",';
    //La funcion str_replace permite reemplazar un texto hallado en una fila $patron en un archivo $data, por el texto $sustitucion
      $datosnuevos = str_replace($patron, $sustitucion, $data); //REEMPLAZA LO QUE CONTINE EL ARCHIVO VIEJO POR EL ARCHIVO NUEVO
      //echo $datosnuevos;
      //Abre el archivo nuevamente 
      $escribir = fopen($path_archivo, 'w');
      //Escribe el texto nuevo en el archivo
      fwrite($escribir, $datosnuevos);

      //Cierra el archivo
      fclose($escribir);
     /* while(!feof($file)){
			//echo fgets($file). "<br />";
      		if($file==""Bye Bye,""){

      		}
		}
		fclose($file);*/
		//dd($datosnuevos);
		//return view('intents.modify_despedida', compact($datosnuevos));
    }


        public function nlu_name_index(){
      $datos=DB::table('nlu_name')->paginate(7);
      $nlus_questions=DB::table('nlu_questions')->get();
      $data=array();
      $number=array();
      $i=1;
      foreach($nlus_questions as $nlu_question){
      //dd($nlu_question);
        if($nlu_question->nlu_name_id==$i){
            array_push($data,$nlu_question->respuestas);
            //array_push($number, $i)
            $i=$i+1;
        }
        
       
      }
      $i=0;
      foreach($datos as $dato){
        $dato->respuesta=$data[$i];
        $i=$i+1;
      }
      $i=0;
      //dd($datos->groupby('nombre'));
      return view('intents.nlu_name_index',compact('datos','data'));

    }
   //Se hace join entre las tablas del aprendizaje del lenguaje natural(NLU), para mostrar información en la base de datos
       public function nlu_index($id)
    {
      $datos=DB::table('nlu_name')->join('nlu_questions','nlu_name.id','=','nlu_questions.nlu_name_id')->select('nlu_questions.*', 'nlu_name.nombre')->where('nlu_name.id','=',$id)->paginate(7);
      if(Auth::id()==null){
        return Redirect::to('dashboard');
      }
      return view('intents.nlu_index',compact('datos'));


    }

    public function create()
    {

        return view('intents.nlu_create');
    }


    public function store()
    {


    }


    //Editar campo respuestas de nlu_questions, pd: aun no se puede modificar campo nombre de nlu_name
    public function nlu_edit($id)
    {
         $datos=DB::table('nlu_name')->join('nlu_questions','nlu_name.id','=','nlu_questions.nlu_name_id')->select('nlu_questions.*','nlu_name.nombre')->where('nlu_questions.id','=',$id)->get();

        //Consulto por los datos que el usuario desea editar que perteneceran a la tabla nlu_questions
        $nlu_questions=DB::table('nlu_questions')->where('nlu_questions.id',$id)->get();
        //Uso foreach para acceder a cada elemento de la tabla.
        foreach($nlu_questions as $nlu_question)
        //dd($nlu_question);
        //Mediante la fk descubro el nombre del archivo .json al que debe pertenece.
        $nlu_names=DB::table('nlu_name')->where('nlu_name.id','=',$nlu_question->nlu_name_id)->get();
      $nlu_names1=DB::table('nlu_name')->where('nlu_name.id','=',$nlu_question->nlu_name_id)->get();
     // dd($nlu_names);
        //Uso foreach para acceder a cada elemento de la tabla.
        
        foreach($nlu_names as $nlu_name);
        foreach($nlu_names1 as $nlu_name1);

        $carpeta_flujos='botpress12120/data/bots/ucm-botpress1/flows';

      
      //Se creaa arreglo para guadar direccion de archivos de carpeta
      $res = array();

  // Agregamos la barra invertida al final en caso de que no exista
  if(substr($carpeta_flujos, -1) != "/") $carpeta_flujos .= "/";

  // Creamos un puntero al directorio y obtenemos el listado de archivos
  $dir1 = @dir($carpeta_flujos) or die("getFileList: Error abriendo el directorio $carpeta_flujos para leerlo");
  while(($archivo1 = $dir1->read()) !== false) {
      // Obviamos los archivos ocultos
      if($archivo1[0] == ".") continue;
      $encuentra=strpos($archivo1,".flow.json");
      if(is_dir($carpeta_flujos . $archivo1) and $encuentra!=false){
          $res[] = array(
            "Nombre" => $carpeta_flujos . $archivo1 . '"/"'
          );
      } else if (is_readable($carpeta_flujos . $archivo1) and $encuentra!=false) {
          $res[] = array(
            "Nombre" => $carpeta_flujos . $archivo1
          );
      }
  }

 $tam=sizeof($res);
 //dd($res);
 $path_archivo=array();
 $leer=array();
 $data=array();
 $i=0;
 while($i<$tam){
 $path_archivo[$i]=($res[$i]["Nombre"]);
 $linea=array();
 $leer[$i]=fopen($path_archivo[$i], 'r');
  $leer_ar=$leer[$i];
  $path_ar=$path_archivo[$i];
  //dd($leer_ar,$path_ar);
 $j=0;
 while(!feof($leer[$i])){
    $linea[$j] = fgets($leer[$i]);
    $j=$j+1;
}
//dd($linea,$leer[$i]);

$cantidad_lineas=sizeof($linea);

 $data= file_get_contents($path_archivo[$i]);
 //dd($linea,$leer[$i],$cantidad_lineas,$data);
 /*if($i==2){
  dd($data);
 }*/
 //dd($data);
 /*if($i==0){
 dd($leer_ar);
}*/
 /*if($i==0){
 dd($data[$i]);
}*/              
$cadena_buscada="builtin_image";
/*if($i==0){
  dd($data,$cadena_buscada,$encuentra);
}*/


$encuentra=strpos($data,$cadena_buscada);
/*if($i==2){
  dd($data,$cadena_buscada,$encuentra);
}*/
 
 $j=0;
 $n=0;

 /*while($j<$cantidad_lineas){
 $encuentra=strpos($linea[$j],$cadena_buscada);
 if(substr($linea[$j],11,-2)==)
  if($encuentra!=false){
      $j=$cantidad_lineas;
   }
   $j=$j+1;
 }*/
 //dd($encuentra);
 /*if($i==2){
  dd(substr($linea[24],11,-2),$encuentra);
}*/
 if($encuentra!=false){

   $nlus_names=DB::table('nlu_name')->select('nombre')->get();
   $images=DB::table('nlus_images')->get();
    $array_codigo_image=array();
    $array_ruta_image=array();
    $array_nombre_image=array();
   //dd($data,$cadena_buscada,$encuentra,$nlus_names);

   foreach($nlus_names as $nlu_name){
    //dd($nlu_name->nombre);
    //dd($data,$cadena_buscada,$encuentra,$nlus_names);
    $k=0;
    while($k<$cantidad_lineas){
    $var='"condition": "event.nlu.intent.name === '."'".$nlu_name->nombre."'".'"';
    //dd($data,$cadena_buscada,$encuentra,$nlus_names,$var,substr($linea[$k],10,-2),$k);
    if($var==(substr($linea[$k],10,-2))){
      //dd($data,$cadena_buscada,$encuentra,$nlus_names,$var,substr($linea[$k],10,-2),$k);
      //dd($var,substr($linea[$k],10,-2));
       $k=$k+1;
       $encuentra_gato=strpos($linea[$k],'#');
      if($encuentra_gato==false){
      $nombre_nodo='"'.substr($linea[$k],19,-2).'"';
      //dd($nombre_nodo);
      //dd($encuentra_gato,$nombre_nodo);
      //dd($cantidad_lineas,$nombre_nodo);
    $name="name";
    $nodo="node";
    $array_name=array($nombre_nodo);
    $array_nodo=array(0,$nombre_nodo);
    //dd($nombre_nodo);
    $k=$k+1;
    //dd($k);
    $l=1;
    //dd($cantidad_lineas);
    while($linea[$k]!=false){
    //dd($k);
    $next=strpos($linea[$k],"next");
    if($next!=false){
    //dd($next,$linea[$k],$k,$linea[$k+4]);
      //dd($linea[38],$corchete_cerrado);
      $corchete_cerrado=strpos($linea[$k],"]");
      //dd($corchete_cerrado,$linea[$k],$k);
      while($corchete_cerrado==false){
        //echo($linea[$k]);
         //dd($corchete_cerrado,$linea[$k],$k);
           $node=strpos($linea[$k],"node");
           $name=strpos($linea[$k],"name");

           if($node!=false){
              array_push($array_nodo,$l,substr($linea[$k],19,-2));
              
              //$k=$k+1;
              //dd($array_nodo);
           }elseif($name!=false){
                //dd($name);
            $m=0;
             $largo_arreglo=sizeof($array_nodo);
            while($m<$largo_arreglo){

                 if($m%2!=0){
                 $nombre_name=$array_nodo[$m];
                  $encuentra_num_array_nodo=strpos($linea[$k],$nombre_name);
                  /*if($m==5){
                    dd($array_name,$m-2,$array_nodo[$m-1],$array_nodo[$m]);
                  }*/
                  if($encuentra_num_array_nodo!=false){
                  //print_r($nombre_name,$m);
                  array_push($array_name,$array_nodo[$m-1],$array_nodo[$m]);
                }
               }
                  $m=$m+1;
              }
                //array_push($array_name,$l-1,$array_nodo[$l+1]);
                 $l=$l+1;
           }
           if($k==$cantidad_lineas-1){
               break;
           }else{
            $k=$k+1;
            foreach($images as $image){
        $dice='"say #!'.$image->codigo_imagen_nlu.'"';
        $encuentra_dice=strpos($linea[$k],$dice);
        if($encuentra_dice!=false){
          array_push($array_codigo_image,$image->codigo_imagen_nlu);
          array_push($array_ruta_image,$image->nombre_imagen_nlu);
           //$n=$n+1;
        }
      }
           }


          
      }

    }

    if($k==$cantidad_lineas-1){
      break;
    }else{
      $k=$k+1;

    }
  }

  }
    

    }


    $k=$k+1;



    }

  }
  $cantidad_image=count($array_codigo_image);
  
   /*$n=$cantidad_lineas-1;
   $p=0;
    $q=0;
      $cantidad_images=count($array_codigo_image);
      $lista_images=array();
    while($n>0){
      //dd($array_codigo_image);
      $cantidad_image=count($array_codigo_image);
      //dd($cantidad_image);
      //dd($linea[$n]);
      $encuentra_image=strpos($linea[$n],$array_codigo_image[$p]);
      if($p==1){
      dd($p,$encuentra_image,$linea[$n],$array_codigo_image);
     }
      while($encuentra_image!=false){
        $encuentra_name=strpos($linea[$n],"name");
        //dd($p,$encuentra_image,$linea[$n],$array_codigo_image);
          if($encuentra_name==false){
              $n=$n-1;
              //dd($encuentra_name);
          }else{
            $name=substr($linea[$n],15,-3);
            $encuentra_node=strpos($linea[$n],$name);

            //$n=$n-1;
            //dd($p,$encuentra_image,$linea[$n],$array_codigo_image[$p],$q,$n,$encuentra_name,$name,$encuentra_node);
            //dd($encuentra_node,$linea[$n],$name,$encuentra_name);
            if($p==$cantidad_image){
                  break;
                }else{
                    $n=$cantidad_lineas-1;
                }
            while($encuentra_name!=false){
              $encuentra_node=strpos($linea[$n],$name);
              //dd($encuentra_node,$linea[$n],$name,$n);
              if($encuentra_node==false){
                $n=$n-1;
              }else{
                //dd($linea[$n],$name,$n);
                $nombres_images=substr($linea[$n-1],65,-5);
                //dd($image,$n);
                if($nombres_images=="Competencia"){
                  dd($nombres_images);
                }
                //array_push($lista_images,$nombres_images);
                //dd($p,$encuentra_image,$linea[$n],$array_codigo_image[$p],$q,$n,$encuentra_name,$name,$encuentra_node,$image,$nombres_images);
                $p=$p+1;
               //dd($p,$encuentra_image,$linea[$n],$array_codigo_image[$p],$q,$n,$encuentra_name,$name,$encuentra_node,$image,$lista_images);
                //dd($encuentra_name,$encuentra_image,$lista_images);
                if($p==$cantidad_image){
                  break;
                }else{
                    $n=$cantidad_lineas-1;
                }
              }
            }
          }
      }
        if($p==$cantidad_image){
                  break;
                }else{
                  $n=$n-1;
                }
              }*/
    

    }


 fclose($leer[$i]);
 $i=$i+1;
}
      
        //De esta forma se puede imprimir de manera directa los campos deseados en la vista intents.nlu_edit
//dd($array_nodo,$array_name,$array_codigo_image,$array_ruta_image);
//dd($lista_images);
        return view('intents.nlu_edit',compact('nlu_question','nlu_name1','array_codigo_image','array_ruta_image','array_name','cantidad_image'));
    }

    public function nlu_update(Request $request, Nlu_question $nlu_question){
       $validator = $request->validate(
              [
              'image_nueva0' => 'image',
              'image_nueva1' => 'image'
            ]);
   
      $i=0;
    
 
      $i=0;
      $cantidad_image=(int)$request->cantidad_image;
      while($i<$cantidad_image){
        $image_nueva='image_nueva'.$i;
        $imagen=$request->get("imagen".$i);
        //dd($image_nueva,$imagen);
        //dd($i,$cantidad_image,$request,$image_nueva,$request->hasfile($image_nueva),$imagen);
        if(($request->hasfile($image_nueva))==true){
          //dd($i,$cantidad_image,$request,$image_nueva,$request->hasfile($image_nueva));
          $nombre_imagen=time().$request->file($image_nueva)->getClientOriginalName();
          //dd($i,$cantidad_image,$nombre_imagen,$image_nueva,$imagen);
          $request->file($image_nueva)->move('images/bp', $nombre_imagen);
          $fichero=public_path().'/images/bp/'.$nombre_imagen;
          //dd($fichero);
          $nuevo_fichero=public_path().'/botpress12120/data/bots/ucm-botpress1/media/'.$nombre_imagen;
          copy($fichero,$nuevo_fichero);
          //$request->file($image_nueva)->move('botpress12120/data/bots/ucm-botpress1/media',$nombre_imagen);
          unlink(public_path()."/images/bp/".$imagen);
          unlink(public_path()."/botpress12120/data/bots/ucm-botpress1/media/".$imagen);
          rename(public_path()."/images/bp/".$nombre_imagen,public_path()."/images/bp/".$imagen);
          rename(public_path()."/botpress12120/data/bots/ucm-botpress1/media/".$nombre_imagen, public_path()."/botpress12120/data/bots/ucm-botpress1/media/".$imagen);
        }
        $i=$i+1;
      }
      //Descubro que elemnto de la tabla nlu_questions estoy editando...
      $id=$nlu_question->id;
      //Pregunto el nombre del archivo, o el campo nombre que al que estan asociadas o etiquetadas este conjunto de palabras del aprendizaje automatico.
      $nlu_names=DB::table('nlu_name')->where('id','=',$nlu_question->nlu_name_id)->get();
      //Uso el foreach para no tener que aplicar foreach en la vista, y que sea mas engorroso, de esta forma en la vista
      //accedo al campo de la tabla nlu_name de forma directa, sin usar foreach
      foreach($nlu_names as $nlu_name);
       //De momento accedo de manera menos practica que con las QNA
      //Cabe recordar que public_path me genera la ruta automatica desde la raiz hasta la carpeta chatbot/public y de ahi en adelante busca la ruta que esta dentro de las "".
      if($nlu_name->nombre=="despedida"){
      $path_archivo = public_path("botpress12120\data\bots\ucm-botpress1\intents\despedida.json");
      }elseif($nlu_name->nombre=="mallas"){
        $path_archivo = public_path("botpress12120\data\bots\ucm-botpress1\intents\mallas.json");

      }elseif($nlu_name->nombre=="perfil-de-egreso"){
        $path_archivo = public_path("botpress12120\data\bots\ucm-botpress1\intents\perfil-de-egreso.json");

      }elseif($nlu_name->nombre=="contacto-carrera"){
        $path_archivo = public_path("botpress12120\data\bots\ucm-botpress1\intents\contacto-carrera.json");

     }elseif($nlu_name->nombre=="renunciar"){
              $path_archivo = public_path('botpress12120\data\bots\ucm-botpress1\intents\renunciar.json');

      }elseif($nlu_name->nombre=="sitio-web"){
            $path_archivo = public_path('botpress12120\data\bots\ucm-botpress1\intents\sitio-web.json');

      }
      //Consigo Nlu_question
      $nlu_question=Nlu_question::find($id);
      

      //Le asigno el elemento actual que se encuentra en base de datos mysql
      $patron= '"'.$nlu_question->respuestas.'",';
      //Le asigno a sustitucion el elemento que viene desde el formularo edit
      $sustitucion='"'.$request->respuestas.'",';
      //dd($sustitucion);
      //$patron = '"{{$nlu_question->respuestas}}",';
      //dd($patron);
      //RUTA DE ARCHIVO A ABRIR
      //dd($path_archivo);

      //leo el archivo
      $leer = fopen($path_archivo, 'r+');

      //escribo en la variable data lo que este archivo contiene
      $data = fread($leer, filesize($path_archivo));

      //cierro el archivo
      fclose($leer);
    //$sustitucion = '"byeeee byeeee",';
      //Modifico el archivo
      //Creo una variable $datosnuevos copio lo mismo que en $data pero modifico lo que dice en la fila $patron por $sustitucion
      $datosnuevos = str_replace($patron, $sustitucion, $data); //REEMPLAZA LO QUE CONTINE EL ARCHIVO VIEJO POR EL ARCHIVO NUEVO
      //echo $datosnuevos;
      //abro el archivo nuevo para escribir 
      $escribir = fopen($path_archivo, 'w');
      //escribo lo que se almacen la variable $datosnuevos
      fwrite($escribir, $datosnuevos);

      //cierro el archivo
      fclose($escribir);
     /* while(!feof($file)){
      //echo fgets($file). "<br />";
          if($file==""Bye Bye,""){
      
          }
    }
    fclose($file);*/
    $nlu_question->respuestas=$request->respuestas;
    $nlu_question->save();
    $datos=DB::table('nlu_name')->join('nlu_questions','nlu_name.id','=','nlu_questions.nlu_name_id')->select('nlu_questions.*', 'nlu_name.nombre')->paginate(7);
    return view('intents.index_nlu', compact('datos'));
      
    }
}
