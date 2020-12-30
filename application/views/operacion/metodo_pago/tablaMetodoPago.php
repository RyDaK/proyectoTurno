<style>
    .fa-toggle-off:before {
    content: "\f204";
}
</style>
<div class="table-responsive" style="padding: 0.3em;">
<table style="width: 100%; font-size: 12px" id="tb-list" class="table table-hover table-striped table-bordered"  >
    <thead>
        <tr>
            <th style="text-align:center">OPCIONES</th>
            <th style="text-align:center">#</th>
            <th style="text-align:center">NOMBRE</th>
            <!--<th style="text-align:center">FECHA DE REGISTRO</th>
            <th style="text-align:center">FECHA DE ÚLTIMA MODIFICACIÓN</th>-->
            <th style="text-align:center">ACTIVO/INACTIVO</th>
        </tr>
    </thead>
    <tbody>
        <? $i = 1; ?>
        <? foreach ($data as $row) { ?>
            <tr>
                <td>
                    <div style="width:50px;" class="text-center">
                        <a href="javascript:;" class="btnEditar btn btn-default btn-xs" data-id="<?= $row['id_metodo_pag'] ?>" style="float: left;margin-right: 15px;"><i class="fas fa-pencil-alt"></i></a>
                        <?php if ($row['estado'] == 1) {
                            $icono = '<i class="fa fa-toggle-on"></i></a>';
                            $tipo = '0';
                        } else {
                            $icono = '<i class="fa fa-toggle-off"></i></a>';
                            $tipo = '1';
                        } ?>
                        <a  <?/*style="font-size:18px; " href="javascript:;"*/?> class="btnCambiarEstado" data-tipo="<?=$tipo?>" data-ix="<?=$row['id_metodo_pag']?>"><?=$icono?></a>
                    </div>
                </td>
                <td><?= $i ?></td>
                <td><?= !empty($row['nombre']) ? $row['nombre'] : '-' ?></td>
                <!--<td><?= !empty($row['fechaRegistro']) ? cambiarAFechaAgradableParaUsuario($row['fechaRegistro']) : '-' ?></td>
                <td><?= !empty($row['fechaModificacion']) ? cambiarAFechaAgradableParaUsuario($row['fechaModificacion']) : '-' ?></td>-->
                <td>
                    <?= ($row['estado'] == 1) ? '<label class="mb-2 mr-2 badge badge-success">Activo</label>' : '<label class="mb-2 mr-2 badge badge-danger">Inactivo</label>' ?>
                </td>
            </tr>
        <? $i++;
        } ?>
    </tbody>
</table>
</div>