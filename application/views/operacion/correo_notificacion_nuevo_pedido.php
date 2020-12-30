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

                            <table style="background:#ffffff;color:#666666;"  width="100%">

                                <tr>

                                    <td style="padding:10px;">

                                        <black>PEDIDO TURNO ,</black> <br>

										<!-- Estimado(a) <?=isset($nombres_usuario)?$nombres_usuario.' '.$ape_paterno_usuario:' - '?><br> -->

										Se ha generado un nuevo pedido<br>

                                        # Cod Ped. <?=isset($idPedidoCliente)?$idPedidoCliente:' - '?><br>

                                        Punto de Venta: <?=!empty($punto_de_venta)? $punto_de_venta: '' ?><br>

                                        <?=!empty($Perfil_usuario)? 'Perfil usuario: '.$Perfil_usuario: '' ?><br>

                                        <?=($total_final_envio > 0)? "<strong><p>Total a pagar: S/.".dos_decimales($total_final_envio)."</p></strong>": "0"?><br>

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

            </td>

        </tr>

    </table>





      



    </div>

</div>

</body>

</html>