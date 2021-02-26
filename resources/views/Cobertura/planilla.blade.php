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
                <th>#</th>
                <th>Municipio</th>
                <th style="text-align: center;"># Colegios</th>
                <th style="text-align: center;"># Sedes</th>
                <th style="text-align: center;">Total Estudiantes</th>
                <th></th>
              </tr>
            </thead>
            <tbody id="detalleCobertura">

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


<style>
  .btn-light{
    color: #7e8299;
    background-color: #f3f6f9;
    border-color: #f3f6f9;
  }
</style>
@endsection


@section('scripts')
<script>
  $(document).ready(function () {
    $("#cobertura").on({
      change: function(){
        let id = $(this).val();      
        var form = $("#formBusMun");
        var token = $("#token").val();
        let data = new FormData();
        data.append('id', id);
        data.append('_token', token);
        var url = form.attr("action");

        let padre = $(this).parent();

        $("#cobertura").addClass("is-valid");
        $("#cobertura").selectpicker('refresh');
        
        padre.removeClass("is-invalid");
        padre.addClass("is-valid");
        
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
              $("#municipio").html("");
              var campo = "";
              campo += "<option value='0'>Seleccione</option>";              
              for (var i = 0; i < respuesta.municipios.length; i++) {
                campo += "<option value='" + respuesta.municipios[i].cod_mun + "'>" + respuesta.municipios[i].municipio + "</option>";
              }
              $("#municipio").append(campo);
              $("#municipio").selectpicker('refresh');

              $("#CobTotal").html("Cobertura Total");
              $("#TotalCobertura").html(respuesta.total_cobertura + " Estudiantes");

              $("#detalleCobertura").html("");
              campo = "";
              if (respuesta.listado.length > 0) {
                for (var i = 0; i < respuesta.listado.length; i++) {
                  var k = i + 1;
                  campo += "<tr data-id='" + respuesta.listado[i].cod_mun + "' >";
                  campo += "<td style='font-weight: normal;vertical-align: middle;text-align: center;'>" + k + "</td>";
                  campo += "<td style='font-weight: normal;vertical-align: middle;text-align: left;'>" + respuesta.listado[i].municipio + "</td>";
                  campo += "<td style='font-weight: normal;vertical-align: middle;text-align: center;'>" + number_format(respuesta.listado[i].t_colegios, 0) + "</td>";
                  campo += "<td style='font-weight: normal;vertical-align: middle;text-align: center;'>" + number_format(respuesta.listado[i].t_sedes,0) + "</td>";
                  campo += "<td style='font-weight: normal;vertical-align: middle;text-align: center;'>" + number_format(respuesta.listado[i].t_alumnos,0) + "</td>";
                  campo += "<td class='center' style='font-weight: bold;vertical-align: middle;text-align:center;'>";
                  campo += "<button \n\
                            class='btn btn-icon btn-light btn-hover-primary btn-sm' title='Ver Municipio' data-toggle='tooltip' data-placement='top'>\n\
                            <svg xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink' width='24px' height='24px' viewBox='0 0 24 24' version='1.1' class='kt-svg-icon'>\n\
                                <g stroke='none' stroke-width='1' fill='none' fill-rule='evenodd'>\n\
                                    <rect id='bound' x='0' y='0' width='24' height='24'/>\n\
                                    <path d='M14.2928932,16.7071068 C13.9023689,16.3165825 13.9023689,15.6834175 14.2928932,15.2928932 C14.6834175,14.9023689 15.3165825,14.9023689 15.7071068,15.2928932 L19.7071068,19.2928932 C20.0976311,19.6834175 20.0976311,20.3165825 19.7071068,20.7071068 C19.3165825,21.0976311 18.6834175,21.0976311 18.2928932,20.7071068 L14.2928932,16.7071068 Z' id='Path-2' fill='#000000' fill-rule='nonzero' opacity='0.3'/>\n\
                                    <path d='M11,16 C13.7614237,16 16,13.7614237 16,11 C16,8.23857625 13.7614237,6 11,6 C8.23857625,6 6,8.23857625 6,11 C6,13.7614237 8.23857625,16 11,16 Z M11,18 C7.13400675,18 4,14.8659932 4,11 C4,7.13400675 7.13400675,4 11,4 C14.8659932,4 18,7.13400675 18,11 C18,14.8659932 14.8659932,18 11,18 Z' id='Path' fill='#000000' fill-rule='nonzero'/>\n\
                                </g>\n\
                            </svg>\n\
                            </button>";
                  campo += "</td>";
                  campo += "</tr>";                  
                }
              }else{

              }
              $("#detalleCobertura").append(campo);
            }
          },
          error: function () {

          }
        });
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
        }
      }
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