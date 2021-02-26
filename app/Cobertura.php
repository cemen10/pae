<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cobertura extends Model
{

    protected $table = "coberturas";
    protected $fillable = [
        'nombre',
        'mes',
        'estado',
    ];

    public static function guardar($datos)
    {
        return Cobertura::create([
            'nombre' => $datos['nombre'],
            'mes' => $datos['mes'],
            'estado' => 'Activo',
        ]);
    }

    public static function buscar()
    {
        return Cobertura::where('estado', 'Activo')
            ->orderBy('id', 'DESC')
            ->get();
    }

    public function estudiantes()
    {
        return $this->hasMany(Estudiante::class);
    }

}
