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

                                        <p>

                                            Te damos la Bienvenida ,  <b><?=isset($nombre_u)?$nombre_u:""  ?></b>

                                        </p>

                                        <p>

                                            Razón Social ,  <b><?=isset($razon_social)?$razon_social:""  ?></b>

                                        </p>

                                        <p>

                                            Nombre Comercial ,  <b><?=isset($nombre)?$nombre:""  ?></b>

                                        </p>



                                        Para comenzar a usar Turno, debes realizar lo siguiente:<br />

                                        <strong>Paso 1:</strong><br>

                                            <p style="padding-left:40px;">Ingrese al siguiente link: <a href="<?=base_url()?>/">turno.macctec.com</a></p>

                                        <strong>Paso 2:</strong><br>

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