<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;

class ProductoController extends Controller
{

    public function gestion()
    {
        if (Auth::check()) {
            $busqueda = request()->get('txtbusqueda');
            $actual = request()->get('page');
            if ($actual == null || $actual == "") {
                $actual = 1;
            }
            $limit = 10;
            $producto = \App\Producto::listar($busqueda, $actual, $limit);       
            $numero_filas = \App\Producto::numero_de_registros(request()->get('txtbusqueda'));
            $paginas = ceil($numero_filas / $limit); //$numero_filas/10;
            return view('Producto.gestion', compact('producto', 'numero_filas', 'paginas', 'actual', 'limit', 'busqueda'));
        } else {
            return redirect("/")->with("error", "Su sesion ha terminado");
        }
    }

    public function nuevo()
    {
        if (Auth::check()) {
            $producto = new \App\Producto();
            $componente = \App\Componente::listar();
            return view('Producto.nuevo', compact('producto', 'componente'));
        } else {
            return redirect("/")->with("error", "Su sesion ha terminado");
        }
    }

    public function guardar()
    {
        if (Auth::check()) {
            $this->validate(request(), [
                'nombre' => 'required|unique:productos,nombre',
                'peso' => 'required',
                'unidad_id' => 'required',
                'componente_id' => 'required',
            ], [
                'nombre.required' => 'El producto es obligatorio',
                'nit_emp.unique' => 'El producto ya se encuentra registrado',
                'peso.required' => 'El peso es obligatorio',
                'unidad_id.required' => 'La unidad es obligatoria',
                'componente_id.required' => 'El componente es obligatorio',
            ]);
            $data = request()->all();
            $respuesta = \App\Producto::guardar($data);
            if ($respuesta) {
                return redirect('/productos')->with('success', 'Producto creado de manera exitosa');
            } else {
                return redirect('/productos')->with('error', 'El producto no fue creado');
            }
        } else {
            return redirect("/")->with("error", "Su sesion ha terminado");
        }
    }

    public function eliminar()
    {
        $mensaje = "";
        $id = request()->get('id');
        if (Auth::check()) {
            $producto = \App\Producto::buscar($id);
            $estado = "Activo";
            if ($producto->estado == "Activo") {
                $estado = "Inactivo";
            } else {
                $estado = "Activo";
            }
            $respuesta = \App\Producto::editarestado($estado, $id);
            if ($respuesta) {
                if ($estado == "Activo") {
                    $mensaje = 'Producto activado de manera exitosa';
                } else {
                    $mensaje = 'Producto eliminado de manera exitosa';
                }
            } else {
                $mensaje = 'Estado no actualizado';
            }
            if (request()->ajax()) {
                return response()->json([
                    'mensaje' => $mensaje,
                    'id' => $id,
                ]);
            }
        } else {
            return redirect("/")->with("error", "Su sesion ha terminado");
        }
    }

    public function editar($id)
    {
        if (Auth::check()) {
            $producto = \App\Producto::buscar($id);
            $componente = \App\Componente::listar();
            return view('Producto.editar', compact('producto', 'componente'));
        } else {
            return redirect("/")->with("error", "Su sesion ha terminado");
        }
    }

    public function modificar($id)
    {
        if (Auth::check()) {
            $producto = \App\Producto::buscar($id);
            $this->validate(request(), [
                'nombre' => 'required|unique:productos,nombre,' . $producto->id,
                'peso' => 'required',
                'unidad_id' => 'required',
                'componente_id' => 'required',
            ], [
                'nombre.required' => 'El producto es obligatorio',
                'nit_emp.unique' => 'El producto ya se encuentra registrado',
                'peso.required' => 'El peso es obligatorio',
                'unidad_id.required' => 'La unidad es obligatoria',
                'componente_id.required' => 'El componente es obligatorio',
            ]);
            $data = request()->all();
            $respuesta = \App\Producto::modificar($data, $id);
            if ($respuesta) {
                return redirect('/productos')->with('success', 'Producto modificado de manera exitosa');
            } else {
                return redirect('/productos')->with('error', 'El producto no fue modificado');
            }
        } else {
            return redirect("/")->with("error", "Su sesion ha terminado");
        }
    }
}
