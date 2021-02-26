<html>


<head>
    <style>
        body {
            margin: 1cm 1cm 1cm 1cm;

            /* font-size: 11px tahoma, arial, helvetica, sans-serif; */
            line-height: 1.2;
            color: #333;
        }

        table,
        td,
        th {
            border: 1px solid #595959;
            border-collapse: collapse;
            font-size: 10px tahoma, arial, helvetica, sans-serif;
        }

        .rotateObj {

            /* writing-mode: vertical-lr;*/
            transform: rotate(90deg);
        }

        .texto {
            font-size: 7px tahoma, arial, helvetica, sans-serif;
            color: #000000;
        }

        /** 
                Establezca los márgenes de la página en 0, por lo que el pie de página y el encabezado
                puede ser de altura y anchura completas.
             **/
        @page {
            margin: 0cm 0cm;
        }

        /** Defina ahora los márgenes reales de cada página en el PDF **/
        body {
            margin-top: 3cm;
            margin-left: 2cm;
            margin-right: 2cm;
            margin-bottom: 2cm;
        }

        /** Definir las reglas del encabezado **/
        header {
            position: fixed;
            top: 0cm;
            left: 0cm;
            right: 0cm;
            height: 3cm;
        }

        /** Definir las reglas del pie de página **/
        footer {
            position: fixed;
            bottom: 0cm;
            left: 0cm;
            right: 0cm;
            height: 2cm;
        }

        .page-break {
            page-break-after: always;
        }
    </style>
    <title>Pae | Planilla</title>

</head>

<body>
    @php
        $div=round(count($banco)/20);
        if($div < 1){ 
            $div=1; 
        } 
        echo $div." planillas"; 
    @endphp 
    @for ($ii=1; $ii <=$div; $ii++) {{$ii." planillas"}}

    <a href="{{url('/cobertura/generar')}}">
            imprimir
        </a>
        <table width=" 100%;">
        <thead>
            <tr>
                <th width="" colspan="4" rowspan="2">
                    <img width="120px" src="images/min-edu.png" alt="">
                    <img width="50px" src="images/apa.png" alt="">
                    <img width="35px" src="images/gober.png" alt="">
                    <img width="80px" src="images/pae.png" alt="">
                    <img width="50px" src="images/nutric.png" alt="">
                </th>
                <th width="" colspan="15" rowspan="2">Programa de Alimentación Escolar – PAE
                    Atención en el marco del Estado de Emergencia, Económica, Social y Ecológica, derivado de la
                    pandemia del COVID-19
                    Modalidad - Ración para Preparar en Casa</th>
                <th width="">Control</th>
                <th width="">Fecha</th>
            </tr>
            <tr>
                <th width="12px">Version 1</th>
                <th width="12px" class="">
                    <p class="page">
                        Página
                    </p>
                </th>
            </tr>
            <tr height="30px">
                <th width="" colspan="7">
                    ETC: DPTO______<br>
                </th>
                <th width="" colspan="7">
                    MUNICIPIO: ____________________<br>
                </th>
                <th width="" colspan="7">
                    MES DE ENTREGA: ___________________________<br>
                </th>
            </tr>
            <tr height="30px">
                <th width="" colspan="11">
                    OPERADOR: _______________________<br>
                </th>
                <th width="" colspan="10">
                    ESTABLECIMIENTO EDUCATIVO: ____________________<br>
                </th>
            </tr>
            <tr height="30px">
                <th width="" colspan="6">
                    LUGAR DE ENTREGA: _______________________<br>
                </th>
                <th width="" colspan="5">
                    DIRECCIÓN: ____________________<br>
                </th>
                <th width="" colspan="5">
                    ZONA RURAL: _______________________<br>
                </th>
                <th width="" colspan="5">
                    ZONA URBANA: ____________________<br>
                </th>
            </tr>
            <tr class="">
                <td class="texto" rowspan="3">N°</td>
                <td class="texto" width="240px" rowspan="3">NOMBRES Y APELLIDOS DEL ESTUDIANTE BEFICIARIO</td>
                <td class="texto" rowspan="3">
                    <p class="texto">GRADO</p>
                </td>
                <td class="texto" rowspan="3">IDENTIFICACION</td>
                <td class="texto" colspan="4">NIVEL</td>
                <td class="texto" colspan="9">CONFORMACIÓN RACIÓN PARA PREPARAR EN CASA (RPC)</td>
                <td class="texto" width="180px" rowspan="3">NOMBRE DE QUIEN RECIBE LA RACIÓN: PADRE, MADRE, ACUDIENTE
                </td>
                <td class="texto" rowspan="3">No. IDENTIFICACIÓN</td>
                <td class="texto" rowspan="3">TELÉFONO: FIJO / CELULAR</td>
                <td class="texto" width="100px" rowspan="3">FIRMA O HUELLA</td>
            </tr>
            <tr class="texto">
                <td rowspan="2">
                    <p class="rotateObj texto">PRESCOLAR</p>
                </td>
                <td rowspan="2">
                    <p class="rotateObj texto">PRIMARIA</p>
                </td>
                <td rowspan="2">
                    <p class="rotateObj texto">BASICA</p>
                </td>
                <td rowspan="2">
                    <p class="rotateObj texto">MEDIA</p>
                </td>
                <td class="texto">LÁCTEO</td>
                <td class="texto" colspan="3">PROTÉICOS</td>
                <td class="texto" colspan="3">CEREALES</td>
                <td class="texto">AZÚCAR</td>
                <td class="texto">GRASAS</td>
            </tr>
            <tr class="">
                <td>
                    <p class="rotateObj texto">LECHE EN POLVO</p>
                </td>
                <td>
                    <p class="rotateObj texto">ATÚN</p>
                </td>
                <td>
                    <p class="rotateObj texto">LENTEJAS</p>
                </td>
                <td>
                    <p class="rotateObj texto">ARVEJAS</p>
                </td>
                <td>
                    <p class="rotateObj texto">ARROZ</p>
                </td>
                <td>
                    <p class="rotateObj texto">PASTAS</p>
                </td>
                <td>
                    <p class="rotateObj texto">AVENA</p>
                </td>
                <td>
                    <p class="rotateObj texto">CHOCOLATE</p>
                </td>
                <td>
                    <p class="rotateObj texto">ACEITE</p>
                </td>
            </tr>
        </thead>
        <tbody>
            @php
            $i=1;
            $clase="";
            @endphp

            @foreach($banco as $k)

            <tr style="height: 18px" class="texto">


                <td>{{ $k->id }}</td>
                <td>{{ $k->nombre_1 }} {{ $k->nombre_2 }}{{ $k->apellido_1 }}{{ $k->apellido_2 }}</td>
                <td>{{ $k->id }}</td>
                <td>{{ $k->num_doc }}</td>
                <td>@if($k->grado<1) X @endif </td> <td>@if(($k->grado>0)&&($k->grado<6)) X @endif </td> <td>
                            @if(($k->grado>5)&&($k->grado<10)) X @endif </td> <td>@if($k->grado>9)
                                X
                                @endif
                </td>
                <td>{{ $k->id }}</td>
                <td>{{ $k->id }}</td>
                <td>{{ $k->id }}</td>
                <td>{{ $k->id }}</td>
                <td>{{ $k->id }}</td>
                <td>{{ $k->id }}</td>
                <td>{{ $k->id }}</td>
                <td>{{ $k->id }}</td>
                <td>{{ $k->id }}</td>
                <td></td>
                <td></td>
                <td></td>
                <td>@php
                    echo $i;
                    @endphp</td>
            </tr>
            @php

            $i++;
            if($i==21){
            $i=1;
            break;


            }

            @endphp
            @endforeach


        </tbody>
        <tfoot>
            <tr cellspacing="50px" style="margin-bottom: 5px;">
                <td class="observa" colspan="4">Observaciones: </td>
                <td class="observa" colspan="17"><br><br>
                    <p class="page">
                        Página
                    </p>sdsds<br><br>
                </td>
            </tr>
        </tfoot>
        </table>
        <div class="page-break"></div>
        @endfor

</body>

</html>