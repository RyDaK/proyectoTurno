<div class="my-container">
		<div class="row">
			<div class="col-md-1"></div>
			<div class="col-md-10">
				<form class="form" role="form" id="form-reset-clave" method="post">

					<label for="nuevaClave" >Ingrese su nueva contraseña.</label>
					<div class="pg-input">
						<div class="input-group mb-3">
							<div class="input-group-prepend">
								<div class="input-group-text" >
								<li class="fa fa-eye" id="nuevaClave_view"></li>
								</div>
							</div>
							<input type="password" class="form-control" id="nuevaClave" name="nuevaClave" placeholder="Ingrese su nueva contraseña" patron="requerido">
						</div>
					</div>
				

					<label for="nuevaClave2">Repita su nueva contraseña.</label>
					<div class="pg-input">
						<div class="input-group mb-3">
							<div class="input-group-prepend">
								<div class="input-group-text" >
								<li class="fa fa-eye" id="nuevaClave2_view"></li>
								</div>
							</div>
								<input type="password" class="form-control" id="nuevaClave2" name="nuevaClave2" placeholder="Repita la nueva contraseña" patron="requerido">
						</div>
					</div>
				</form>
			</div>

			<div class="col-md-4"></div>
		</div>
    </div>
    <script>


const nuevaClave_view = document.querySelector('#nuevaClave_view');
const nuevaClave_pwd = document.querySelector('#nuevaClave');
nuevaClave_view.addEventListener('click', function (e) {
    // toggle the type attribute
    const type = nuevaClave_pwd.getAttribute('type') === 'password' ? 'text' : 'password';
    nuevaClave_pwd.setAttribute('type', type);
    // toggle the eye slash icon
    this.classList.toggle('fa-eye-slash');
});

const nuevaClave2_view = document.querySelector('#nuevaClave2_view');
const nuevaClave2_pwd = document.querySelector('#nuevaClave2');
nuevaClave2_view.addEventListener('click', function (e) {
    // toggle the type attribute
    const type = nuevaClave2_pwd.getAttribute('type') === 'password' ? 'text' : 'password';
    nuevaClave2_pwd.setAttribute('type', type);
    // toggle the eye slash icon
    this.classList.toggle('fa-eye-slash');
});
</script>
