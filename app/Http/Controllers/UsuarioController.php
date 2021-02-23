<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Session;

class UsuarioController extends Controller
{
    public function index()
    {
        return view('index');
    }
    public function login()
    {
        $respuesta = \App\User::login(request()->get('email'), request()->get('password'));
        if ($respuesta) {
            Session::put('RUTAGLOBAL', '');
            return redirect('/administracion');
        } else {
            $opc = false;
            $mensaje = "Usuario ó Contraseña incorrecta";
            return redirect('/')->with('error', 'Email ó Contraseña Incorrecta');
        }
    }
    public function administracion()
    {
        if (Auth::check()) {
            return view('Administracion');

        } else {
            return redirect("/")->with("error", "Su sesion ha terminado");
        }
    }
    public function logout()
    {
        Session::flush();
        Auth::logout();
        return redirect('/')->with('success', 'Sesion Finalizada');
    }
}
