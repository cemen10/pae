<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Rap2hpoutre\FastExcel\FastExcel;

class CoberturaController extends Controller
{
    public function gestion()
    {
        if (Auth::check()) {
            return view('Cobertura.gestion');
        } else {
            return redirect("/")->with("error", "Su sesion ha terminado");
        }
    }

    public function subir()
    {
        if (Auth::check()) {

            // VALIDAR QUE SELECCIONEN EL ARCHIVO
            $this->validate(request(), [
                'archivo' => 'required',
            ], [
                'archivo.required' => 'Debe seleccionar un archivo',
            ]);
            // VALIDAR QUE SELECCIONEN EL ARCHIVO

            // GUARDAR EL REQUEST EN UNA VARIABLE
            $data = request()->all();
            // GUARDAR EL REQUEST EN UNA VARIABLE

            // SUBIR EL ARCHIVO AL SERVIDOR
            $filename1 = "NADA";
            $ruta1 = "NADA";
            $hasFile1 = request()->hasFile('archivo') && request()->archivo->isValid();
            if ($hasFile1) {
                $imagen_tmp1 = $data['archivo'];
                if ($imagen_tmp1->isValid()) {
                    $filename1 = $imagen_tmp1->getClientOriginalName();
                    $imagen_tmp1->move(public_path() . '/documentos/archivos/', $filename1);
                    // CARPETA PUBLIC
                    $ruta1 = public_path() . '/documentos/archivos/' . $filename1;
                    // CARPETA PUBLIC
                }
            }
            // SUBIR EL ARCHIVO AL SERVIDOR

            // LEER EL ARCHIVO
            if ($ruta1 != "NADA") {

                // UTILIZAR EL COMPONENTE DE EXCEL GUARDANDO EL ARCHIVO SUBIDO EN UNA VARIABLE
                $collection = (new FastExcel)->import($ruta1);
                // UTILIZAR EL COMPONENTE DE EXCEL GUARDANDO EL ARCHIVO SUBIDO EN UNA VARIABLE

                $vector = [];
                $i = 0;
                $rutaSalida = public_path() . '/documentos/salidas/archivo.csv';

                // RECORRER LA VARIABLE QUE CONTIENE LAS FILAS DEL DOCUMENTO
                foreach ($collection as $book) {

                    // DIRIGIRSE A UN CAMPO EN ESPECIFICO POR SI DESEA GUARDAR EN UNA BD
                    // EJEMPLO (CONSECUTIVO,JORNADA,GRADO) Nombres de las columnas del documento
                    // \App\Tabla::guardar($book["CONSECUTIVO"],$book["JORNADA"],$book["GRADO"]);
                    // DIRIGIRSE A UN CAMPO EN ESPECIFICO POR SI DESEA GUARDAR EN UNA BD

                    $vector[] = $book;
                }
                // RECORRER LA VARIABLE QUE CONTIENE LAS FILAS DEL DOCUMENTO

                // CREAR DOCUMENTO EXCEL CON EL ARCHIVO LEIDO
                (new FastExcel($vector))->export($rutaSalida);
                // CREAR DOCUMENTO EXCEL CON EL ARCHIVO LEIDO

                return redirect('/cobertura')->with('success', 'Cobertura Cargada de manera exitosa');
            }
            // LEER EL ARCHIVO
        } else {
            return redirect("/")->with("error", "Su sesion ha terminado");
        }
    }
}
