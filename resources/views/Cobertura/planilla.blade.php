@extends('plantilla.principal')
@section('title','Planillas')
@section('contenido')
<div class="kt-portlet" style="margin-top: -4%;height: 90px;">
  <div class="kt-portlet__body">
    <div class="kt-section">
      <div class="kt-section__content">
        <div class="row">
          <div class="col-md-6">
            <select class="form-control kt-selectpicker is-invalid" title="Cobertura" data-live-search="true"
              name="cobertura" id="cobertura">
              <option value="0">Seleccione</option>
              @foreach ($cobertura as $cob)
              @php
              $primer = explode(' ',$cob->created_at);
              $anio = explode('-',$primer[0]);
              @endphp
              <option value="{{$cob->id}}">
                {{$cob->nombre."-".str_pad($cob->id,3,"0", STR_PAD_LEFT)."-".$meses[$cob->mes]."-".$anio[0]}}</option>
              @endforeach
            </select>
          </div>
          <div class="kt-space-20"></div>
          <div class="col-md-6">
            <select class="form-control kt-selectpicker is-invalid" title="Municipio" data-live-search="true"
              name="municipio" id="municipio">
              <option value="TODOS">Todos</option>
            </select>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="kt-portlet">
  <div class="kt-portlet__body">
    <div class="row">
      <div class="col-md-6">
        <div class="form-group row">
          <span class="kt-font-brand" style="font-size: 1.5rem;font-weight: 500;padding-left: 0.5rem;" id="CobTotal">

          </span>
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group row">
          <span class="kt-font-brand" style="font-size: 1.5rem;font-weight: 500;padding-left: 0.5rem;"
            id="TotalCobertura">
          </span>
        </div>
      </div>
    </div>
    {{-- <div class="kt-separator kt-separator--border-dashed"></div> --}}
    <div class="row">
      <div class="col-md-12">
        <div class="table-responsive">
          <table class="table" id="tablaCoberturas">
            <thead>
              <tr>
                <th style="text-align: center;">#</th>
                <th>Municipio</th>
                <th style="text-align: center;"># Colegios</th>
                <th style="text-align: center;"># Sedes</th>
                <th style="text-align: center;">Total Estudiantes</th>
                <th class='center' style='font-weight: bold;vertical-align: middle;text-align:center;'>
                  <button class='btn btn-icon btn-light btn-hover-primary btn-sm' title='Imprimir todas las planillas'
                    data-toggle='tooltip' data-placement='top'>
                    <svg xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink' width='24px'
                      height='24px' viewBox='0 0 24 24' version='1.1' class='kt-svg-icon'>
                      <g stroke='none' stroke-width='1' fill='none' fill-rule='evenodd'>
                        <rect id='bound' x='0' y='0' width='24' height='24' />
                        <path
                          d='M16,17 L16,21 C16,21.5522847 15.5522847,22 15,22 L9,22 C8.44771525,22 8,21.5522847 8,21 L8,17 L5,17 C3.8954305,17 3,16.1045695 3,15 L3,8 C3,6.8954305 3.8954305,6 5,6 L19,6 C20.1045695,6 21,6.8954305 21,8 L21,15 C21,16.1045695 20.1045695,17 19,17 L16,17 Z M17.5,11 C18.3284271,11 19,10.3284271 19,9.5 C19,8.67157288 18.3284271,8 17.5,8 C16.6715729,8 16,8.67157288 16,9.5 C16,10.3284271 16.6715729,11 17.5,11 Z M10,14 L10,20 L14,20 L14,14 L10,14 Z'
                          id='Combined-Shape' fill='#000000' />
                        <rect id='Combined-Shape-Copy' fill='#000000' opacity='0.3' x='8' y='2' width='8' height='2'
                          rx='1' />
                      </g>
                    </svg>
                  </button>
                </th>
              </tr>
            </thead>
            <tbody id="detalleCobertura">
              <tr>
                <td colspan='6' style='font-size: 30px;;vertical-align: middle;text-align:center;'>No existe cobertura
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
<form action="{{url('/cobertura/busMunicipios')}}" method="POST" style="display:inline-block;" id="formBusMun">
  <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
</form>


<form action="{{url('/cobertura/busColegios')}}" method="POST" style="display:inline-block;" id="formBusCol">
  <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
</form>
<!--begin::Modal-->
<div class="modal fade" id="modalMunicipios" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
            <div class="table-responsive">
              <table class="table table-sm table-hover ">
                <thead class="">
                  <tr class="kt-bg-fill-info">
                    <th style="text-align: center;">#</th>
                    <th style="text-align: center;">Colegio</th>
                    <th style="text-align: center;"># Sedes</th>
                    <th style="text-align: center;">Total Estudiantes</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody id="detalleColegio"></tbody>
              </table>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">
            <i class="la la-close"></i>
            Cerrar
          </button>
        </div>
      </div>
    </div>
  </div>
</div>
<!--end::Modal-->


<style>
  .btn-light {
    color: #7e8299;
    background-color: #f3f6f9;
    border-color: #f3f6f9;
  }
</style>
@endsection


@section('scripts')
<script>
  $(document).ready(function () {
    let coberturaGlobal = 0;
    $("#cobertura").on({
      change: function(){
        if($(this).val() === "0"){
          $("#CobTotal").html("");
          $("#TotalCobertura").html("");
          let padre = $(this).parent();
          $("#cobertura").removeClass("is-valid");
          $("#cobertura").selectpicker('refresh');

          padre.addClass("is-invalid");
          padre.removeClass("is-valid");
          $("#detalleCobertura").html("");
          let campo = "";
          campo += "<tr>";
            campo += "<td colspan='6' style='font-size: 30px;;vertical-align: middle;text-align:center;'>No existe cobertura</td>";
            campo += "</td>";
          campo += "</tr>";
          $("#detalleCobertura").append(campo);

          $("#municipio").html("");
          $("#municipio").append("<option value='0'>Seleccione</option>");

          $("#municipio").removeClass("is-valid");
          $("#municipio").addClass("is-invalid");
          $("#municipio").selectpicker('refresh');

          let padreMuni = $("#municipio").parent();  
          padreMuni.addClass("is-invalid");
          padreMuni.removeClass("is-valid");          
          $("#municipio").selectpicker('refresh');  
          return;

        }
        let id = $(this).val();
        coberturaGlobal = id;  
        var form = $("#formBusMun");
        var token = $("#token").val();
        let data = new FormData();
        data.append('id', id);
        data.append('id_mun', "0");
        data.append('_token', token);
        var url = form.attr("action");
        
        let padre = $(this).parent();

        $("#cobertura").addClass("is-valid");
        $("#cobertura").selectpicker('refresh');
        
        padre.removeClass("is-invalid");
        padre.addClass("is-valid");
        
        Calcular(id,form,token,data,url,"SI");
      }
    });

    $("#municipio").on({
      change: function(){
        let valor = $(this).val();        
        let padre = $(this).parent();
        if(valor === "0"){
          $(this).removeClass("is-valid");
          $(this).addClass("is-invalid");
          $(this).selectpicker('refresh');

          padre.addClass("is-invalid");
          padre.removeClass("is-valid");

          $("#cobertura").change();
          return false;          
        }else{
          $(this).removeClass("is-invalid");
          $(this).addClass("is-valid");   
          $(this).selectpicker('refresh');
          
          padre.removeClass("is-invalid");
          padre.addClass("is-valid");

          let id_mun = $(this).val();
          var id = $("#cobertura").val();
          var form = $("#formBusMun");
          var token = $("#token").val();
          let data = new FormData();
          data.append('id', id);
          data.append('id_mun', id_mun);
          data.append('_token', token);
          var url = form.attr("action");
          Calcular(id,form,token,data,url,"NO");

        }
      }
    });


    function Calcular(id,form,token,data,url,act){
      $.ajax({
        type: "post",
        url: url,
        data: data,
        dataType: "json",
        contentType: false,
        processData: false,
        cache: false,
        success: function (respuesta) {
          if(respuesta.opc === "SI"){
            if(act === "SI"){
              $("#municipio").html("");
              var campo = "";
              campo += "<option value='0'>Seleccione</option>";              
              for (var i = 0; i < respuesta.municipios.length; i++) {
                campo += "<option value='" + respuesta.municipios[i].cod_mun + "'>" + respuesta.municipios[i].municipio + "</option>";
              }
              $("#municipio").append(campo);
              $("#municipio").selectpicker('refresh');
            }

            $("#CobTotal").html("Cobertura Total");
            $("#TotalCobertura").html(respuesta.total_cobertura + " Estudiantes");

            $("#detalleCobertura").html("");
            campo = "";
            let sumColegios = 0, sumSedes = 0, sumEstu = 0;
            if (respuesta.listado.length > 0) {
              for (var i = 0; i < respuesta.listado.length; i++) {
                var k = i + 1;
                campo += "<tr data-id='" + respuesta.listado[i].cod_mun + "' \n\
                              data-municipio='" + respuesta.listado[i].municipio + "' \n\
                              data-total='" + respuesta.listado[i].t_alumnos + "' \n\
                          >";
                campo += "<td style='font-weight: normal;vertical-align: middle;text-align: center;'>" + k + "</td>";
                campo += "<td style='font-weight: normal;vertical-align: middle;text-align: left;'>" + respuesta.listado[i].municipio + "</td>";
                campo += "<td style='font-weight: normal;vertical-align: middle;text-align: center;'>";
                campo += "<div class='kt-badge kt-badge--md kt-badge--info'>"+ number_format(respuesta.listado[i].t_colegios, 0)
                campo += "</div>&nbsp;&nbsp;<button \n\
                          class='btn btn-icon btn-light btn-hover-primary btn-sm btn_verMun' title='Ver Municipio' data-toggle='tooltip' data-placement='top'>\n\
                          <svg xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink' width='24px' height='24px' viewBox='0 0 24 24' version='1.1' class='kt-svg-icon'>\n\
                              <g stroke='none' stroke-width='1' fill='none' fill-rule='evenodd'>\n\
                                  <rect id='bound' x='0' y='0' width='24' height='24'/>\n\
                                  <path d='M14.2928932,16.7071068 C13.9023689,16.3165825 13.9023689,15.6834175 14.2928932,15.2928932 C14.6834175,14.9023689 15.3165825,14.9023689 15.7071068,15.2928932 L19.7071068,19.2928932 C20.0976311,19.6834175 20.0976311,20.3165825 19.7071068,20.7071068 C19.3165825,21.0976311 18.6834175,21.0976311 18.2928932,20.7071068 L14.2928932,16.7071068 Z' id='Path-2' fill='#000000' fill-rule='nonzero' opacity='0.3'/>\n\
                                  <path d='M11,16 C13.7614237,16 16,13.7614237 16,11 C16,8.23857625 13.7614237,6 11,6 C8.23857625,6 6,8.23857625 6,11 C6,13.7614237 8.23857625,16 11,16 Z M11,18 C7.13400675,18 4,14.8659932 4,11 C4,7.13400675 7.13400675,4 11,4 C14.8659932,4 18,7.13400675 18,11 C18,14.8659932 14.8659932,18 11,18 Z' id='Path' fill='#000000' fill-rule='nonzero'/>\n\
                              </g>\n\
                          </svg>\n\
                          </button>"+ 
                "</td>";
                campo += "<td style='font-weight: 600;vertical-align: middle;text-align: center;'>" + number_format(respuesta.listado[i].t_sedes,0) + "</td>";
                campo += "<td style='font-weight: 600;vertical-align: middle;text-align: center;'>" + number_format(respuesta.listado[i].t_alumnos,0) + "</td>";
                campo += "<td class='center' style='font-weight: bold;vertical-align: middle;text-align:center;'>";
                campo += "<button \n\
                          class='btn btn-icon btn-light btn-hover-primary btn-sm' title='Imprimir Planillas' data-toggle='tooltip' data-placement='top'>\n\
                          <svg xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink' width='24px' height='24px' viewBox='0 0 24 24' version='1.1' class='kt-svg-icon'>\n\
                              <g stroke='none' stroke-width='1' fill='none' fill-rule='evenodd'>\n\
                                  <rect id='bound' x='0' y='0' width='24' height='24'/>\n\
                                  <path d='M16,17 L16,21 C16,21.5522847 15.5522847,22 15,22 L9,22 C8.44771525,22 8,21.5522847 8,21 L8,17 L5,17 C3.8954305,17 3,16.1045695 3,15 L3,8 C3,6.8954305 3.8954305,6 5,6 L19,6 C20.1045695,6 21,6.8954305 21,8 L21,15 C21,16.1045695 20.1045695,17 19,17 L16,17 Z M17.5,11 C18.3284271,11 19,10.3284271 19,9.5 C19,8.67157288 18.3284271,8 17.5,8 C16.6715729,8 16,8.67157288 16,9.5 C16,10.3284271 16.6715729,11 17.5,11 Z M10,14 L10,20 L14,20 L14,14 L10,14 Z' id='Combined-Shape' fill='#000000'/>\n\
                                  <rect id='Combined-Shape-Copy' fill='#000000' opacity='0.3' x='8' y='2' width='8' height='2' rx='1'/>\n\
                              </g>\n\
                          </svg>\n\
                          </button>"
                campo += "</td>";
                campo += "</tr>";
                sumColegios = sumColegios + Number(respuesta.listado[i].t_colegios);
                sumSedes = sumSedes + Number(respuesta.listado[i].t_sedes);
                sumEstu = sumEstu + Number(respuesta.listado[i].t_alumnos);
              }
              campo += "<tr>";
                campo += "<td colspan='2' style='font-weight: 700;font-size: 20px;;vertical-align: middle;text-align:center;'>Totales</td>";
                campo += "<td style='font-weight: 700;font-size: 20px;;vertical-align: middle;text-align:center;'>"+ number_format(sumColegios, 0)+"</td>";
                campo += "<td style='font-weight: 700;font-size: 20px;;vertical-align: middle;text-align:center;'>"+ number_format(sumSedes, 0)+"</td>";
                campo += "<td style='font-weight: 700;font-size: 20px;;vertical-align: middle;text-align:center;'>"+ number_format(sumEstu, 0)+"</td>";
              campo += "</tr>";                
            }else{
              campo += "<tr>";
                campo += "<td colspan='6' style='font-size: 30px;;vertical-align: middle;text-align:center;'>No existe cobertura</td>";
                campo += "</td>";
              campo += "</tr>";
            }
            $("#detalleCobertura").append(campo);
          }
        },
        error: function () {
        }
      });      
    }

    function BusColMunicipios(id,form,token,data,url){
      $.ajax({
        type: "post",
        url: url,
        data: data,
        dataType: "json",
        contentType: false,
        processData: false,
        cache: false,
        success: function (respuesta) {
          if(respuesta.opc === "SI"){
            $("#detalleColegio").html("");
            campo = "";
            let sumSedes = 0, sumEstu = 0;
            if (respuesta.listado.length > 0) {
              for (var i = 0; i < respuesta.listado.length; i++) {
                var k = i + 1;
                campo += "<tr data-id='" + respuesta.listado[i].cod_escuela + "'>";
                campo += "<td style='font-weight: normal;vertical-align: middle;text-align: center;'>" + k + "</td>";
                campo += "<td style='font-weight: normal;vertical-align: middle;text-align: left;'>" + respuesta.listado[i].escuela_ppal + "</td>";
                campo += "<td style='font-weight: normal;vertical-align: middle;text-align: center;'>";
                campo += "<div class='kt-badge kt-badge--md kt-badge--info'>"+ number_format(respuesta.listado[i].t_sedes, 0)
                campo += "</div>&nbsp;&nbsp;";
                campo += "<div class='dropdown dropdown-inline munupeque'>";
                  campo += "<button type='button' class='btn btn-success btn-elevate-hover btn-icon btn-sm btn-icon-md btn-circle' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>";
                  campo += "<i class='flaticon-more-1'></i>";
                  campo += "</button>";
                  campo += "<div class='dropdown-menu dropdown-menu-right' style='width: 500px;'>";                    
                  for(var j = 0;j<respuesta.listado[i].listadoSedes.length;j++){
                    campo += "<div class='row'>";
                      campo += "<div class='col-md-8'>";  
                        campo += "<a class='dropdown-item' href='javascript:;'><i class='la la-building'></i>&nbsp;&nbsp;"; 
                        campo += respuesta.listado[i].listadoSedes[j].sede + " </a>";
                      campo += "</div>";
                      campo += "<div class='col-md-2' style='font-weight: 600;vertical-align: middle;text-align: center;'>";
                        campo += "<div class='kt-badge kt-badge--danger kt-badge--inline kt-badge--pill kt-badge--rounded'>"+ number_format(respuesta.listado[i].listadoSedes[j].total_alumnos, 0) + "</div>"
                      campo += "</div>";                      
                      campo += "<div class='col-md-2'>";
                        let rutaSedes = '{{url("/descargarVista/SEDES/")}}/' + respuesta.listado[i].listadoSedes[j].cod_sede + "/" + coberturaGlobal;                        
                        campo += "<a target='_blank' class='btn btn-outline-primary btn-icon btn-sm' href='"+rutaSedes+"'><i class='la la-print'></i>";
                      campo += "</div>";  
                    campo += "</div>";
                    campo += "<div class='kt-space-5'></div>";
                  }                                    
                  campo += "</div>";                  
                campo += "</div>";
                campo += "</td>";                
                campo += "<td style='font-weight: 600;vertical-align: middle;text-align: center;'>" + number_format(respuesta.listado[i].t_alumnos,0) + "</td>";
                campo += "<td class='center' style='font-weight: bold;vertical-align: middle;text-align:center;'>";
                campo += "<button \n\
                          class='btn btn-icon btn-light btn-hover-primary btn-sm' title='Imprimir Planillas' data-toggle='tooltip' data-placement='top'>\n\
                          <svg xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink' width='24px' height='24px' viewBox='0 0 24 24' version='1.1' class='kt-svg-icon'>\n\
                              <g stroke='none' stroke-width='1' fill='none' fill-rule='evenodd'>\n\
                                  <rect id='bound' x='0' y='0' width='24' height='24'/>\n\
                                  <path d='M16,17 L16,21 C16,21.5522847 15.5522847,22 15,22 L9,22 C8.44771525,22 8,21.5522847 8,21 L8,17 L5,17 C3.8954305,17 3,16.1045695 3,15 L3,8 C3,6.8954305 3.8954305,6 5,6 L19,6 C20.1045695,6 21,6.8954305 21,8 L21,15 C21,16.1045695 20.1045695,17 19,17 L16,17 Z M17.5,11 C18.3284271,11 19,10.3284271 19,9.5 C19,8.67157288 18.3284271,8 17.5,8 C16.6715729,8 16,8.67157288 16,9.5 C16,10.3284271 16.6715729,11 17.5,11 Z M10,14 L10,20 L14,20 L14,14 L10,14 Z' id='Combined-Shape' fill='#000000'/>\n\
                                  <rect id='Combined-Shape-Copy' fill='#000000' opacity='0.3' x='8' y='2' width='8' height='2' rx='1'/>\n\
                              </g>\n\
                          </svg>\n\
                          </button>"
                campo += "</td>";
                campo += "</tr>";
                sumSedes = sumSedes + Number(respuesta.listado[i].t_sedes);
                sumEstu = sumEstu + Number(respuesta.listado[i].t_alumnos);
              }
              campo += "<tr>";
                campo += "<td colspan='2' style='font-weight: 700;font-size: 20px;;vertical-align: middle;text-align:center;'>Totales</td>";
                campo += "<td style='font-weight: 700;font-size: 20px;;vertical-align: middle;text-align:center;'>"+ number_format(sumSedes, 0)+"</td>";
                campo += "<td style='font-weight: 700;font-size: 20px;;vertical-align: middle;text-align:center;'>"+ number_format(sumEstu, 0)+"</td>";
              campo += "</tr>";                
            }else{
              campo += "<tr>";
                campo += "<td colspan='6' style='font-size: 30px;;vertical-align: middle;text-align:center;'>No existen colegios</td>";
                campo += "</td>";
              campo += "</tr>";
            }
            $("#detalleColegio").append(campo);
          }
        },
        error: function () {
        }
      });
    }

    $('#detalleCobertura').on("click", ".btn_verMun", function (e) {
        e.preventDefault();
        var fila = $(this).parents('tr');
        let cod_mun = fila.data('id');

        var form = $("#formBusCol");
        var token = $("#token").val();
        let data = new FormData();
        data.append('cod_mun', cod_mun);
        data.append('_token', token);
        var url = form.attr("action");        

        $("#exampleModalLabel").html(fila.data('municipio') + "(" + number_format(fila.data('total'),0) + " Estudiantes)");
        BusColMunicipios(cod_mun,form,token,data,url);
        $("#modalMunicipios").modal("show");
    });    


    function number_format(amount, decimals) {

      amount += ''; // por si pasan un numero en vez de un string
      amount = parseFloat(amount.replace(/[^0-9\.]/g, '')); // elimino cualquier cosa que no sea numero o punto

      decimals = decimals || 0; // por si la variable no fue fue pasada

      // si no es un numero o es igual a cero retorno el mismo cero
      if (isNaN(amount) || amount === 0)
          return parseFloat(0).toFixed(decimals);

      // si es mayor o menor que cero retorno el valor formateado como numero
      amount = '' + amount.toFixed(decimals);

      var amount_parts = amount.split('.'),
              regexp = /(\d+)(\d{3})/;

      while (regexp.test(amount_parts[0]))
          amount_parts[0] = amount_parts[0].replace(regexp, '$1' + ',' + '$2');

      return amount_parts.join('.');
    }    
  });
</script>
@endsection