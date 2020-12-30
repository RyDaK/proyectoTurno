<style type="text/css">

th{
    font-size: 12px;
}

td{
    font-size: 11px;
}

.input-total{
    height: 30px;
    width: 50%;
    padding-top: 3px;
    text-align: center;
    font-size: 80%;
}

.input-group-addon{
    width: 50%;
    height: 30px;
    background-color: #57cbb3; 
    color: white;
    text-align: center;
    padding-top: 3px;
    border-top-left-radius: 20px;
    border-bottom-left-radius:20px;
}

.btn-continuar{
    margin-left: 10px;
}

.caja-text-menu{
    padding-left: 0px;
}

.total-text-menu{
    width: 50%;
    background-color:red ; 
    color: white;
    font-size: 110%;
    padding-top: 2%;
}

.calendario-menu{
    width: 100%;
    border-color: #d1d1d1;
}
textarea{
    border-color: #d1d1d1; 
    width: 100%
}
.textarea-menu{
    padding-left: 0px;
}

.form-control.btn-sm.selectpicker{
    width: 80%;
}
.line-container {
width: 200px;
height: 20px;
}
.single-line {
width: 100%;
text-overflow: ellipsis;
overflow: hidden;
white-space: pre;
}
</style>
<table style="width: 100%; font-size: 9px" id="tb-list" class="table table-hover table-striped table-bordered line-container ">
<thead>
    <tr>
        <th></th>
      <th>FECHA</th>
      <th>HORA</th>
      <th>COD_PED</th>
      <th>CLIENTE</th>
      <th>TIPO</th>
      <th class="single-line" width="100px">MEDIO DE PAGO</th>
      <th>TELEFONO</th>
      <th>DIRECCION</th>
      <th>ESTADO</th>
    </tr>
</thead>
    <tbody>
        <?$i=1; foreach($data as $row){?>
    <tr data-id="<?=$row['idPedidoCliente'] ?>" class="">
        <td class="text-center" ></td>
        <td class="text-center" ><?=$row['fecha_']?></td>
            <td class="text-center" ><?=$row['hora_']?></td>
            <td class="text-center" ><?=''.$row['idPedidoCliente']?></td>
            <td class="text-center" ><?=$row['cliente']?></td>
            <td class="text-center" ><?=$row['medio_entrega_']?></td>
            <td class="text-center" ><?=$row['medio_pago_']?></td>
            <td class="text-center" ><?=$row['telefono']?></td>
            <td class="text-center" ><?=($row['direccion'])!='' ?$row['direccion'] : '-'?></td>
            <td class="text-center" ><?=$row['etapa']?></td>
        </tr>
    <?}?>
    </tbody>
</table>
