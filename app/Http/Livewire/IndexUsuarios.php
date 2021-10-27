<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\WithPagination;

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
        $this->contraseña = $this->generate_string();
        User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->contraseña),
        ]);
        $this->resetInput();
        session()->flash('message', 'Se ha registrado exitosamente este usuario. El nuevo usuario recibirá un email con su contraseña');
    }

    public function delete($id)
    {
        User::find($id)->delete();
        session()->flash('message', 'Usuario eliminado del sistema.');
    }
}





