<?php

namespace App\Http\Controllers;

use Auth;

class ProveedorController extends Controller
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
            $proveedor = \App\Proveedor::listar($busqueda, $actual, $limit);
            $numero_filas = \App\Proveedor::numero_de_registros(request()->get('txtbusqueda'));
            $paginas = ceil($numero_filas / $limit); //$numero_filas/10;
            return view('Proveedores.gestion', compact('proveedor', 'numero_filas', 'paginas', 'actual', 'limit', 'busqueda'));
        } else {
            return redirect("/")->with("error", "Su sesion ha terminado");
        }
    }

    public function nuevo()
    {
        if (Auth::check()) {
            $proveedor = new \App\Proveedor();
            $componente = \App\Componente::listar();
            return view('Proveedores.nuevo', compact('proveedor', 'componente'));
        } else {
            return redirect("/")->with("error", "Su sesion ha terminado");
        }
    }

    public function guardar()
    {
        if (Auth::check()) {
            $this->validate(request(), [
                'nit_emp' => 'required|unique:proveedores,nit_emp',
                'nombre_emp' => 'required|unique:proveedores,nombre_emp',
                'tel_emp' => 'required',
                'dir_emp' => 'required',
                'contacto_emp' => 'required',
                'contacto_celular' => 'required',
                'contacto_correo' => 'required',
                'componente_id' => 'required',
            ], [
                'nit_emp.required' => 'El nit es obligatorio',
                'nit_emp.unique' => 'El nit ya se encuentra registrado',
                'nombre_emp.required' => 'El nombre del proveedor es obligatorio',
                'nit_emp.unique' => 'El nombre del proveedornit ya se encuentra registrado',
                'tel_emp.required' => 'El telefono es obligatorio',
                'dir_emp.required' => 'La dirección es obligatoria',
                'contacto_emp.required' => 'El contacto del proveedor es obligatorio',
                'contacto_celular.required' => 'El celular del contacto es obligatorio',
                'contacto_correo.required' => 'El correo electronico del contacto es obligatorio',
                'componente_id.required' => 'El componente es obligatorio',
            ]);
            $data = request()->all();
            $respuesta = \App\Proveedor::guardar($data);
            if ($respuesta) {
                return redirect('/proveedores')->with('success', 'Proveedor creado de manera exitosa');
            } else {
                return redirect('/proveedores')->with('error', 'El proveedor no fue creado');
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
            $proveedor = \App\Proveedor::buscar($id);
            $estado = "Activo";
            if ($proveedor->estado == "Activo") {
                $estado = "Inactivo";
            } else {
                $estado = "Activo";
            }
            $respuesta = \App\Proveedor::editarestado($estado, $id);
            if ($respuesta) {
                if ($estado == "Activo") {
                    $mensaje = 'Proveedor activado de manera exitosa';
                } else {
                    $mensaje = 'Proveedor eliminado de manera exitosa';
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
            $proveedor = \App\Proveedor::buscar($id);
            $componente = \App\Componente::listar();
            return view('Proveedores.editar', compact('proveedor', 'componente'));
        } else {
            return redirect("/")->with("error", "Su sesion ha terminado");
        }
    }

    public function modificar($id)
    {
        if (Auth::check()) {
            $proveedor = \App\Proveedor::buscar($id);
            $this->validate(request(), [
                'nit_emp' => 'required|unique:proveedores,nit_emp,' . $proveedor->id,
                'nombre_emp' => 'required|unique:proveedores,nombre_emp,' . $proveedor->id,
                'tel_emp' => 'required',
                'dir_emp' => 'required',
                'contacto_emp' => 'required',
                'contacto_celular' => 'required',
                'contacto_correo' => 'required',
                'componente_id' => 'required',
            ], [
                'nit_emp.required' => 'El nit es obligatorio',
                'nit_emp.unique' => 'El nit ya se encuentra registrado',
                'nombre_emp.required' => 'El nombre del proveedor es obligatorio',
                'nit_emp.unique' => 'El nombre del proveedornit ya se encuentra registrado',
                'tel_emp.required' => 'El telefono es obligatorio',
                'dir_emp.required' => 'La dirección es obligatoria',
                'contacto_emp.required' => 'El contacto del proveedor es obligatorio',
                'contacto_celular.required' => 'El celular del contacto es obligatorio',
                'contacto_correo.required' => 'El correo electronico del contacto es obligatorio',
                'componente_id.required' => 'El componente es obligatorio',
            ]);            
            $data = request()->all();
            $respuesta = \App\Proveedor::modificar($data, $id);
            if ($respuesta) {
                return redirect('/proveedores')->with('success', 'Proveedor modificado de manera exitosa');
            } else {
                return redirect('/proveedores')->with('error', 'El proveedor no fue modificado');
            }
        } else {
            return redirect("/")->with("error", "Su sesion ha terminado");
        }
    }
}
