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
              <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">

              <div class="upload_file">
                <div class="form-group row">
                  <div class="col-lg-12">
                    <div class="alert alert-light alert-elevate" role="alert">
                      <div class="alert-icon"><i class="flaticon-warning kt-font-brand"></i></div>
                      <div class="alert-text">
                        <b>1</b>. EL documento excel debe tener los emcabezados tal cual lo contiene el documento de descarga<br>
                        <b>2</b>. Todas las columnas del documento excel deben ser de formato texto<br>
                        <b>3</b>. EL documento excel debe contener un solo libro<br>

                        <b>?</b>. Descargue el formato modelo, para evitar errores al subir la cobertura
                      </div>
                    </div>                                      
                  </div>
                </div>
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
                <div class="kt-space-10"></div>
                <div class="wrapper mt-5" style="display: none;">
                  <div class="col-lg-12">
                    <div class="progress progress-lg progress_wrapper">
                      <div class="progress-bar bg-success progress-bar-animated" role="progressbar" style="width: 0%;"
                        aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="wrapper_files">

              </div>


              <div class="kt-separator kt-separator--brand"></div>
              <!--end::Form-->
              <div class="row justify-content-center">
                <div class="col-lg-5">
                  <button type="buttom" class="btn btn-primary btn-sm" id="btnGuardar">
                    <i id='iconoBoton' class="fa fa-edit"></i>
                    Subir</button>&nbsp;
                  <a href="{{ url('/cobertura') }}" class="btn btn-warning btn-sm"><i class="fa fa-window-close"></i>
                    Cancelar</a>&nbsp;
                  <a href="{{ url('/administracion') }}" class="btn btn-danger btn-sm"><i
                      class="fa fa-angle-double-left"></i> Volver</a>&nbsp;
                  <a href="{{ url('/cobertura/descargar') }}" class="btn btn-success btn-sm"><i
                      class="fa fa-cloud-download-alt"></i> Descargar</a>&nbsp;
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
                if($("#archivo").val()===""){
                  swal.fire("Validando...","Seleccione un archivo","error");
                  return;
                }

                var formulario = $("#formUsu");
                var url = formulario.attr("action");
                var token = $("#token").val();

                let form = $('#archivo')[0].files[0],
                wrapper = $(".wrapper"),
                wrapper_f = $(".wrapper_files"),
                progress_bar = $(".progress-bar");
                let data = new FormData();
                data.append('archivo', form);
                data.append('_token', token);

                progress_bar.removeClass('bg-success bg-danger').addClass('bg-info');
                progress_bar.css('width','0%');
                progress_bar.html('Preparando');
                wrapper.fadeIn();

                let percentComplete=0;
                
                $.ajax({
                  xhr: function(){
                    let xhr = new window.XMLHttpRequest();
                    xhr.upload.addEventListener("progress", function(e){
                      if(e.lengthComputable){
                        percentComplete = Math.floor((e.loaded / e.total) * 100);

                        let rando = Math.floor((Math.random() * (60 - 35 + 1)) + 35);
                        console.log(rando);

                        percentComplete = Math.floor(percentComplete * (rando/100));

                        // Mostramos el progreso
                        progress_bar.css('width', percentComplete + '%');
                        progress_bar.html(percentComplete + '%');
                      }
                    }, false);

                    return xhr;
                  },
                  type: 'POST',
                  url: url,
                  dataType: "json",
                  contentType: false,
                  processData: false,
                  cache: false,
                  data: data,
                  beforeSend: ()=>{
                    $("#btnGuardar").attr("disabled",true);
                    $("#btnGuardar").addClass("kt-spinner kt-spinner--left kt-spinner--sm kt-spinner--light");                    
                    $("#iconoBoton").css('display','none');
                  }
                }).done(res =>{
                  // if(res.status === 200){}                  
                  progress_bar.removeClass('bg-info').addClass('bg-success');
                  percentComplete = 100; 
                  progress_bar.css('width', percentComplete + '%');
                  progress_bar.html(percentComplete + '%');
                  formulario.trigger('reset');
                  $('#archivo').val("");

                  setTimeout(()=>{
                    swal.fire("Cargando...","Cobertura cargada con exito","success");
                  },1000);

                  setTimeout(()=>{
                    progress_bar.removeClass('bg-success bg-danger').addClass('bg-info');
                    progress_bar.css('width','0%');
                    wrapper.fadeOut();
                  },5000);                                      
                }).fail( err=> {
                  progress_bar.removeClass('bg-success bg-info').addClass('bg-danger');
                  progress_bar.html('Ocurrio un error'); 
                }).always(()=> {
                  $("#btnGuardar").attr("disabled",false);
                  $("#iconoBoton").css('display','inline-block');
                  $("#btnGuardar").removeClass("kt-spinner kt-spinner--left kt-spinner--sm kt-spinner--light");
                });                         
            }
        });
    });
</script>
@endsection