@extends('plantilla.principal')
@section('title','Gestión de Proveedores')
@section('contenido')
<div class="kt-portlet" style="margin-top: -4%; ">
  <div class="kt-portlet__head">
    <div class="kt-portlet__head-label">
      <h3 class="kt-portlet__head-title">
        <span class="kt-widget20__number kt-font-danger">Gestión de proveedores</span>
      </h3>
    </div>
  </div>
  <div class="kt-portlet__body">
    <div class="kt-section">
      <div class="kt-section__content">
        <div class="row">
          <div class="col-md-12">
            @if(Session::has('error'))
            <div class="row">
              <div class="col-md-12">
                <div class="alert alert-danger alert-icon" role="alert">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <strong>
                    <i class="fa fa-frown-o mr-2" aria-hidden="true"></i>
                    {!! session('error') !!}
                  </strong>
                </div>
              </div>
            </div>
            @endif
            @if(Session::has('success'))
            <div class="row">
              <div class="col-md-12">
                <div class="alert alert-success alert-icon" role="alert">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <strong>
                    <i class="fa fa-check-circle-o mr-2" aria-hidden="true"></i>
                    {!! session('success') !!}
                  </strong>
                </div>
              </div>
            </div>
            @endif
          </div>
        </div>
        <div class="row">
          <div class="col-md-6 col-lg-6">
            <div class="kt-section">
              <div class="kt-section__content ">
                <a href="{{ url('/proveedores/nuevo') }}" class="btn btn-outline-primary btn-icon" data-skin="dark"
                  data-toggle="kt-tooltip" data-placement="top" title="Nuevo Proveedor"><i
                    class="la la-file-text-o"></i></a>&nbsp;
                <a class="btn btn-outline-warning btn-icon" data-skin="dark" data-toggle="kt-tooltip"
                  data-placement="top" title="Exportar a Pdf"><i class="la la-file-pdf-o"></i></a>&nbsp;
              </div>
            </div>
          </div>
          <div class="col-md-6 col-lg-6">
            <form action="{{url('/proveedores')}}" method="GET" id="formUsu" enctype="multipart/form-data">
              <div class="form-group ">
                <div class="input-group">
                  <input type="text" name="txtbusqueda" id="txtbusqueda" class="form-control" placeholder="BUSQUEDA"
                    value="{{old('txtbusqueda',$busqueda)}}">
                  <div class="input-group-append">
                    <button type="submit" class="btn btn-primary btn-icon">
                      <i class="fa fa-search"></i>
                    </button>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>

        <div class="row">
          <div class="col-md-12">
            <div class="table-responsive">
              <table class="table table-sm table-hover ">
                <thead class="">
                  <tr class="kt-bg-fill-brand">
                    <th>No.</th>
                    <th>Nit</th>
                    <th>Empresa</th>
                    <th>Telefono</th>
                    <th>Dirección</th>
                    <th>Componente</th>
                    <th>Contacto</th>
                    <th>Correo</th>
                    <th>Celular</th>
                    <td class="text-center">Estado</td>
                    <td class="text-center">Opciones</td>
                  </tr>
                </thead>
                <tbody>
                  @foreach($proveedor as $usu)
                  <tr data-id='{{$usu->id}}'>
                    <td scope="row" style='font-weight: bold;vertical-align: middle;'>
                      {{ $loop->iteration }}</td>
                    <td style='font-weight: normal;vertical-align: middle;text-transform: capitalize;'>
                      {{$usu->nit_emp}}</td>
                    <td style='font-weight: normal;vertical-align: middle;text-transform: capitalize;'>
                      {{$usu->nombre_emp}}</td>
                    <td style='font-weight: normal;vertical-align: middle;text-transform: capitalize;'>
                      {{$usu->tel_emp}}</td>
                    <td style='font-weight: normal;vertical-align: middle;text-transform: capitalize;'>
                      {{$usu->dir_emp}}</td>
                    <td style='font-weight: normal;vertical-align: middle;text-transform: capitalize;'>
                      {{$usu->nombre}}</td>
                    <td style='font-weight: normal;vertical-align: middle;text-transform: capitalize;'>
                      {{$usu->contacto_emp}}</td>
                    <td style='font-weight: normal;vertical-align: middle;text-transform: capitalize;'>
                      {{$usu->contacto_correo}}</td>
                    <td style='font-weight: normal;vertical-align: middle;text-transform: capitalize;'>
                      {{$usu->contacto_celular}}</td>
                    @if($usu->estado=='Activo')
                    <td style='font-weight: normal;vertical-align: middle;' class="text-center">
                      <span
                        class="kt-badge kt-badge--success kt-badge--inline kt-badge--pill kt-badge--rounded">{{$usu->estado}}</span>
                    </td>
                    <td style='text-align:center;vertical-align: middle;'>
                      <a href="{{ url("/proveedores/editar/".$usu->id)}}" class="btn btn-outline-info btn-sm btn-icon"
                        title="Editar">
                        <i class='fa fa-edit' aria-hidden='true'></i>
                      </a>
                      <a href="#" class="btn btn-outline-danger btn-sm btn-icon btnEliminar" title="Eliminar">
                        <i class='fa fa-trash ' id="iconBoton{{$usu->id}}" aria-hidden='true'></i>
                      </a>
                    </td>
                    @else
                    <td style='font-weight: bold;vertical-align: middle;' class="text-center">
                      <span
                        class="kt-badge kt-badge--danger kt-badge--inline kt-badge--pill kt-badge--rounded">{{$usu->estado}}</span>
                    </td>
                    <td style='text-align:center;vertical-align: middle;'>
                      <a href="{{ url("/proveedores/editar/".$usu->id)}}" class="btn btn-outline-info btn-sm btn-icon"
                        title="Editar">
                        <i class='fa fa-edit' aria-hidden='true'></i>
                      </a>
                      <a href="#" class="btn btn-outline-success btn-sm btn-icon btnEliminar" title="Activar">
                        <i class='fa fa-check ' id="iconBoton{{$usu->id}}" aria-hidden='true'></i>
                      </a>
                    </td>
                    @endif
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
            @include('Proveedores.paginacion')
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<form action="{{url('/proveedores/eliminar')}}" method="POST" style="display:inline-block;" id="formDelPro">
  {{ csrf_field() }}
</form>
@endsection

@section('scripts')
<script>
  $(document).ready(function () {
    $(".btnEliminar").on({
      click: function (e) {
        e.preventDefault();
        var boton = $(this);
        var hijo = $(this).children('i');
        var fila = $(this).parents('tr');
        var id = fila.data('id');
        var form = $("#formDelPro");
        $("#idAuxiliar").remove();
        form.append("<input type='hidden' name='id' id='idAuxiliar' value='" + id + "'>");
        var url = form.attr("action");
        var datos = form.serialize();
        var mensaje = "";
        var cadena = fila.find("td:eq(9)").text();
        if (cadena.trim() === "Inactivo") {
            mensaje = "¿Desea activar este proveedor?";
        } else {
            mensaje = "¿Desea eliminar este proveedor?";
        }
        swal.fire({
            title: mensaje,
            text: "",
            type: 'warning',
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Aceptar',
            cancelButtonText: 'Cancelar',
            reverseButtons: true
        }).then(function(result){
          if (result.value === true) {
            $.ajax({
              type: "post",
              url: url,
              data: datos,
              success: function (respuesta) {
                swal.fire(
                    "",
                    respuesta.mensaje,
                    "success"                                    
                );
                if (cadena.trim() === "Inactivo") {
                    $(boton).removeClass('btn-outline-success');
                    $(boton).addClass('btn-outline-danger');
                    $(boton).attr('title', 'Eliminar');
                    $("#" + hijo.attr('id')).removeClass('fa-check');
                    $("#" + hijo.attr('id')).addClass('fa-trash');
                    $("#" + hijo.attr('id')).removeClass('fa-check');
                    $("#" + hijo.attr('id')).addClass('fa-trash');
                    fila.find("td:eq(9) span").removeClass("kt-badge--danger");
                    fila.find("td:eq(9) span").addClass("kt-badge--success");
                    fila.find("td:eq(9) span").text('Activo')
                } else {
                    $(boton).removeClass('btn-outline-danger');
                    $(boton).addClass('btn-outline-success');
                    $(boton).attr('title', 'Activar');
                    $("#" + hijo.attr('id')).removeClass('fa-trash');
                    $("#" + hijo.attr('id')).addClass('fa-check');
                    $("#" + hijo.attr('id')).removeClass('fa-trash');
                    $("#" + hijo.attr('id')).addClass('fa-check');
                    fila.find("td:eq(9) span").removeClass("kt-badge--success");
                    fila.find("td:eq(9) span").addClass("kt-badge--danger");
                    fila.find("td:eq(9) span").text('Inactivo')
                }
              },
              error: function () {
                  if (cadena.trim() === "Inactivo") {
                      mensaje = "Proveedor no activado";
                  } else {
                      mensaje = "Proveedor no eliminado";
                  }
                  swal.fire(
                      "",
                      mensaje,
                      "error"                                    
                  );
              }
            });
          }
        });                
      }
    });
  });
</script>
@endsection