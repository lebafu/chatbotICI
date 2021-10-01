<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

    	$this->call(CategoriaSeeder::class);
      $this->call(AnswerSeeder::class);
    	$this->call(QuestionSeeder::class);
      $this->call(QnaImageSeeder::class);
      $this->call(NluImageSeeder::class);

        //$ruta="public/botpress12120/ucm-botpress1/media/";
        $directorio1="public/botpress12120/data/bots/icibot/media";
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
  //dd($tam);
  $i=0;
while($i<$tam){
$origen[$i] =$res[$i]["Nombre"];
$i=$i+1;
}
//dd($origen);
$destino ='public/images/bp/';
//$imagen=
$imagenes=array();
$i=0;
while($i<$tam){
$imagenes[$i]=$destino.substr($res[$i]["Nombre"],51);
$i=$i+1;
}
//dd($origen,$imagenes);
$j=0;
while($j<$tam){
if(copy($origen[$j],$imagenes[$j])){

echo "Se ha copiado correctamente la imagen";

}else {

echo "No se copiado la imagen correctamente";

}
$j=$j+1;
    }
}
}

