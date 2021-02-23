<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Componente extends Model
{
    protected $table = "componentes";
    protected $fillable = [
        'nombre',
        'estado',
    ];

    public static function listar()
    {
        return Componente::where('estado', 'Activo')->get();
    }

}
