<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    protected $table = "proveedores";
    protected $fillable = [
        'nombre_emp',
        'nit_emp',
        'dir_emp',
        'tel_emp',
        'contacto_emp',
        'contacto_correo',
        'contacto_celular',
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
            $respuesta = Proveedor::join('componentes', 'componentes.id', 'proveedores.componente_id')
                ->where(function ($query) use ($busqueda) {
                    $query->where('nombre_emp', 'LIKE', '%' . $busqueda . '%')
                        ->orWhere('nit_emp', 'LIKE', '%' . $busqueda . '%')
                        ->orWhere('contacto_correo', 'LIKE', '%' . $busqueda . '%')
                        ->orWhere('contacto_emp', 'LIKE', '%' . $busqueda . '%');
                })
                ->select('proveedores.*', 'componentes.nombre')
                ->orderBy('proveedores.id', 'DESC')
                ->limit($limit)->offset($offset)->get();
        } else {
            $respuesta = Proveedor::join('componentes', 'componentes.id', 'proveedores.componente_id')
                ->select('proveedores.*', 'componentes.nombre')
                ->orderBy('proveedores.id', 'DESC')
                ->limit($limit)->offset($offset)->get();
        }

        return $respuesta;
    }

    public static function numero_de_registros($busqueda)
    {
        if (!empty($busqueda)) {
            $respuesta = Proveedor::join('componentes', 'componentes.id', 'proveedores.componente_id')
                ->where(function ($query) use ($busqueda) {
                    $query->where('nombre_emp', 'LIKE', '%' . $busqueda . '%')
                        ->orWhere('nit_emp', 'LIKE', '%' . $busqueda . '%')
                        ->orWhere('contacto_correo', 'LIKE', '%' . $busqueda . '%')
                        ->orWhere('contacto_emp', 'LIKE', '%' . $busqueda . '%');
                })
                ->count();
        } else {
            $respuesta = Proveedor::join('componentes', 'componentes.id', 'proveedores.componente_id')
                ->count();
        }
        return $respuesta;
    }

    public static function guardar($datos)
    {
        return Proveedor::create([
            'nombre_emp' => $datos['nombre_emp'],
            'nit_emp' => $datos['nit_emp'],
            'dir_emp' => $datos['dir_emp'],
            'tel_emp' => $datos['tel_emp'],
            'contacto_emp' => $datos['contacto_emp'],
            'contacto_correo' => $datos['contacto_correo'],
            'contacto_celular' => $datos['contacto_celular'],
            'componente_id' => $datos['componente_id'],
            'estado' => 'Activo',
        ]);
    }

    public static function buscar($id)
    {
        return Proveedor::findOrFail($id);
    }

    public static function editarestado($estado, $id)
    {
        return Proveedor::where('id', $id)->update([
            'estado' => $estado,
        ]);
    }

    public static function modificar($datos, $id)
    {
        $respuesta = Proveedor::where(['id' => $id])->update([
            'nombre_emp' => $datos['nombre_emp'],
            'nit_emp' => $datos['nit_emp'],
            'dir_emp' => $datos['dir_emp'],
            'tel_emp' => $datos['tel_emp'],
            'contacto_emp' => $datos['contacto_emp'],
            'contacto_correo' => $datos['contacto_correo'],
            'contacto_celular' => $datos['contacto_celular'],
            'componente_id' => $datos['componente_id'],
        ]);
        return $respuesta;
    }
}
