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
            <td  style="" class="crece" >
                <table style="width:100%;padding:10px;text-align:left;">
                    <tr>
                        <td style="padding-left:10px;padding-right:10px;">
                            <table style="background:#ffffff;color:#666666"  width="100%">
                                <tr>
                                    <td style="padding:10px;">
                                        <black>PEDIDO TURNO ,</black> <br>
										Estimado(a) <?=isset($nombres_usuario)?$nombres_usuario.' '.$ape_paterno_usuario:' - '?><br>
										Tu pedido fue aceptado por <?=isset($razon_social)? $razon_social : ' - '?><br><br>
										Dirección envio <?=isset($direccion_fisica)? $direccion_fisica : ' - '?><br><br>
                                        # Número de pedido. <?=isset($idPedidoCliente)?$idPedidoCliente:' - '?><br><br>
										
                                        <? if($estado_ped<=4){?>

                                            <!-- Su pedido fue <?=($estado_ped == 2)? 'Produciodo':'Despachado'?> <br> -->
                                            Detalle:<br>
                                            <p style="padding-left:40px;">Ingrese aquí para ver el detalle de su pedido: <a href="<?=base_url()?>/cliente">turno.macctec.com</a></p>
                                            Estado:<br>
                                            
                                            <p style="padding-left:40px;"> <input type="checkbox" <?=($estado_ped == 2 || $estado_ped ==4)? "Checked": ""?>>  Realizado <?=($estado_ped == 2)? ":".$fecha_hora :""?></p>
                                            <p style="padding-left:40px;"> <input type="checkbox" <?=($estado_ped == 4 )? "Checked": ""?>>  Producido </p>
                                            <p style="padding-left:40px;"> <input type="checkbox" <?=($estado_ped == 4 )? "Checked": ""?>>  Despachado <?=($estado_ped == 4)? ":".$fecha_hora:'' ?></p>
                                            <?=($total_final_envio > 0)? "<strong><p>Total a pagar: S/.".$total_final_envio."</p></strong>": "0"?><br>
                                            <?=($estado_ped == 2 && $cod_medio_pago == 3)? "<p>Pago VISA: </p><a href='".$pago_visa."'>".$pago_visa."</a>": ""?><br>
                                            <?=($estado_ped == 2 && $cod_medio_pago == 2 && $numero_tarjeta !='')? "<p>Número: </p><strong>".$numero_tarjeta."</strong>": ""?><br>
                                            <?=($estado_ped == 4 && $medio_envio != '')? "<p>Su pedido sera enviado mediante: <p>".$medio_envio: ""?>
                                            <?=($estado_ped == 4 && $medio_envio == '')? "<p>Su pedido esta listo! <p>" : ""?>
                                            <?}else if($estado_ped>=5){?>
                                                Detalle:<br>
                                            <!-- <p style="padding-left:40px;">Ingrese al siguiente link: <a href="<?=base_url()?>/cliente">turno.macctec.com</a></p> -->
                                                <p style="padding-left: 40px;">Lo sentimos. Su pedido fue rechazado.</p>
                                            Estado:<br>
                                            
                                            <p style="padding-left:40px;"> <input type="checkbox" <?=($estado_ped == 5 )? "Checked": ""?>>  Rechazado <?=($estado_ped == 5)? ":".$fecha_hora :""?></p>
                                            <!-- <p style="padding-left:40px;"> <input type="checkbox" <?=($estado_ped == 4 )? "Checked": ""?>>  Producido </p>
                                            <p style="padding-left:40px;"> <input type="checkbox" <?=($estado_ped == 4 )? "Checked": ""?>>  Despachado <?=($estado_ped == 4)? ":".$fecha_hora:'' ?></p> -->
                                            <?}?>
                                    </td>
                                </tr>
                                <tr >
                                    <td style="padding:20px;font-size:10px;border-bottom: solid 1px #d4d4d4;">
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