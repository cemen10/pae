<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $table = "productos";
    protected $fillable = [
        'nombre',
        'detalle',
        'peso',
        'unidad_id',
        'componente_id',
        'estado',
    ];

    public static function listar($busqueda, $pagina, $limit)
    {
        if ($pagina == "1") {
            $offset = 0;
        } else {
            $pagina--;
            $offset = $pagina * $limit;
        }

        if (!empty($busqueda)) {

            $respuesta = \App\Producto::where('estado', 'Activo')
                ->where(function ($query) use ($busqueda) {
                    $query->where('nombre', 'like', "%{$busqueda}%")
                        ->orWhere('peso', 'like', "%{$busqueda}%")
                        ->orWhere('detalle', 'like', "%{$busqueda}%");
                })
                ->orWhereHas('unidad', function ($query) use ($busqueda) {
                    $query->where('nombre', 'like', "%{$busqueda}%");
                })
                ->orWhereHas('componente', function ($query) use ($busqueda) {
                    $query->where('nombre', 'like', "%{$busqueda}%");
                })
                ->orderBy('id', 'DESC')
                ->limit($limit)->offset($offset)->get();
        } else {
            $respuesta = \App\Producto::where('estado', 'Activo')
                ->orderBy('id', 'DESC')
                ->limit($limit)->offset($offset)->get();
        }

        return $respuesta;
    }

    public static function numero_de_registros($busqueda)
    {
        if (!empty($busqueda)) {
            $respuesta = \App\Producto::where('estado', 'Activo')
                ->where(function ($query) use ($busqueda) {
                    $query->where('nombre', 'like', "%{$busqueda}%")
                        ->orWhere('peso', 'like', "%{$busqueda}%")
                        ->orWhere('detalle', 'like', "%{$busqueda}%");
                })
                ->orWhereHas('unidad', function ($query) use ($busqueda) {
                    $query->where('nombre', 'like', "%{$busqueda}%");
                })
                ->orWhereHas('componente', function ($query) use ($busqueda) {
                    $query->where('nombre', 'like', "%{$busqueda}%");
                })
                ->count();
        } else {
            $respuesta = Producto::count();
        }
        return $respuesta;
    }

    public static function guardar($datos)
    {
        return Producto::create([
            'nombre' => $datos['nombre'],
            'detalle' => $datos['detalle'],
            'peso' => $datos['peso'],
            'unidad_id' => $datos['unidad_id'],
            'componente_id' => $datos['componente_id'],
            'estado' => 'Activo',
        ]);
    }

    public static function buscar($id)
    {
        return Producto::findOrFail($id);
    }

    public static function editarestado($estado, $id)
    {
        return Producto::where('id', $id)->update([
            'estado' => $estado,
        ]);
    }

    public static function modificar($datos, $id)
    {
        $respuesta = Producto::where(['id' => $id])->update([
            'nombre' => $datos['nombre'],
            'detalle' => $datos['detalle'],
            'peso' => $datos['peso'],
            'unidad_id' => $datos['unidad_id'],
            'componente_id' => $datos['componente_id'],
        ]);
        return $respuesta;
    }

    public function unidad()
    {
        return $this->belongsTo(Unidad::class);
    }
    public function componente()
    {
        return $this->belongsTo(Componente::class);
    }
}
