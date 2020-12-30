var Modulo = {

	//Cuota Venta
	menuMetodoPago: 'metodopago',
	idFormMenuMetodoPago: 'menuMetodoPago',
	idFormNewMetodoPago: 'newMetodoPago',
	idFormUpdateMetodoPago: 'updateMetodoPago',
	funcionGetTablaMetodoPago: 'getTablaMetodoPago',
	funcionGetFormNewMetodoPago: 'getFormNewMetodoPago',
	funcionGetFormUpdateMetodoPago: 'getFormUpdateMetodoPago',
	funcionRegistrarMetodoPago: 'registrarMetodoPago',
	functionActualizarMetodoPago: 'actualizarMetodoPago',

	idContent: 'contentMetodoPago',
	url: 'Metodopago/',

	handsonTableObject: '',
	handsonTableData: '',
	handsonTableData2:'',
	
	load: function () {

		$(document).ready(function (e) {
			Gestores.moduloActivo = 'MetodoPago';
			Gestores.urlActivo = Modulo.url;
			Gestores.idContentActivo = Modulo.idContent;
			$(".nav-tabs > li[class*='active']").click();
		});

		$(".nav-tabs > li").click(function (e) {
			e.preventDefault();

			var tabSeleccionado = $(this).data('menu');

	         if (tabSeleccionado == 'metodopago') {
				Gestores.menuActivo = Modulo.menuMetodoPago;
				Gestores.idFormMenuActivo = Modulo.idFormMenuMetodoPago;
				Gestores.idFormNewActivo = Modulo.idFormNewMetodoPago;
				Gestores.idFormUpdateActivo = Modulo.idFormUpdateMetodoPago;
				Gestores.getTablaActivo = Modulo.funcionGetTablaMetodoPago;
				Gestores.getFormNewActivo = Modulo.funcionGetFormNewMetodoPago;
				Gestores.getFormUpdateActivo = Modulo.funcionGetFormUpdateMetodoPago;
				Gestores.funcionRegistrarActivo = Modulo.funcionRegistrarMetodoPago;
				Gestores.funcionActualizarActivo = Modulo.functionActualizarMetodoPago;
			}
			
			$("#" + Gestores.idFormMenuActivo + " .btnConsultar").click();
		});
	},

}
Modulo.load();