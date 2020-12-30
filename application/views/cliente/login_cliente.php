<style>
body {
    padding-top: 90px;
}
.panel-login {
	border-color: #ccc;
	/* -webkit-box-shadow: 0px 2px 3px 0px rgba(0,0,0,0.2);
	-moz-box-shadow: 0px 2px 3px 0px rgba(0,0,0,0.2);
	box-shadow: 0px 2px 3px 0px rgba(0,0,0,0.2); */
}
.panel-login>.panel-heading {
	color: #00415d;
	background-color: #fff;
	border-color: #fff;
	text-align:center;
}
.panel-login>.panel-heading a{
	text-decoration: none;
	color: #666;
	font-weight: bold;
	font-size: 15px;
	-webkit-transition: all 0.1s linear;
	-moz-transition: all 0.1s linear;
	transition: all 0.1s linear;
}
.panel-login>.panel-heading a.active{
	color: #029f5b;
	font-size: 18px;
}
.panel-login>.panel-heading hr{
	margin-top: 10px;
	margin-bottom: 0px;
	clear: both;
	border: 0;
	height: 1px;
	background-image: -webkit-linear-gradient(left,rgba(0, 0, 0, 0),rgba(0, 0, 0, 0.15),rgba(0, 0, 0, 0));
	background-image: -moz-linear-gradient(left,rgba(0,0,0,0),rgba(0,0,0,0.15),rgba(0,0,0,0));
	background-image: -ms-linear-gradient(left,rgba(0,0,0,0),rgba(0,0,0,0.15),rgba(0,0,0,0));
	background-image: -o-linear-gradient(left,rgba(0,0,0,0),rgba(0,0,0,0.15),rgba(0,0,0,0));
}
.panel-login input[type="text"],.panel-login input[type="email"],.panel-login input[type="password"] {
	height: 45px;
	border: 1px solid #ddd;
	font-size: 16px;
	-webkit-transition: all 0.1s linear;
	-moz-transition: all 0.1s linear;
	transition: all 0.1s linear;
}
.panel-login input:hover,
.panel-login input:focus {
	outline:none;
	-webkit-box-shadow: none;
	-moz-box-shadow: none;
	box-shadow: none;
	border-color: #ccc;
}
.btn-login {
	background-color: #6B06DD;
	outline: none;
	color: #fff;
	font-size: 14px;
	height: auto;
	font-weight: normal;
	padding: 14px 0;
	text-transform: uppercase;
	border-color: #59B2E6;
}
.btn-login:hover,
.btn-login:focus {
	color: #fff;
	background-color: #7C0BFB;
	border-color: #53A3CD;
}
.forgot-password {
	text-decoration: underline;
	color: #888;
}
.forgot-password:hover,
.forgot-password:focus {
	text-decoration: underline;
	color: #666;
}

.btn-register {
	background-color: #1CB94E;
	outline: none;
	color: #fff;
	font-size: 14px;
	height: auto;
	font-weight: normal;
	padding: 14px 0;
	text-transform: uppercase;
	border-color: #1CB94A;
}
.btn-register:hover,
.btn-register:focus {
	color: #fff;
	background-color: #1CA347;
	border-color: #1CA347;
}

#logo{
	position: absolute;
	top: 23%;
	right: 25px;
}

.totype{
	text-align: left;
	background-color: white;
	border: 10px;
	border-color: black;
	border-radius: 10px;
	margin: 1px;
	box-shadow: 1px 1px 20px #a6ff84;
	opacity: 0; 
	transition: .3s ease all; 
	position: absolute; 
	top: -42px; 
	transform: translateY(10px);
	/*left: 20%;*/
	right: 4%;
}

.totype::after{
	content: "";
	display: inline-block;
	border-left: 11px solid transparent ;
	border-right: 11px solid transparent;
	border-top: 11px solid white;
	position: absolute;
	bottom: -10px;
	right: calc(2%);
}

.totype.acti{
	opacity: 1;
	transform: translateY(5px);
}

.img-login{
	width: 100%; 
	height: 100%;
}

.text-mensaje-login{
	font-size: 10px;
}
.panel-heading {
    padding: 10px 15px;
    border-bottom: 1px solid transparent;
    border-top-left-radius: 3px;
    border-top-right-radius: 3px;
}
.col-xs-6 {
    width: 50%;
}
.col-sm-offset-3 {
    margin-left: 25%;
}
.logo-src {
    height: 67px;
    width: 156px;
	background: url(../public/assets/images/logo-inverse.png);
	
}
.p-5 {
    padding: 2rem !important;
}
</style>
    	<div class="row" style="width: auto">
			<div class="col-12 col-ms-12 col-md-12 col-lg-12 col-md-offset-3">
				<div class="panel panel-login">

					<div class="panel-heading">
						<div class="row">
							<div class="col-xs-6">
								<a href="javascript:;" class="active" id="login-form-link">Iniciar sesión</a>
							</div>
							<div class="col-xs-6">
								<a href="javascript:;" id="register-form-link">Regístrate ahora</a>
							</div>
	
						</div>
						<hr>
					</div>
					<div class="panel-body p-5" >
						<div class="row">
							<div class="col-lg-12">
								<form id="frm-cliente-login" method="post" role="form" style="display: block;">
									<div class="col-12 col-sm-12 col-md-12 p-2" >
										<center>
											<!-- <label><strong style="font-size: 17px;">Ya estoy registrado</strong></label><br>
										 -->
										 <div class="logo-src"></div>
											<h6>Inicia sesión para continuar con la compra</h6>
										</center>
										<br>
									</div>
									<div type="">
										<figcaption>
											<a id="logo"><i class="fas fa-shield-alt"></i></a>
											<!-- <div class="row col-8 col-ms-8 col-md-9 col-lg-10 p-1 totype" id="totype">
												<div class="col-5 col-ms-5 col-md-5 col-lg-5 p-0">
													<img class="m-0 img-login" src="./assets/images/seguridad.jpg">
												</div>
												<div class="col-7 col-ms-7 col-md-7 col-lg-7 m-0 p-0">
													<h5 style="color:#9d1cff;"><strong>Atención !!</strong></h5>
													<h6 class="text-mensaje-login">Si es la primera vez que inicia sesión en su cuenta, su contraseña es el número de su<strong> DNI</strong>.</h6>
													<h6 class="text-mensaje-login">Por seguridad cambie la contraseña.</h6>
												</div>
											</div> -->
										</figcaption>
									</div>
									<div class="form-group">
										<i class="fa fa-user"></i>
										<label style="padding-left: 5px;">DNI</label>
										<input type="text" patron="dni,requerido" name="username" id="username" tabindex="1" class="form-control" placeholder="Ingresa tu dni" value="">
									</div>
									<div class="form-group">
											<i class="fa fa-lock"></i>
											<label style="padding-left: 5px;">Contraseña</label><br>
											<input type="password" patron="requerido" name="password" id="password"  tabindex="2" class="form-control" placeholder="Ingresa tu contraseña" >
									</div>
									<!-- <div class="form-group">
										<div style="text-align: right; padding-top: 5px;">
											<input type="checkbox" tabindex="3" class=""  name="remember" id="remember">
											<a for="remenber" >Recordarme</a>
										</div>
									</div> -->
									<div class="form-group">
										<div class="row">
											<div class="col-sm-6 col-sm-offset-3">
												<button type="submit" redir="<?=isset($redirect)? $redirect:''?>" name="login-submit" id="btn-login-cliente" tabindex="4" class="form-control btn btn-success"><!--<i class="fas fa-sign-in-alt"></i>&nbsp;&nbsp;-->Iniciar sesión</button>
											</div>
										</div>
										<br>
										<div class="row">
											<div id="divbtncerrar" class="col-sm-6 col-sm-offset-3">
											</div>
										</div>
									</div>
									<!-- <div class="form-group">
										<div class="row">
											<div class="col-lg-12">
												<div class="text-center">
													<a href="javascript:;" tabindex="5" class="forgot-password">¿Has olvidado tu contraseña?</a>
												</div>
											</div>
										</div>
									</div> -->
								</form>
								<form id="frm-cliente-registro"  style="display: none;">
									<div class="col-12 col-sm-12 col-md-12 p-2" style="text-align: center;">
											<center>
												<div class="logo-src"></div>
												<!-- <label><strong style="font-size: 17px;">¿No estás registrado?</strong></label><br> -->
												<h6>Regístrate para continuar con la compra.</h6>
											</center>
										<br>
									</div>
									<div class="form-group">
										<i class="fas fa-address-card"></i>
										<label style="padding-left: 5px;">Dni</label>
										<input type="text" name="userdni" id="userdni" patron="dni,requerido" tabindex="2" class="form-control" placeholder="Ingresa tu DNI" >
									</div>
									<div class="form-group">
										<i class="fa fa-user"></i>
										<label style="padding-left: 5px;">Nombre</label>
										<input type="text" name="username_registro"  id="username_registro" patron="requerido" tabindex="1" class="form-control" placeholder="Ingresa tu nombre" value="" >
									</div>
									<div class="form-group">
										<i class="fa fa-user"></i>
										<label style="padding-left: 5px;">Apellido Paterno</label>
										<input type="text" name="userapellidopat" id="userapellidopat"  tabindex="1" patron="requerido" class="form-control" placeholder="Ingresa tu Apellido" value="" >
									</div>
									<div class="form-group">
										<i class="fa fa-user"></i>
										<label style="padding-left: 5px;">Apellido Materno</label>
										<input type="text" name="userapellidomat" id="userapellidomat"  tabindex="1" patron="requerido" class="form-control" placeholder="Ingresa tu Apellido" value="" >
									</div>
									<div class="form-group">
										<i class="fas fa-phone"></i>
										<label style="padding-left: 5px;">Telefono Móvil</label>
										<input type="text" name="usertelefono" id="usertelefono" patron="requerido,celular" tabindex="2" class="form-control" placeholder="Ingresa tu Telefono" >
									</div>
									<div class="form-group">
										<i class="fas fa-envelope"></i>
										<label style="padding-left: 5px;">Email</label>
										<input type="email" name="useremail" id="useremail" tabindex="3" patron="requerido,email"class="form-control" placeholder="Ingresa tu email" >
                                    </div>
									<div class="form-group">
										<i class="fas fa-envelope-open-text"></i>
										<label style="padding-left: 5px;">Confirma tu email</label>
										<input type="email" name="useremail2" id="useremail2" tabindex="3" patron="requerido,email" class="form-control" placeholder="Confirma tu email" >
                                    </div>
									<div class="form-group text-center">
										<h6 for="terminos_condiciones"><input type="checkbox" tabindex="4" class="" name="terminos_condiciones" id="terminos_condiciones_">  Acepto los<a href="javascript:;" id="terminos_condiciones" url='<?=base_url()?>'> términos y Condiciones</a></h6>
                                    </div>
                                    <div class="form-group text-center">
										
                                        <h6 for="fines_adicionales"><input type="checkbox" tabindex="4" class="" name="fines_adicionales" id="fines_adicionales_">  Acepto el uso de mi información para <a href="javascript:;" id="fines_adicionales" target="_blank" url="<?=base_url()?>" >fines adicionales</a></h6>
									</div>
									<div class="form-group">
										<div class="row">
											<div class="col-sm-6 col-sm-offset-3">
												<input type="submit" name="register-submit" id="btn-registrar-cliente" tabindex="4" class="form-control btn btn-success" value="Crear cuenta">
											</div>
										</div>
										<br>
										<div class="row">
											<div id="divbtncerrar2" class="col-sm-6 col-sm-offset-3">
											</div>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
