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
                                        <black><?=isset($nombre_usuario)?$nombre_usuario:""  ?></black>, gracias por registrarte.<br>
                                        <p style="padding-left:40px;"> Desde ahora ya podrás hacer tus pedidos y compras en tus restaurantes y tiendas favoritas. </p>  
                                        Ingresa a <a href="<?=base_url()?>/home_cliente">turno.macctec.com</a> con tu
                                        usuario y clave:
                                        <p style="padding-left:40px;">Usuario:    <black><?=isset($usuario)?$usuario:"" ?></black></p>
                                        <p style="padding-left:40px;">Clave:    <black><?=isset($clave)?$clave:""?></black></p>
                                            
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