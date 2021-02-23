@extends('plantilla.principal')
@section('title','Cobertura')
@section('contenido')
<div class="kt-portlet" style="margin-top: -4%;">
  <div class="kt-portlet__head">
    <div class="kt-portlet__head-label">
      <h3 class="kt-portlet__head-title">
        <span class="kt-widget20__number kt-font-danger">Cargue de información de cobertura</span>
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
            @if(Session::has('error'))
            <div class="row">
              <div class="col-md-12">
                <div class="alert alert-danger alert-icon" role="alert">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <strong><i class="fa fa-frown-o mr-2" aria-hidden="true"></i>{!! session('error')
                    !!}</strong>
                </div>
              </div>
            </div>
            @endif
            @if(Session::has('success'))
            <div class="row">
              <div class="col-md-12">
                <div class="alert alert-success alert-icon" role="alert">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <strong><i class="fa fa-check-circle-o mr-2" aria-hidden="true"></i>{!!
                    session('success') !!}</strong>
                </div>
              </div>
            </div>
            @endif
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <!--begin::Form-->
            <form action="{{url('/cobertura/subir')}}" method="POST" class='kt-form
            kt-form--label-right' id="formUsu" enctype="multipart/form-data">
              {{ csrf_field() }}

              <div class="form-group row">
                <div class="col-lg-12">
                  <label>Archivo o Documento de Excel</label>
                  <div></div>
                  <div class="custom-file">
                    <input type="file" class="custom-file-input" id="archivo" accept=".xlsx" name="archivo">
                    <label class="custom-file-label" for="archivo">seleccione archivo</label>
                  </div>
                </div>
              </div>


              <div class="kt-separator kt-separator--brand"></div>
              <!--end::Form-->
              <div class="row justify-content-center">
                <div class="col-lg-4">
                  <button type="buttom" class="btn btn-primary btn-sm" id="btnGuardar"><i class="fa fa-edit"></i>
                    Validar</button>&nbsp;
                  <a href="{{ url('/cobertura') }}" class="btn btn-warning btn-sm"><i class="fa fa-window-close"></i>
                    Cancelar</a>&nbsp;
                  <a href="{{ url('/administracion') }}" class="btn btn-danger btn-sm"><i
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
@section('scripts')
<script>
  $(document).ready(function () {


        $("#btnGuardar").on({
            click: function(e){
                e.preventDefault();    
                // $("#formUsu").attr('target','_blank');
                $("#formUsu").submit();                            
            }
        });
    });
</script>
@endsection