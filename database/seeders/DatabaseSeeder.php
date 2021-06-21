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

    	$this->call(ArchivoQnaSeeder::class);
    	$this->call(AnswerSeeder::class);
    	$this->call(QuestionSeeder::class);
        $this->call(ArchivoNluSeeder::class);
    	$this->call(NluNameSeeder::class);
    	$this->call(NluQuestionSeeder::class);
    }
}
