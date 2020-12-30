<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<style>
	  .eliminar {
			width:25%;
		}
		.crece{width:50% !important}
	@media (max-width: 991.98px){
	  .eliminar {
		display: none !important;
		}
		.crece{width:100% !important}
	}
	</style>
</head>
<body>
<div class="main-card mb-3 card">
    <div id="content-table" class="card-body">

    <table style="text-align:center;"  width="100%">
        <tr>
            <td style="" class="eliminar" >
            </td>
            <td style="" class="crece" >
                <table style="width:100%;text-align:left;">
                    <tr>
                        <td style="text-align:center;padding:10px;">
                            <img src ="<?=base_url()?>/public/assets/images/logo-inverse.png"    style="height: 67px;width: 156px;">
                        </td>
                    </tr>
                    <tr>
                        <td style="padding-left:10px;padding-right:10px;">
                            <table style="background:#ffffff;color:#666666"  width="100%">
                                <tr>
                                    <td style="padding:10px;line-height:32px;font-family:arial;font-size:24px;text-align:center;">
                                        <span style="color:#dc3545"> Recarga de creditos exitosa!  </span>
                                    </td>
                                </tr>
                                <tr >
                                    <td style="padding:10px;font-size:16px;border-bottom: solid 1px #d4d4d4;">
                                        Se ha recargado correctamente la suma de <?= isset($creditos_recarga) ?  $creditos_recarga :"-" ?> creditos  al comercio <?= isset($comercio['nombre']) ?  $comercio['nombre'] :"-" ?>.
                                    </td>
                                </tr>
                                <tr >
                                    <td style="padding:10px;font-size:16px;border-bottom: solid 1px #d4d4d4;">
                                        <p style="font-size:16px;"><?= isset($comercio['nombre']) ?  $comercio['nombre'] :"-" ?> - <?= isset($comercio['ruc']) ?  $comercio['ruc'] :"-" ?> </p>
                                        
                                    </td>
                                </tr>
                                <tr >
                                    <td style="padding:10px;font-size:16px;border-bottom: solid 1px #d4d4d4;">
                                        Fecha de Pago  :  <?= isset($fecha) ?  $fecha :"-" ?><br>
                                    </td>
                                </tr>
                            
                                <tr >
                                    <td style="padding:10px;font-size:16px;border-bottom: solid 1px #d4d4d4;">
                                        <p style="padding-left:40px;">Creditos Recarga Actual </p>
                                        <p style="padding-right:40px;text-align:right;"><?= isset($creditos_recarga) ?  $creditos_recarga :"-" ?> creditos </p>
                                        
                                        <p style="padding-left:40px;">Creditos Anteriores </p>
                                        <p style="padding-right:40px;text-align:right;"><?= isset($creditos_ant) ?  $creditos_ant :"-" ?> creditos </p>

                                        <p style="padding-left:40px;">Total Actual </p>
                                        <hr>
                                        <p style="padding-right:40px;text-align:right;"><strong><?= isset($creditos_act) ?  $creditos_act :"-" ?> creditos </strong>  </p>
                                    </td>
                                </tr>
                                <tr >
                                    <td style="padding:10px;font-size:10px;border-bottom: solid 1px #d4d4d4;">
                                        Sistema TURNO: Si tienes alguna consulta, envíanos un correo a hola@turno.com.pe o escríbenos a nuestro Whatsapp 915976629

                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
            <td style="" class="eliminar" >
            </td>
        </tr>
    </table>


      

    </div>
</div>
</body>
</html>