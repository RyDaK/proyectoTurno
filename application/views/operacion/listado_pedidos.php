<!-- Table  -->
<div class="row">
			<div class="col-md-12">
				<button id="btn-refresh" type="button" href="javascript:;" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="" data-original-title="Actualizar lista"><i class="fa fa-refresh" ></i> Actualizar</button>
			<button id="btn-new" type="button" href="javascript:;" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="" data-original-title="Agregar Pedido"><i class="fa fa-plus" ></i> Nuevo</button>
			<button id="btn-send" type="button" href="javascript:;" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="" data-original-title="Enviar Mensaje"><i class="fa fa-send" ></i> Enviar</button>
		</div>
	</div>
<table class="table table-bordered">
  <!-- Table head -->
  <thead>
    <tr>
      <th>
        <!-- Default unchecked -->
        <div class="custom-control custom-checkbox">
          <input type="checkbox" class="custom-control-input" id="tableDefaultCheck1">
          <label class="custom-control-label" for="tableDefaultCheck1">Check 1</label>
        </div>
      </th>
      <th>FECHA</th>
      <th>HORA</th>
      <th>COD_PED</th>
      <th>CLIENTE</th>
      <th>TIPO</th>
      <th>TIPO</th>
      <th>MEDIO DE PAGO</th>
      <th>TELEFONO</th>
      <th>DIRECCION</th>
      <th>ESTADO</th>
    </tr>
  </thead>
  <!-- Table head -->

  <!-- Table body -->
  <tbody>
    <tr>
      <th scope="row">
        <!-- Default unchecked -->
        <div class="custom-control custom-checkbox">
          <input type="checkbox" class="custom-control-input" id="tableDefaultCheck2" checked>
          <label class="custom-control-label" for="tableDefaultCheck2">Check 2</label>
        </div>
      </th>
      <td><?$fecha = new DateTime('now'); echo $fecha->getTimestamp(); ?></td>
      <td>Cell 2</td>
      <td>Cell 3</td>
    </tr>
    <tr>
      <th scope="row">
        <!-- Default unchecked -->
        <div class="custom-control custom-checkbox">
          <input type="checkbox" class="custom-control-input" id="tableDefaultCheck3">
          <label class="custom-control-label" for="tableDefaultCheck3">Check 3</label>
        </div>
      </th>
      <td>Cell 4</td>
      <td>Cell 5</td>
      <td>Cell 6</td>
    </tr>
    <tr>
      <th scope="row">
        <!-- Default unchecked -->
        <div class="custom-control custom-checkbox">
          <input type="checkbox" class="custom-control-input" id="tableDefaultCheck4">
          <label class="custom-control-label" for="tableDefaultCheck4">Check 4</label>
        </div>
      </th>
      <td>Cell 7</td>
      <td>Cell 8</td>
      <td>Cell 9</td>
    </tr>
  </tbody>
  <!-- Table body -->
</table>
<!-- Table  -->