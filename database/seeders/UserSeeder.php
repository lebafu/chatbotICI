<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Team;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$fecha = Carbon::now();
        $team = Team::create(['id' => 1, 'user_id' => 1, 'name' => 'Admin Team', 'personal_team' => 1, 'created_at' => $fecha, 'updated_at' => $fecha]);
        $user = User::create(['id' => 1, 'name' => 'Administrador', 'email' => 'admin@admin.com', 'password' => Hash::make('admin'), 'current_team_id' => 1, 'created_at' => $fecha, 'updated_at' => $fecha]);
    }
}