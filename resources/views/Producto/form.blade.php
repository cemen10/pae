<form action="{{url($route)}}" method="{{$method}}" class="kt-form kt-form--label-right" id="formUsu"
  enctype="multipart/form-data">
  {{ csrf_field() }}
  @if($vari=="PUT")
  @method('PUT')
  @endif
  <div class="form-group row">
    <div class="col-lg-6">
      <label>Producto (*):</label>
      <input type="text" class="form-control" placeholder="Producto" name="nombre" id="nombre"
        value="{{old('nombre',$producto->nombre)}}" />
    </div>
    <div class="col-lg-3">
      <label>Peso/Cantidad (*):</label>
      <input type="text" class="form-control" placeholder="Peso/Cantidad" name="peso" id="peso"
        value="{{old('peso',$producto->peso)}}" />
    </div>
    <div class="col-lg-3">
      <label>Unidad (*):</label>
      <select class="form-control kt-selectpicker" data-live-search="true" name="unidad_id" id="unidad_id">
        <option value="" {{old('unidad_id',$producto->unidad_id)==""?'selected':''}}>SELECCIONE</option>
        <option value="1" {{old('unidad_id',$producto->unidad_id)=="1"?'selected':''}}>Kg</option>
        <option value="2" {{old('unidad_id',$producto->unidad_id)=="2"?'selected':''}}>Cm3/CC</option>
        <option value="3" {{old('unidad_id',$producto->unidad_id)=="3"?'selected':''}}>ml</option>
        <option value="4" {{old('unidad_id',$producto->unidad_id)=="4"?'selected':''}}>Gr</option>
        <option value="5" {{old('unidad_id',$producto->unidad_id)=="5"?'selected':''}}>Pacas</option>
      </select>
    </div>
  </div>
  <div class="form-group row">
    <div class="col-lg-8">
      <label>Descripción:</label>
      <input type="text" class="form-control" placeholder="Descripción" name="detalle" id="detalle"
        value="{{old('detalle',$producto->detalle)}}" />
    </div>
    <div class="col-lg-4">
      <label for="componente_id">Componente</label>
      <select class="form-control kt-selectpicker" data-live-search="true" name="componente_id" id="componente_id">
        <option value="" selected>SELECCIONE</option>
        @foreach($componente as $com)
        <option value="{{$com->id}}" {{old('componente_id',$producto->componente_id)=="$com->id"?'selected':''}}>
          {{$com->nombre}}</option>
        @endforeach
      </select>
    </div>
  </div>