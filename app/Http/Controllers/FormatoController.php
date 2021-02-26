<?php

namespace App\Http\Controllers;

use App\ut;
use DB;
class FormatoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function downloadVista($opc, $cod_sede, $cod_)
    {
        $ut = ut::all();
        if ($opc == "SEDES") {
            $banco = Estudiante::where('cobertura_id', $cod_)
                ->where('cod_sede', $cod_sede)
                ->get();
            // $banco = \DB::select("call planilla (' cod_sede={$cod_sede} AND cobertura_id={$cod_}')")->toSql();
            // $sql = "SELECT
            //         *
            //     FROM
            //         `estudiantes`
            //     WHERE
            //         cod_sede = $cod_sede
            //             AND cobertura_id = $cod_
            //     LIMIT 30";
            // $banco = DB::connection('mysql')->select($sql);
            // dd($banco);die;
        }

        //         DB::select('CALL planilla_todo(?)',array($cod_,$id,$hoa));
        // $banco = DB::connection('mysql')->select("call planilla ('20013')");

        $dompdf = App("dompdf.wrapper");
        $dompdf->loadView("formatos.generar", compact(['banco', 'ut']))->setPaper("8.5x14", 'landscape');
        return $dompdf->stream("Planilla.pdf");
    }

}
