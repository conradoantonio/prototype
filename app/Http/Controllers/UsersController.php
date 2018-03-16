<?php

namespace App\Http\Controllers;

use \App\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    /**
     * Show the main view.
     *
     */
    public function index(Request $req)
    {
        $title = "Usuarios Sistema";
        $menu = "Usuarios";
        $users = User::where('id', '!=', auth()->user()->id)->get();

        if ($req->ajax()) {
            return view('users.table', ['users' => $users]);
        }
        return view('users.index', ['users' => $users, 'menu' => $menu, 'title' => $title]);
    }

    /**
     * Changes the user's password.
     *
     */
    public function change_password(Request $req)
    {
        $user = User::find(auth()->user()->id);

        if ($user) {
            if (Hash::check($req->current_pass, $user->password)) {
                if ($req->new_pass == $req->confirm_pass) {
                    $user->password = bcrypt($req->new_pass);
                    $user->save();
                    return response(['msg' => 'Contraseña cambiada', 'status' => 'ok'], 200);
                } else {
                    return response(['msg' => 'Las contraseñas no coinciden', 'status' => 'error'], 200);
                }
            } else {
                return response(['msg' => 'Contraseña errónea', 'status' => 'error'], 200);
            }
        }
    }

    /**
     * change the user's profile picture
     *
     */
    public function change_profile_picture(Request $req)
    {
        $user = User::find(auth()->user()->id);
        
        if ($user) {
        	$img = $this->upload_file($req->file('img'), 'img/profile', true);
	        $user->img = $img;
	        $user->save();
            
            return response(['msg' => 'Foto modificada exitósamente', 'status' => 'ok'], 200);
        } else {
            return response(['msg' => 'Ocurrió un error tratando de modificar la foto de perfil del usuario', 'status' => 'error'], 200);
        }
    }
}
