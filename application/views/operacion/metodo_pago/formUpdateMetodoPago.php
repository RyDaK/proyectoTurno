<form id="updateMetodoPago" class="form-horizontal form-label-left" role="form">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <h2 style="font-weight:600;">Metodo Pago</h2>
            <hr style="margin-top:10px;margin-bottom:15px;border:0;border-top:1px solid #0c0c0c;">

            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <label for="nombreMetodoPago">NOMBRE:</label>
                <input type="text" id="nombreMetodoPago" name="nombreMetodoPago" class="form-control" patron="requerido" value="<?= $data['nombre'] ?>">
                <input type="hidden" name="idMetodoPago" value="<?= $data['id_metodo_pag'] ?>">
            </div>
        </div>
    </div>
</form>