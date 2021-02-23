<form action="{{url($route)}}" method="{{$method}}" class="kt-form kt-form--label-right" id="formUsu"
  enctype="multipart/form-data">
  {{ csrf_field() }}
  @if($vari=="PUT")
  @method('PUT')
  @endif
  <div class="form-group row">
    <div class="col-lg-4">
      <label>Nit (*):</label>
      <input type="text" class="form-control" placeholder="Nit" name="nit_emp" id="nit_emp"
        value="{{old('nit_emp',$proveedor->nit_emp)}}" />
    </div>
    <div class="col-lg-8">
      <label>Nombre del Proveedor (*):</label>
      <input type="text" class="form-control" placeholder="Nombre del Proveedor" name="nombre_emp" id="nombre_emp"
        value="{{old('nombre_emp',$proveedor->nombre_emp)}}" />
    </div>
  </div>
  <div class="form-group row">
    <div class="col-lg-3">
      <label>Telefono (*):</label>
      <input type="text" class="form-control" placeholder="Telefono" name="tel_emp" id="tel_emp"
        value="{{old('tel_emp',$proveedor->tel_emp)}}" />
    </div>
    <div class="col-lg-9">
      <label>Dirección (*):</label>
      <input type="text" class="form-control" placeholder="Dirección" name="dir_emp" id="dir_emp"
        value="{{old('dir_emp',$proveedor->dir_emp)}}" />
    </div>
  </div>
  <div class="form-group row">
    <div class="col-lg-5">
      <label>Contacto (*):</label>
      <input type="text" class="form-control" placeholder="Contacto" name="contacto_emp" id="contacto_emp"
        value="{{old('contacto_emp',$proveedor->contacto_emp)}}" />
    </div>
    <div class="col-lg-3">
      <label>Celular (*):</label>
      <input type="text" class="form-control" placeholder="Celular" name="contacto_celular" id="contacto_celular"
        value="{{old('contacto_celular',$proveedor->contacto_celular)}}" />
    </div>
    <div class="col-lg-4">
      <label>Correo Electronico (*):</label>
      <input type="text" class="form-control" placeholder="Correo Electronico" name="contacto_correo"
        id="contacto_correo" value="{{old('contacto_correo',$proveedor->contacto_correo)}}" />
    </div>
  </div>
  <div class="form-group row">
    <div class="col-lg-5">
      <label for="componente_id">Componente</label>
      <select class="form-control kt-selectpicker" data-live-search="true" name="componente_id" id="componente_id">
        <option value="" selected>SELECCIONE</option>
        @foreach($componente as $com)
        <option value="{{$com->id}}" {{old('componente_id',$proveedor->componente_id)=="$com->id"?'selected':''}}>
          {{$com->nombre}}</option>
        @endforeach
      </select>
    </div>
  </div>