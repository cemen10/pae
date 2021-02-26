<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
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

                $fecha = explode('-', date("Y-m-d"));
                $mes = $fecha[1];
                $datosCob["nombre"] = "Carge";
                $datosCob["mes"] = $mes;
                $cobertura = \App\Cobertura::guardar($datosCob);

                if ($cobertura) {
                    // UTILIZAR EL COMPONENTE DE EXCEL GUARDANDO EL ARCHIVO SUBIDO EN UNA VARIABLE
                    $collection = (new FastExcel)->import($ruta1);
                    // UTILIZAR EL COMPONENTE DE EXCEL GUARDANDO EL ARCHIVO SUBIDO EN UNA VARIABLE

                    $vector = [];
                    $i = 0;
                    $rutaSalida = public_path() . '/documentos/salidas/archivo.csv';

                    $sql = " INSERT INTO estudiantes VALUES";
                    // RECORRER LA VARIABLE QUE CONTIENE LAS FILAS DEL DOCUMENTO
                    foreach ($collection as $book) {

                        // DIRIGIRSE A UN CAMPO EN ESPECIFICO POR SI DESEA GUARDAR EN UNA BD

                        $sql .= "(0,'{$cobertura->id}','{$book["etnia"]}','{$book["mun_codigo"]}','{$book["municipio"]}',";
                        $sql .= "'{$book["inst_educativa"]}','{$book["dane_sede"]}','{$book["sede_educativa"]}',";
                        $sql .= "'{$book["cons_sede"]}','{$book["zona"]}','{$book["tipo_documento"]}',";
                        $sql .= "'{$book["documento"]}',";
                        $sql .= "'{$book["nombre1"]}','{$book["nombre2"]}','{$book["apellido1"]}','{$book["apellido2"]}',";
                        $sql .= "'{$book["edad"]}','{$book["genero"]}','{$book["tipo_jornada"]}','{$book["grado"]}',";
                        $sql .= "'Activo',null,null,null,'{$book["grupo"]}'),";
                        // $vector[] = $datos;

                        // $resp = \App\Estudiante::guardar($datos);
                        // DIRIGIRSE A UN CAMPO EN ESPECIFICO POR SI DESEA GUARDAR EN UNA BD
                    }

                    $resp = \App\Estudiante::guardar(trim($sql, ','));
                    // dd($sql);die;
                    // RECORRER LA VARIABLE QUE CONTIENE LAS FILAS DEL DOCUMENTO
                    if (request()->ajax()) {
                        return response()->json([
                            200,
                            'mensaje' => "Cobertura Cargada Con Exito",
                        ]);
                    }
                } else {
                    if (request()->ajax()) {
                        return response()->json([
                            500,
                            'mensaje' => "Ocurrio un error al cargar",
                        ]);
                    }
                }

                // return redirect('/cobertura')->with('success', 'Cobertura Cargada de manera exitosa');
            }
            // LEER EL ARCHIVO
        } else {
            return redirect("/")->with("error", "Su sesion ha terminado");
        }
    }

    public function planillas()
    {
        if (Auth::check()) {
            $cobertura = \App\Cobertura::buscar();
            $meses = [
                '01' => 'Enero',
                '02' => 'Febrero',
                '03' => 'Marzo',
                '04' => 'Abril',
                '05' => 'Mayo',
                '06' => 'Junio',
                '07' => 'Julio',
                '08' => 'Agosto',
                '09' => 'Septiembre',
                '10' => 'Octubre',
                '11' => 'Noviembre',
                '12' => 'Diciembre',
            ];
            return view('Cobertura.planilla', compact('cobertura', 'meses'));
        } else {
            return redirect("/")->with("error", "Su sesion ha terminado");
        }
    }

    public function busMunicipios()
    {
        if (Auth::check()) {
            $id = request()->get('id');
            $opc = "NO";
            $municipios = \App\Estudiante::buscarMunicipios($id);
            $total_cobertura = \App\Estudiante::totalCobertura($id);
            // LISTAR NUMERO DE COLEGIOS Y TOTAL ESTUDIANTES POR MUNICIPIOS
            $listado = \App\Estudiante::listarTotColTotEstMun($id);
            // LISTAR NUMERO DE COLEGIOS Y TOTAL ESTUDIANTES POR MUNICIPIOS
            if ($municipios) {
                $opc = "SI";
            }
            if (request()->ajax()) {
                return response()->json([
                    'municipios' => $municipios,
                    'total_cobertura' => $total_cobertura,
                    'listado' => $listado,
                    'opc' => $opc,
                ]);
            }
        } else {
            return redirect("/")->with("error", "Su sesion ha terminado");
        }
    }
}
