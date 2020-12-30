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

                        <td style="text-align:center;padding:10px;">

                            <img src ="<?=base_url()?>/public/assets/images/logo-inverse.png"    style="height: 67px;width: 156px;">

                        </td>

                    </tr>

                    <tr>

                        <td style="padding-left:10px;padding-right:10px;">

                            <table style="background:#ffffff;color:#666666"  width="100%">

                                <tr>

                                    <td style="padding:10px;">

                                        <black>PEDIDO TURNO</black> <br>

										<p>

                                            Estimado(a) <?=isset($nombres_usuario)?$nombres_usuario.' '.$ape_paterno_usuario:' - '?><br>

                                            

                                            <?=($estado_ped == 2)? "Tu pedido ha sido aceptado por:".$comercio."<br>": " "?>

                                            <?=($estado_ped == 4 && $medio_envio != '')? "Tu pedido ya esta en camino<br>": ""?>

                                            <?=($estado_ped == 4 && $medio_envio == '')? "<p>Su pedido esta listo! <p><br>" : ""?>

                                        </p>

                                        <p>

                                            <?=($medio_envio != '')? "Direccion de envío: <p>".$direccion_fisica."/<p>": "Local de Recojo: <p>".$direccion_pdv."</p>" ?><br>

                                           

                                        </p>

                                        <p>

                                            Código de Pedido: <?=isset($idPedidoCliente)?$idPedidoCliente:' - '?><br>

                                        </p>

										

                                        <? if($estado_ped<=4){?>



                                            <!-- Su pedido fue <?=($estado_ped == 2)? 'Produciodo':'Despachado'?> <br> -->

                                            <?if($estado_ped == 2){?>

                                                Detalle:<br>

                                                <p style="padding-left:40px;">Ingrese aquí para ver el detalle de tu pedido: <br><a href="<?=base_url().'home_cliente/gopedido/'.base64_encode($idPedidoCliente)?>">turno.macctec.com</a></p>

                                            <?}?>

                                           

                                            Estado:<br>

                                            

                                            <p style="padding-left:40px;"> <input type="checkbox" <?=($estado_ped == 2 || $estado_ped ==4)? "Checked": ""?>>  Realizado <?=($estado_ped == 2)? ":".$fecha_hora :""?></p>

                                            <p style="padding-left:40px;"> <input type="checkbox" <?=($estado_ped == 4 )? "Checked": ""?>>  Producido </p>

                                            <p style="padding-left:40px;"> <input type="checkbox" <?=($estado_ped == 4 )? "Checked": ""?>>  Despachado <?=($estado_ped == 4)? ":".$fecha_hora:'' ?></p>

                                            <?=($total_final_envio > 0)? "<strong><p>Total a pagar: S/.".dos_decimales($total_final_envio)."</p></strong>": "0"?><br>

                                            <?=($estado_ped == 2 && $cod_medio_pago == 3)? "<p>Si elegiste pago en Linea, ingresa al siguiente link: </p><a href='".$pago_visa."'>".$pago_visa."</a><p>Registra el monto, tu número de pedido y tus datos</p><br>": ""?>

                                            <?=($estado_ped == 4 )? "<p>Si ya pagaste online el monto es referencial</p><br>": ""?>
                                            
                                            <?=($estado_ped == 2 || $estado_ped == 4 )? "<p>Pago mediante: <strong>".$medio_pago_nombre."</strong></p>": ""?>
                                            
                                            <?if(!empty(trim($numero_tarjeta))){?>
                                            
                                                <?=($estado_ped == 2 || $estado_ped == 4 )? "<p>Número: <strong>".$numero_tarjeta."</strong></p>": ""?>
                                            
                                            <?}?>

                                            <?=/*($estado_ped == 4 && $medio_envio != '')? "<p>Su pedido sera enviado mediante: <p>".$medio_envio: ""?>

                                            <?=($estado_ped == 4 && $medio_envio == '')? "<p>Su pedido esta listo! <p>" : */""?>

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