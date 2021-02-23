<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'rol', 'usuario', 'estado', 'identificacion', 'celular', 'direccion',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function login($usua, $pass)
    {
        $usuario = User::where(function ($query) use ($usua) {
            $query->where('email', $usua)
                ->orWhere('usuario', $usua);
        })
            ->where('estado', 'Activo')
            ->first();
        if ($usuario && \Hash::check($pass, $usuario->password)) {
            auth()->loginUsingId($usuario->id);
            return $usuario;
        }
        return false;
    }

    public static function listar($busqueda)
    {
        if (!empty($busqueda)) {
            $respuesta = User::where(function ($query) use ($busqueda) {
                $query->where('name', 'LIKE', '%' . $busqueda . '%')
                    ->orWhere('email', 'LIKE', '%' . $busqueda . '%')
                    ->orWhere('identificacion', 'LIKE', '%' . $busqueda . '%');
            })
                ->orderBy('id', 'DESC')
                ->get();
        } else {
            $respuesta = User::orderBy('id', 'DESC')
                ->get();
        }

        return $respuesta;
    }

    public static function guardar($data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'estado' => 'Pendiente',
            'identificacion' => $data['identificacion'],
            'rol' => $data['rol'],
            'celular' => $data['celular'],
            'usuario' => $data['usuario'],
            'direccion' => $data['direccion'],
        ]);
    }
    public static function buscarUsuario($id)
    {
        return User::findOrFail($id);
    }
    public static function modificar($data, $id)
    {
        $respuesta = User::where(['id' => $id])->update([
            'name' => $data['name'],
            'email' => $data['email'],
            'identificacion' => $data['identificacion'],
            'rol' => $data['rol'],
            'celular' => $data['celular'],
            'usuario' => $data['usuario'],
            'direccion' => $data['direccion'],
        ]);
        return $respuesta;
    }
    public static function editarestado($estado, $id)
    {
        return User::where('id', $id)->update([
            'estado' => $estado,
        ]);
    }
}
