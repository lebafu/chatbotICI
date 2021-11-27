<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\TestMail;
use Illuminate\Support\Facades\Hash;
use Livewire\WithPagination;
use Carbon\Carbon;
use DB;

class IndexUsuarios extends Component
{
	use WithPagination;

	public $name, $email, $contraseña;

    public function render()
    {
        return view('livewire.index-usuarios', [
            'users' => User::paginate(10)
        ]);
    }

    public function resetInput()
    {
        $this->name = null;
        $this->email = null;
    }

    public function generate_string()
    {
		$permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$strength = 8;
	    $input_length = strlen($permitted_chars);
	    $random_string = '';
	    for($i = 0; $i < $strength; $i++) {
	        $random_character = $permitted_chars[mt_rand(0, $input_length - 1)];
	        $random_string .= $random_character;
	    }
	    return $random_string;
	}

    public function store()
    {
        $this->validate([
            'name' => 'required',
            'email' => 'required|email:rfc,dns'
        ],
        [
            'email.email' => 'Debes ingresar un email válido',
        ]);
        $email=$this->email;
        $this->contraseña = $this->generate_string();
        $details=['title'=> 'Usted'.$this->name.'esta recibiendo la contraseña de la cuenta de Chatbot ICI',
                   'body'=> 'Su contraseña asignada es:'. $this->contraseña,
                   'name'=> $this->name,
                   'password'=> $this->contraseña];
        User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->contraseña),
        ]);
        Mail::to($this->email)->send(new TestMail($details));
        $this->resetInput();

        $user_id=DB::table('users')->max('id');
        $id_actual_team=DB::table('teams')->max('id');
        //dd($user_id,$id_actual_team,$this);
         $carbon = new \Carbon\Carbon();
        $fecha_actual = $carbon->now();
        DB::table('teams')->insert(['user_id'=> $user_id,'name'=> 'Admin Team', 'personal_team'=>1,'created_at'=>$fecha_actual, 'updated_at'=>$fecha_actual]);

        session()->flash('message', 'Se ha registrado exitosamente este usuario. El nuevo usuario recibirá un email con su contraseña');

        
    }

    public function delete($id)
    {
        User::find($id)->delete();
        DB::table('teams')->where('user_id','=',$id)->delete();
        session()->flash('message', 'Usuario eliminado del sistema.');
    }
}






