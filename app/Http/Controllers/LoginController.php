<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class LoginController extends Controller
{
	/**
     * Validate the user login.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
		if (auth()->attempt(['email' => $request->email, 'password' => $request->password, 'status' => 1])) {
            return redirect()->to('admin/dashboard');
        } else {
            $user = User::where('email', $request['email'])->first();
            if ( !$user ) {
                session()->forget('email');
                $errors = [ 'msg' => 'Usuario inválido'];
            } else {
                if ( !$user->status ) {
                    $errors = [ 'msg' => 'No tienes acceso al panel'];
                    session(['email' => $request['email']]);
                } else {
                    $errors = [ 'msg' => 'Contraseña incorrecta'];
                    session(['email' => $request['email']]);
                }
            }
            return redirect()->back()->withErrors($errors);
        }
	}

	/**
     * redirect to the dashboard
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard()
    {
        $title = $menu = 'Inicio';

        return view('layouts.dashboard', ['title' => $title, 'menu' => $menu]);
    }
}
