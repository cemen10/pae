<?php

namespace App;

use DB;
use Illuminate\Database\Eloquent\Model;

class Estudiante extends Model
{
    protected $table = "estudiantes";
    protected $fillable = [
        'cobertura_id',
        'etnia',
        'cod_mun',
        'municipio',
        'escuela_ppal',
        'cod_escuela',
        'sede',
        'cod_sede',
        'territorio',
        'tipo_doc',
        'num_doc',
        'nombre_1',
        'nombre_2',
        'apellido_1',
        'apellido_2',
        'edad',
        'genero',
        'jornada',
        'grado',
        'estado',
        'grupo',
    ];

    public static function guardar($datos)
    {
        return DB::connection('mysql')->select($datos);
    }

    public static function buscarMunicipios($id)
    {
        return Estudiante::where('cobertura_id', $id)
            ->orderBy('municipio', 'ASC')
            ->groupBy('cod_mun')
            ->get();
    }

    public static function totalCobertura($id)
    {
        return Estudiante::where('cobertura_id', $id)
            ->count();
    }

    public static function listarTotColTotEstMun($id, $cod_mun)
    {
        if ($cod_mun == "0") {
            $sql = "SELECT
                    cod_mun,
                    municipio,
                    SUM(sedes) AS t_sedes,
                    COUNT(*) AS t_colegios,
                    SUM(total_alumnos) AS t_alumnos
                FROM
                    (SELECT
                        *, COUNT(*) AS sedes, SUM(num_alumnos) AS total_alumnos
                    FROM
                        (SELECT
                        *, COUNT(*) AS num_alumnos
                    FROM
                        estudiantes
                    GROUP BY cod_mun , cod_sede
                    ORDER BY escuela_ppal) AS con1
                    GROUP BY cod_mun , cod_escuela) AS con2
                GROUP BY cod_mun";
        } else {
            $sql = "SELECT
                    cod_mun,
                    municipio,
                    SUM(sedes) AS t_sedes,
                    COUNT(*) AS t_colegios,
                    SUM(total_alumnos) AS t_alumnos
                FROM
                    (SELECT
                        *, COUNT(*) AS sedes, SUM(num_alumnos) AS total_alumnos
                    FROM
                        (SELECT
                        *, COUNT(*) AS num_alumnos
                    FROM
                        estudiantes
                    GROUP BY cod_mun , cod_sede
                    ORDER BY escuela_ppal) AS con1
                    GROUP BY cod_mun , cod_escuela) AS con2
                WHERE cod_mun = $cod_mun
                GROUP BY cod_mun";
        }
        return DB::connection('mysql')->select($sql);
    }

    public static function listarTotSedTotEst($cod_mun)
    {
        $sql = "SELECT
                    *, COUNT(*) AS t_sedes, SUM(num_alumnos) AS t_alumnos
                FROM
                    (SELECT
                        *, COUNT(*) AS num_alumnos
                    FROM
                        estudiantes
                    GROUP BY cod_mun , cod_sede
                    ORDER BY escuela_ppal) AS con1
                WHERE
                    cod_mun = $cod_mun
                GROUP BY cod_mun , cod_escuela";

        return DB::connection('mysql')->select($sql);
    }

    public static function listarTotSed($cod_escuela)
    {
        $sql = "SELECT
                    cod_sede,
                    sede,
                    count(*) as total_alumnos
                FROM
                    estudiantes
                WHERE
                    cod_escuela = $cod_escuela
                GROUP BY cod_mun , cod_escuela , cod_sede
                ORDER BY sede";

        return DB::connection('mysql')->select($sql);
    }

    public function cobertura()
    {
        return $this->belongsTo(Cobertura::class);
    }
}
