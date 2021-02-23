@extends('plantilla.principal')
@section('title','Nuevo Proveedor')
@section('contenido')
<div class="kt-portlet" style="margin-top: -4%;">
  <div class="kt-portlet__head">
    <div class="kt-portlet__head-label">
      <h3 class="kt-portlet__head-title">
        <span class="kt-widget20__number kt-font-danger">Editar Proveedor </span>
      </h3>
    </div>
  </div>
  <div class="kt-portlet__body">
    <div class="kt-section">
      <div class="kt-section__content">
        <div class="row">
          <div class="col-md-12">
            @if($errors->any())
            <div class="alert alert-danger fade show" role="alert">
              <div class="alert-close">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true"><i class="la la-close"></i></span>
                </button>
              </div>
              <h6 class="letra">Por favor corrige los siguientes errores:</h6>
              <ul>
                @foreach($errors->all() as $error)
                <strong>
                  <li>{{ $error }}</li>
                </strong>
                @endforeach
              </ul>
            </div>
            @endif
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <!--begin::Form-->
            @include('Proveedores.form',
            ['proveedor'=>$proveedor,
            'vari'=>'PUT',
            'route'=>'/proveedores/modificar/'.$proveedor->id,
            'method'=>'POST'
            ])
            <!--end::Form-->
            <div class="row justify-content-center">
              <div class="col-lg-4">
                <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i> Guardar</button>&nbsp;
                <a href="{{ url('/proveedor/editar/'.$proveedor->id) }}" class="btn btn-warning btn-sm"><i
                    class="fa fa-window-close"></i> Cancelar</a>&nbsp;
                <a href="{{ url('/proveedores') }}" class="btn btn-danger btn-sm"><i
                    class="fa fa-angle-double-left"></i> Volver</a>&nbsp;
              </div>
            </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
