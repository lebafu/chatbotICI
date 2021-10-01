<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Categorias;

class CategoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categoria = Categorias::create(['nombre' => 'Sin especificar']);
        $categoria = Categorias::create(['nombre' => 'Información de la carrera']);
        $categoria = Categorias::create(['nombre' => 'Información de la universidad']);
        $categoria = Categorias::create(['nombre' => 'Servicios y plataformas']);
        $categoria = Categorias::create(['nombre' => 'Beneficios estudiantiles']);
        $categoria = Categorias::create(['nombre' => 'Finanzas']);
        $categoria = Categorias::create(['nombre' => 'Procesos y gestion de la carrera']);
        $categoria = Categorias::create(['nombre' => 'Ramos y asignaturas']);
        $categoria = Categorias::create(['nombre' => 'Contactos de interés']);
        $categoria = Categorias::create(['nombre' => 'Eventos específicos']);
    }
}



