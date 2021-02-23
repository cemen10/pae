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
            $respuesta = Producto::join('componentes', 'componentes.id', 'productos.componente_id')
                ->where(function ($query) use ($busqueda) {
                    $query->where('productos.nombre', 'LIKE', '%' . $busqueda . '%')
                        ->orWhere('unidad_id', 'LIKE', '%' . $busqueda . '%');
                })
                ->select('productos.*', 'componentes.nombre as nombreC')
                ->orderBy('productos.id', 'DESC')
                ->limit($limit)->offset($offset)->get();
        } else {
            $respuesta = Producto::join('componentes', 'componentes.id', 'productos.componente_id')
                ->select('productos.*', 'componentes.nombre as nombreC')
                ->orderBy('productos.id', 'DESC')
                ->limit($limit)->offset($offset)->get();
        }

        return $respuesta;
    }

    public static function numero_de_registros($busqueda)
    {
        if (!empty($busqueda)) {
            $respuesta = Producto::join('componentes', 'componentes.id', 'productos.componente_id')
                ->where(function ($query) use ($busqueda) {
                    $query->where('productos.nombre', 'LIKE', '%' . $busqueda . '%')
                        ->orWhere('unidad_id', 'LIKE', '%' . $busqueda . '%');
                })
                ->count();
        } else {
            $respuesta = Producto::join('componentes', 'componentes.id', 'productos.componente_id')
                ->count();
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
}
