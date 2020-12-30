
var Cliente={

	url: "cliente/",
	despacho: '',
	pago: '',
	cod_local: '',
	cant_ped: '',
	op_active: 'cliente',
	comercio_activo:0,

	navegacion_estado: 0,
	navegacion_anterior_estado: 0,
	id_navegacion : 0,
	cerrar_modales: function($id){
		for (var i=0; i<=$id; i++) {
			Fn.showModal({ id:i,show:false })
		}

	},
	cambiar_clave_usuario: function(){
		var data={'nuevaClave':$('#nuevaClave').val(),'nuevaClave2':$("#nuevaClave2").val()};
		var jsonString={'data':JSON.stringify(data)};
		var url="cliente/cambiar_clave_usuario";
		var config={ url:url,data:jsonString };

		if(data.nuevaClave == ""){
			data.html = "Debe Ingresar una clave";
			++modalId;
			var fn1='Fn.showModal({ id:'+modalId+',show:false });';
			var btn=new Array();
			btn[0]={title:'Aceptar',fn:fn1};
			Fn.showModal({ id:modalId,show:true,title:'Cambiar Clave',content:data.html,btn:btn, large: false });
			return false;
		}
		if(data.nuevaClave2 == ""){
			data.html = "Debe Ingresar una clave";
			++modalId;
			var fn1='Fn.showModal({ id:'+modalId+',show:false });';
			var btn=new Array();
			btn[0]={title:'Aceptar',fn:fn1};
			Fn.showModal({ id:modalId,show:true,title:'Cambiar Clave',content:data.html,btn:btn, large: false });
			return false;
		}
		if(data.nuevaClave2 != data.nuevaClave){
			data.html = "Las claves no coinciden";
			++modalId;
			var fn1='Fn.showModal({ id:'+modalId+',show:false });';
			var btn=new Array();
			btn[0]={title:'Aceptar',fn:fn1};
			Fn.showModal({ id:modalId,show:true,title:'Cambiar Clave',content:data.html,btn:btn, large: false });
			return false;
		}
		if(data.nuevaClave.length < 8){
			data.html = "La clave debe ser de al menos 8 caracteres";
			++modalId;
			var fn1='Fn.showModal({ id:'+modalId+',show:false });';
			var btn=new Array();
			btn[0]={title:'Aceptar',fn:fn1};
			Fn.showModal({ id:modalId,show:true,title:'Cambiar Clave',content:data.html,btn:btn, large: false });
			return false;
		}
		$.when( Fn.ajax(config) ).then(function(a){
			// Pedidos.enproceso = 1;
			if (a.result != 2) {
				++modalId;
					if(a.result == 1){
						var fn1='Fn.showModal({ id:'+modalId+',show:false });Cliente.cerrar_modales("'+modalId+'")';
					}else{
						var fn1='Fn.showModal({ id:'+modalId+',show:false })';

					}

				var btn=new Array();
				btn[0]={title:'Aceptar',fn:fn1};
				Fn.showModal({ id:modalId,show:true,title:'Cambiar Clave',content:a.data.message,btn:btn, large: false });
			}
		});


	},
	
	logOut_cliente: function(url=''){
		//var url=$("#a-logout").attr("page");
		if(url == ''){
			url = "cliente/logout_cliente"
		}
		$.when( Fn.ajax({ url:url,data:{} }) ).then(function(a){
			console.log(a);
			//if(a.result==1){
				Fn.loadPage(a.url);
			//}
		});
	},
	showModal: function (config){
		var modal='';
		if( config.show ){
			var modal_num=$("body .modal").length;
			modal+="<div id='modal-page-"+config.id+"' class='modal fade' tabindex='-1' role='dialog' data-backdrop='static' data-keyboard='false'>  ";
				modal+="<div class='modal-dialog "+(!$.isNull(config.large)? 'modal-lg' :'')+"' "+(!$.isNull(config.width)?"style='width:"+config.width+"'":'')+">";
					modal+="<div class='modal-content'>";
						modal+="<div class='modal-body' style='width: auto'>  ";
							if( !$.isNull(config.content) ) modal+="<p>"+config.content+"</p>";
							else if( !$.isNull(config.frm) ) modal+=config.frm;
							modal+="</div>";
							if( !$.isNull(config.btn) ){
								for(var i=0;i<config.btn.length;i++){
									var css = 'btn-success';
									var css2 = 'btn-danger'
									if(i==0){ css = 'btn-success'; }
									boton ="<button style='float:right' type='button' class='form-control btn "+css+"' onclick='"+config.btn[i].fn+"' >"+config.btn[i].title+"</button>";
									
								}
							}
					modal+="</div>";
				modal+="</div>";
			modal+="</div>";
			$("body").append(modal);
			$("#lk-modal").attr("data-target",'#modal-page-'+config.id);
			$("#lk-modal").click();	
			$('#divbtncerrar').html(boton);
			$('#divbtncerrar2').html(boton);
		}
		else{
			//$('#modal-page-'+config.id).modal('hide')
			$('#modal-page-'+config.id).next().remove();
			$('#modal-page-'+config.id).remove();
			if( $('.modal:visible').length==0 ) $("body").removeClass('modal-open');
			$("body").css("padding-right","");
			$("#lk-modal").attr("data-target","");
		}
	},
	confirmar_eliminar_articulo: function($id_det_ped){
			++modalId;
			var fn='Fn.showModal({ id:'+modalId+',show:false });';
			var fn1='Fn.showModal({ id:'+modalId+',show:false });Cliente.eliminar_articulo('+$id_det_ped+');';
			let $mensaje_err = '<i class="fas fa-info-circle"></i>Esta seguro que desa eliminar este articulo?';
			var btn=new Array();
			btn[0]={title:'Cancelar',fn:fn};
			btn[1]={title:'Eliminar',fn:fn1};
			Fn.showModal({ id:modalId,show:true,title:'Pedidos',content:$mensaje_err,btn:btn });
	},

	eliminar_articulo: function($id_det_ped){
		var data= {'id_det_ped':$id_det_ped};
		var jsonString={'data':JSON.stringify(data)};
		var url="cliente/eliminar_articulo_carrito";
		var config={ url:url,data:jsonString };

		$.when( Fn.ajax(config) ).then(function(a){
			// Pedidos.enproceso = 1;
			if (a.result == 1) {
				Cliente.listado_pedidos_cliente();
			}
		});
	},

	obtener_comercio_local: function(){
		e.preventDefault();
		var datos={'cod_comercio' :  $(this).attr('id_comercio'),
					'nombre_comercio' : $(this).attr('nombre_comercio'),
					'tipo_comercio' :  $(this).attr('tipo_comercio'),
					'cod_tipo_comercio' : $(this).attr('cod_tipo_comercio')};

		var url= Cliente.url+'obtener_comercios_afiliados';
		
		var id_comercio = $(this).attr('value')
		if($(this).attr('id_comercio') != ''){
		$.ajax({
			data:datos,
			url: "../cliente/obtener_comercio_local",
			type:'POST',
			dataType: 'json',
			success : function(a){
				
				$('#divllenar').html(a.data.html1);
				$('#divTitle').html(a.data.html2);
				
			},
			error:function(){
				alert('error');
			}
		});
		
	}
	},

	enviar_pedido_cliente_despacho: function(){
	
		let $validar_sess = $('#btn-pasar-a-despacho').attr('validar_sess');
		let direccion_envio = 	$('#id_via_local').val() + ' ' +
								$('#via_local').val() + ' '+
								$('#id_zona_local').val()+ ' '+
								$('#zona_local').val()+ ' '+
								$('#km_local').val()+ ' '+
								$('#mza_local').val()+ ' '+
								$('#dep_local').val()+ ' '+
								$('#int_local').val()+ ' '+
								$('#lote_local').val()+ ' '+
								$('#num_local').val()+ ' ';
		let fecha_pedido = '';
		var distrito_envio = '';
		var costo_envio = '';

		$(".recojo-envio").each(function( index ) {
			if($(this).is(':checked')){
				Cliente.despacho = $(this).attr('value');
			}
		});

		if($('#txtfechapedido').val() != '' ){
			fecha_pedido = $('#txtfechapedido').val();
		}
		if($('#txtdireccion_envio').val() != ''){
			direccion_envio =direccion_envio;
		}
		if($('#sl_mi_distrito').val() != ''){
			distrito_envio =$('#sl_mi_distrito').val();
		}

		if(Cliente.despacho == 2){
			$('#txtcosto_envio').val('');
		}

		if($('#txtcosto_envio').val() != ''){
			costo_envio =$('#txtcosto_envio').val();
		}





		if($('input[name ="recojo-envio"]').is(':checked') && $('input[name ="metodo-pago"]').is(':checked') ){
				var val_dir = true;
				var esVisible = $("#direccion_envio").is(":visible");
				if(esVisible){
					if($('#txtdireccion_envio').val() != '' && $('#sl_mi_distrito').val() != '' ){
						val_dir = true;
					} else{
						val_dir = false;
					}
				}
				if(val_dir){
					if($validar_sess == 0){
						Cliente.cargar_form_login_cliente('Cliente.listado_pedidos_cliente()');
					}else{

						var data={'metodo_despacho':Cliente.despacho,'metodo_pago':Cliente.pago,'direccion_envio':direccion_envio,'fecha_pedido':fecha_pedido,'distrito_envio':distrito_envio,'costo_envio':costo_envio};
							
						// console.log(data); return false;
						// data=Fn.formSerializeObject("frm_despacho_pedido");
						var jsonString={ 'data':JSON.stringify(data) };
						var url="cliente/pasar_pedido_cliente_despacho";
						var config={ url:url,data:jsonString };
						$.when( Fn.ajax(config) ).then(function(b){
							if( b.result!=2 ){
								++modalId;

								var fn='Fn.showModal({ id:'+modalId+',show:false });Fn.loadPage("'+'cliente'+'");';

								var btn=new Array();
								btn[0]={title:'Aceptar',fn:fn};
								Fn.showModal({ id:modalId,show:true,title:'DESPACHO',content:b.data.content,btn:btn });
							}
						});
					} 
				}else {
					++modalId;

					var fn='Fn.showModal({ id:'+modalId+',show:false });';
					let $mensaje_err = '<i class="fas fa-info-circle"></i> Debe especificar un lugar de envio.';
					var btn=new Array();
					btn[0]={title:'Aceptar',fn:fn};
					Fn.showModal({ id:modalId,show:true,title:'Campos Incompletos',content:$mensaje_err,btn:btn });
				}
		} else{
			++modalId;

			var fn='Fn.showModal({ id:'+modalId+',show:false });';
			let $mensaje_err = '<i class="fas fa-info-circle"></i> Asegúrese de seleccionar la forma de entrega y el medio de pago.';
			var btn=new Array();
			btn[0]={title:'Aceptar',fn:fn};
			Fn.showModal({ id:modalId,show:true,title:'Campos Incompletos',content:$mensaje_err,btn:btn });
		}
	},



	cargar_form_login_cliente :function($redirect=''){
			var data= {};
				data.redirect = $redirect;
	
			var jsonString={'data':JSON.stringify(data)};
				var url="cliente/cargar_login_cliente";
				var config={ url:url,data:jsonString };

				$.when( Fn.ajax(config) ).then(function(a){
					// Pedidos.enproceso = 1;
					if (a.result == 1) {
						++modalId;
						// $("#miModal").show();
						var fn1='Fn.showModal({ id:'+modalId+',show:false });';
						var btn=new Array();
							btn[0]={title:'Cerrar',fn:fn1};
						Cliente.showModal({ id:modalId,show:true,title:'INICIO DE SESION',content:a.data.html,btn:btn, width: 'auto' ,large:true});
						
					}
				});
	},

	confirmar_pedido_cliente :function(){
		var data = {};
		let $i = 0;
			$(".cantidad_platos").each(function( index ) {
				let $mensaje_err = '<i class="fas fa-info-circle"></i>Uno de los datos introducidos no es correcto';
				
				console.log( data  );
				if($('#cantidad_platos'+index).val() <= 0||$('#cantidad_platos'+index).val() ==''){

					++modalId;
					// $("#miModal").show();
					var fn1='Fn.showModal({ id:'+modalId+',show:false });';
					var btn=new Array();
						btn[0]={title:'Aceptar',fn:fn1};
					Fn.showModal({ id:modalId,show:true,title:'ERROR',content:$mensaje_err,btn:btn, large: true });
					$('#cantidad_platos'+index).css('border-color','red');
					return false;

				}else if($.isNumeric($('#cantidad_platos'+index).val()) && 
				$('#cantidad_platos'+index).val() !='' && 
				$('#cantidad_platos'+index ).val() >0){

				data= {'cod_ped_env_det':$('#cantidad_platos'+index).attr('ped_cod_env_det'),
					   'cantidad_confirmada' : $('#cantidad_platos'+index).val(),
					   'observaciones' : ($('#observaciones'+index).val()),
						'indice': index,
						'precio_cu': ($('#precio_plato'+index).val()),
						'cod_ped':($('#btn-confirmar-pedido-cliente').attr('ped_cod'))};

					   var jsonString={'data':JSON.stringify(data)};
					   var url="cliente/cargar_form_pedido_confirmado";
					   var config={ url:url,data:jsonString };
					   let title = '<h3><a>Despacho De Pedidos </a><h3>';
		   
					   $.when( Fn.ajax(config) ).then(function(a){
						   // Pedidos.enproceso = 1;
						   if (a.result == 1) {
							   ++modalId;
							   $("#miModal").show();
								// if($i == 0 ){
								// 	$('#divllenar').empty();
								// 	$i = 999;
								// }
								$('#divllenar').html(a.data.html1);
							   	$('#divTitle').html(title);
							   
						   }
					   });
				}else{
					++modalId;
					// $("#miModal").show();
					var fn1='Fn.showModal({ id:'+modalId+',show:false });';
					var btn=new Array();
						btn[0]={title:'Aceptar',fn:fn1};
					Fn.showModal({ id:modalId,show:true,title:'asdasd',content:$mensaje_err,btn:btn, large: true });
					$('#cantidad_platos'+index).css('border-color','red');
					alert('ref: ' + $('#cantidad_platos'+index).val());
					return false;
				}
				
			});
			console.log(data);
			
			
		
	},

	listado_pedidos_cliente :function(){
				// let sesion_ini = $('.validar_sess').attr('sess');
				let sesion_ini = 1;
				if(sesion_ini == 0){
					Cliente.cargar_form_login_cliente();
				}else if(sesion_ini == 1){
					let title = '<h3><a>Detalle de la Compra</a><h3>';
					var data={};
					var jsonString={'data':JSON.stringify(data)};
					var url="cliente/cliente_listar_pedidos";
					var config={ url:url,data:jsonString };
		
					$.when( Fn.ajax(config) ).then(function(a){
						// Pedidos.enproceso = 1;
						if (a.result == 1) {
							// $('#cantidad-notificaciones').html(a.data.notificaciones);
							$('#divllenar').html(a.data.html1);
							$('#divTitle').html(title);

						}
					});
	
				}
		Cliente.op_active = "listado_pedidos_cliente";
	},

	load: function(){

		// if(Cliente.navegacion_estado == 0){
		// 	$('#btn-back').attr('disabled',true);
		// }

		$(document).on('click','#btn-back_2',function(e){
			e.preventDefault();
			

			var url= Cliente.url+'obtener_comercios_afiliados';
			
			var id_comercio = $(this).attr('value')
			if($(this).attr('id_comercio') != ''){
			$.ajax({
				data:Cliente.navegacion_estado,
				url: "../cliente/obtener_comercio_local",
				type:'POST',
				// beforeSend: function(){ Fn.showLoading(true) },
				dataType: 'json',
				success : function(a){
					
					$('#divllenar').html(a.data.html1);
					$('#divTitle').html(a.data.html2);
					Cliente.navegacion_anterior_estado = Cliente.navegacion_estado;
					// Cliente.navegacion_estado = 0;
				},
				error:function(){
					alert('error');
				}
			});
			}
		});
		
		$(document).on('click','#redirent_comercio',function(e){ 
			e.preventDefault();
			var datos={'cod_comercio' :  $(this).attr('id_comercio'),
						'nombre_comercio' : $(this).attr('nombre_comercio'),
						'tipo_comercio' :  $(this).attr('tipo_comercio'),
						'cod_tipo_comercio' : $(this).attr('cod_tipo_comercio')};

			var url= Cliente.url+'obtener_comercios_afiliados';
			
			var id_comercio = $(this).attr('value')
			if($(this).attr('id_comercio') != ''){
			$.ajax({
				data:datos,
				url: "../cliente/obtener_comercio_local",
				type:'POST',
				beforeSend: function(){ Fn.showLoading(true) },
				dataType: 'json',
				success : function(a){
					Fn.showLoading(false);
					$('#divllenar').html(a.data.html1);
					$('#divTitle').html(a.data.html2);
					
					
				},
				error:function(){
					Fn.showLoading(false);
					alert('error');
				}
			});
			}
		});
		// $('#redirent_comercio').click();

			
			$(document).on('click','#btn-send',function(e){
			var cod_estado_ped = Number($(this).attr('id_ped_cli'))+ 1;
			// alert(cod_estado_ped);return false;
			var pedidos = [];
			$('#tb-list').DataTable().rows().every(function (rowIdx, tableLoop, rowLoop) {
				var data = this.node();
				//var checked = $(data).find('input[type="checkbox"]').prop('checked');
				if($(data).hasClass( "selected" )){
					pedidos.push($(data).attr("data-id"));
				}
				
			});
			
			console.log(data);
			if(pedidos.length > 0){
				var data={pedidos:pedidos,cod_estado_ped:cod_estado_ped};
				var jsonString={ 'data':JSON.stringify(data), datetime: Global.dateTime };
				var url="Cliente/ver_mis_pedidos";
				var config={ url:url,data:jsonString };

				$.when( Fn.ajax(config) ).then(function(a){
					// PedidosOP.enproceso = 0;
					if (a.result == 1) {
						++modalId;
						$('#divllenar').html(a.data.html1);
						// if(a.status==1){
						// 	var fn='Fn.showModal({ id:'+modalId+',show:false });$("#btn-refresh").click();';//
						// }
						// else var fn='Fn.showModal({ id:'+modalId+',show:false });';

						// var btn=new Array();
						// btn[0]={title:'Aceptar',fn:fn};
						// Fn.showModal({ id:modalId,show:true,title:'Reporte',content:a.data.html1,btn:btn, large:true });
					}
				});
			} else {
				++modalId;
				var fn='Fn.showModal({ id:'+modalId+',show:false });';
				var btn=new Array();
				btn[0]={title:'Aceptar',fn:fn};
				Fn.showModal({ id:modalId,show:true,title:"Pedidos",content:'<i class="fa fa-info-circle" ></i> Debe seleccionar un pedido para continuar.',btn:btn });
			}
		});
		//-----------------------------------------
		//   Cargar Modal (Libro de Reclamaciones)
		//-----------------------------------------
		$("#btn_libro_reclamaciones").on("click",function(e){
			var data={'cod_cliente_usuario': $(this).attr("cod_cliente_usuario"),
					"otra":"valor otra"};
			var jsonString={'data':JSON.stringify(data)};
			var url="cliente/mostrar_libro_reclamaciones";
			var config={ url:url,data:jsonString };

			$.when( Fn.ajax(config) ).then(function(a){

				// Pedidos.enproceso = 1;
				if (a.result == 1) {
					++modalId;
					var fn1='Fn.showModal({ id:'+modalId+',show:false });';
					var fn2='Pedidos.meavisan("'+modalId+'");';
					var btn=new Array();
						btn[0]={title:'Cancelar',fn:fn1};
						btn[1]={title:'Guardar',fn:fn2};
					Fn.showModal({ id:modalId,show:true,title:'Libro de Reclamaciones',content:a.data.html,btn:btn, large: true });
				}
			});
			// alert('Aqui deberia aparecer el libroXD');
		});

		$(document).on('click','#terminos_condiciones',function(e){
			window.open($(this).attr('url')+ 'files/documentos/TERMINOS_Y_CONDICIONES_DEL_USO_DE_LA_PLATAFORMA_DE_SERVICIOS_TURNO.pdf', '_blank');
		});

		$(document).on('click','#fines_adicionales',function(e){
			window.open($(this).attr('url')+ 'files/documentos/POLITICAS_DE_PRIVACIDAD_TURNO.pdf', '_blank');
		});

		$(document).on('click','#btn-refresh',function(e){
			e.preventDefault();
	
			var data={};
			var jsonString={ 'data':JSON.stringify(data) };
			var url="cliente/listado_mis_pedidos";
			var config={ url:url,data:jsonString };

			$.when( Fn.ajax(config) ).then(function(a){
				if (a.result == 1) {
					$('#divllenar').html(a.data.html);
					
					$('#tb-list').DataTable({
						columnDefs: [ {
							orderable: true,
							className: 'select-checkbox',
							targets:   0
						} ],
						select: {
							style:    'multi',
							selector: 'td:first-child'
						},
						//order: [[ 1, 'asc' ]],
						buttons: []
					});
					//
					// PedidosOP.validar_pedidos();
				}
			});

				var $this = $(this);
				$this.val('Please wait..');
				$this.attr('disabled', true);
				setTimeout(function() { 
					$this.attr('disabled', false);
					$this.val('Actualizar');
				}, 4000);
		});
	    $(document).ready(function(e){
	    	//-----------------------------------------
			//    Mostrar DatePicker
			//-----------------------------------------
			$('.fj-date').datepicker({
			    format: "dd/mm/yy",
			    keyboardNavigation: false,
			    forceParse: false,
			    todayHighlight: true
			});
 			//-----------------------------------------
			//    Listar Provincias
			//-----------------------------------------
	        $('#departamentos').on('change',function(){
	        	var cod_departamento= $('#departamentos').val();
	            if (cod_departamento != '') 
	            {
	            	$.ajax({
		            	data:{'cod_departamento':cod_departamento},
		            	url:'../cliente/obtener_provincias',
						type:'POST',
						// beforeSend: function(){ Fn.showLoading(true) },
		            	dataType: 'json',
		            	success : function(data){
							Fn.showLoading( false );

							$('#divllenar').html(data.data.html1);
		            		$('#provincias').html(data.html);
		            		$('#provincias').prop('disabled', false);
							$('#distritos').prop('disabled', true);
							$('#distritos').html('<option>Distrito</option>');
	            			// $('#provincias').selectpicker('refresh');
							// $('#distritos').selectpicker('refresh');
							
		            	},
		            	error:function(){
		            		console.log('error');
							$.when( Fn.showLoading(false) ).then(function(){
							var id=++modalId;
							var btn=new Array();
							btn[0]={title:'Aceptar',fn:'Fn.showModal({ id:'+id+',show:false });'};
							Fn.showModal({ id:id,show:true,title:'ERROR',content:'Ocurrio un error inesperado en el sistema.',btn:btn });
							a.resolve( result );
				})
		            	}
		            });
	            }else{
	            	$('#provincias').prop('disabled', true);
	            	$('#distritos').prop('disabled', true);
	            	// $('#provincias').selectpicker('refresh');
	            	// $('#distrito').selectpicker('refresh');
	            }
			});
			
	        $('#distrito_pdv').on('change',function(){
				var distrito_pdv= $('#distrito_pdv').val();
				
				
				if (distrito_pdv != '') {
					var data={'distrito_pdv':distrito_pdv,'comercio_activo':Cliente.comercio_activo};
					var jsonString={'data':JSON.stringify(data)};
					var url="cliente/filtrar_por_distrito_pdv";
					var config={ url:url,data:jsonString };

					$.when( Fn.ajax(config) ).then(function(a){
						
						// Pedidos.enproceso = 1;
						if (a.result == 1) {
							// ++modalId;
							$('#divllenar').html(a.data.html1);
							// var fn1='Fn.showModal({ id:'+modalId+',show:false });';
							// var fn2='Pedidos.meavisan("'+modalId+'");';
							// var btn=new Array();
							// 	btn[0]={title:'Cancelar',fn:fn1};
							// 	btn[1]={title:'Guardar',fn:fn2};
							// Fn.showModal({ id:modalId,show:true,title:'Libro de Reclamaciones',content:a.data.html,btn:btn, large: true });
						}
					});
				}
					
	        });
	        //--------------------------------------
			//    Listar Distritos
			//--------------------------------------
	        $('#provincias').on('change',function(){
	        	var cod_provincia= $('#provincias').val();
	            if (cod_provincia != '') 
	            {
	            	$.ajax({
						data:{'cod_provincia':cod_provincia,
							  'cod_dep':$('#departamentos').val()},
		            	url:'../cliente/obtener_distritos',
						type:'POST',
						// beforeSend: function(){ Fn.showLoading(true) },
		            	dataType: 'json',
		            	success : function(a){
							Fn.showLoading( false );
							$('#divllenar').html(a.data.html1);
							$("#loaderDiv").hide();
		            		$('#distritos').html(a.html);
		            		$('#distritos').prop('disabled', false);
							// $('#distritos').selectpicker('refresh');
							
		            	},
		            	error:function(){
		            		$.when( Fn.showLoading(false) ).then(function(){
								var id=++modalId;
								var btn=new Array();
								btn[0]={title:'Aceptar',fn:'Fn.showModal({ id:'+id+',show:false });'};
								Fn.showModal({ id:id,show:true,title:'ERROR',content:'Ocurrio un error inesperado en el sistema.',btn:btn });
								a.resolve( result );
							})
		            	}
		            });
	            } else
	            {
	            	$('#distritos').prop('disabled', true);
	            	$('#distrito').selectpicker('refresh');
	            }
			});

	        $('#distritos').on('change',function(){
				var cod_distritos= $('#distritos').val();
				// alert(cod_distritos);return false;
	            if (cod_distritos != '') 
	            {
	            	$.ajax({
						data:{'cod_dist':cod_distritos,
							  'cod_dep':$('#departamentos').val(),
							  'cod_prov':$('#provincias').val()},
		            	url:'../cliente/filtrado_local_ubigeo',
		            	type:'POST',
						dataType: 'json',
						// beforeSend: function(){ Fn.showLoading(true) },
		            	success : function(a){
							Fn.showLoading( false );
							$('#divllenar').html(a.data.html1);
		            	},
		            	
		            });
	            } else
	            {
	            	$('#distritos').prop('disabled', true);
	            	$('#distrito').selectpicker('refresh');
	            }
			});
			
			
		

	    })

	   	//--------------------------------------
		//    Filtrado de comercios afiliados
		//--------------------------------------
		$(document).on('click','#li_cargar_comercios',function(e){

			e.preventDefault();
			
			var datos={'cod_comercio' :  $(this).attr('value'),
						'nombre_tipo_comercio' : $(this).attr('nombre_comercio')};
			var url= Cliente.url+'obtener_comercios_afiliados';

			var id_comercio = $(this).attr('value')
			if($(this).attr('value') != ''){
			$.ajax({
				data:datos,
				url: "../cliente/obtener_comercios_afiliados",
				type:'POST',
				dataType: 'json',
				success : function(a){
					
					console.log(datos);
					Cliente.comercio_activo = datos.cod_comercio;
					$('#divllenar').html(a.data.html1);
					$('#divTitle').html(a.data.html2);
					$('#distrito_pdv').val('');
					Cliente.navegacion_estado = datos;
					
				},
				error:function(){
					alert('error');
				}
			});
		}
		});
			//--------------------------------------
			//    Filtrado de comercios afiliados por TIPO
			//--------------------------------------
		$(document).on('click','#enlace_filtrado',function(e){
			e.preventDefault();
			
			var datos={'cod_comercio' :  $(this).attr('cod_tipo_comercio'),
						'nombre_tipo_comercio' : $(this).attr('nombre_tipo_comercio')};
			var url= Cliente.url+'obtener_comercios_afiliados';

			var id_comercio = $(this).attr('value')
			if($(this).attr('value') != ''){
			$.ajax({
				data:datos,
				url: "../cliente/obtener_comercios_afiliados",
				type:'POST',
				dataType: 'json',
				success : function(a){
					
					console.log(datos);
					
					$('#divllenar').html(a.data.html1);
					$('#divTitle').html(a.data.html2);
					
				},
				error:function(){
					alert('error');
				}
			});
		}
		});

			//--------------------------------------
			//    Filtrado de los platos por Comercio LOCAL
			//--------------------------------------
		$(document).on('click','#tarjeta_plato_comercio',function(e){
			e.preventDefault();
			var datos={'cod_comercio' :  $(this).attr('id_comercio'),
						'nombre_comercio' : $(this).attr('nombre_comercio'),
						'tipo_comercio' :  $(this).attr('tipo_comercio'),
						'cod_tipo_comercio' : $(this).attr('cod_tipo_comercio'),
						'local_comercio': $(this).attr('local_comercio'),
						'cod_local_comercio': $(this).attr('cod_local_comercio')};

			var url= Cliente.url+'obtener_comercios_afiliados';
			Cliente.navegacion_estado = datos;
			Cliente.id_navegacion = 3;
			
			var id_comercio = $(this).attr('value')
			if($(this).attr('id_comercio') != ''){
			$.ajax({
				data:datos,
				url: "../cliente/obtener_platos_comercio",
				type:'POST',
				dataType: 'json',
				success : function(a){
					
					$('#divllenar').html(a.data.html1);
					$('#divTitle').html(a.data.html2);
					
				},
				error:function(){
					alert('error');
				}
			});
		}
		});

		$(document).on('click','#tarjeta_comercio',function(e){
			e.preventDefault();
			var datos={'cod_comercio' :  $(this).attr('id_comercio'),
						'nombre_comercio' : $(this).attr('nombre_comercio'),
						'tipo_comercio' :  $(this).attr('tipo_comercio'),
						'cod_tipo_comercio' : $(this).attr('cod_tipo_comercio')};

			var url= Cliente.url+'obtener_comercios_afiliados';
			

			var id_comercio = $(this).attr('value')
			if($(this).attr('id_comercio') != ''){
			$.ajax({
				data:datos,
				url: "../cliente/obtener_comercio_local",
				type:'POST',
				// beforeSend: function(){ Fn.showLoading(true) },
				dataType: 'json',
				success : function(a){
					
					$('#divllenar').html(a.data.html1);
					$('#divTitle').html(a.data.html2);
					// console.log(Cliente.navegacion_estado);
					Cliente.navegacion_estado = datos;
					Cliente.id_navegacion = 1;
				},
				error:function(){
					alert('error');
				}
			});
			}
		});

		$(document).on('click','#btn-pedir-plato',function(e){
			// let sesion_ini = $('.validar_sess').attr('sess');
			let sesion_ini = 1;
// alert(sesion_ini); return false;
			if(sesion_ini == 0){
				Cliente.cargar_form_login_cliente();
			}else if(sesion_ini == 1){
				let validar_cant = $('#txt_cantidad_pedidos'+$(this).attr('cod_plato')).val();
				if(validar_cant != '' && $.isNumeric(validar_cant)){

					var data={'cantidad_pedidos': $('#txt_cantidad_pedidos'+$(this).attr('cod_plato')).val(),
					'cod_comercio': $(this).attr('cod_comercio'),
					'cod_plato': $(this).attr('cod_plato'),
					'cod_local_comercio': $(this).attr('cod_local_comercio')
						};
						console.log(data);
					var jsonString={'data':JSON.stringify(data)};
					var url="cliente/cliente_agregar_pedidos";
					var config={ url:url,data:jsonString };
		
					$.when( Fn.ajax(config) ).then(function(a){
						// Pedidos.enproceso = 1;
						if (a.result == 1) {
							
							$('cantidad-notificaciones').html('1');
							++modalId;
							var fn1='Fn.showModal({ id:'+modalId+',show:false });';
							var fn2='Fn.showModal({ id:'+modalId+',show:false });Cliente.listado_pedidos_cliente();';
							var btn=new Array();
							btn[0]={title:'Seguir Comprando',fn:fn1};
							btn[1]={title:'Ver Pedidos',fn:fn2};
							Fn.showModal({ id:modalId,show:true,title:'Pedidos',content:a.data.message,btn:btn, large: true });
						}
					});
			 	}else{
					++modalId;
					var fn1='Fn.showModal({ id:'+modalId+',show:false });';
					// var fn2='Fn.showModal({ id:'+modalId+',show:false });Fn.loadPage("'+a.url+'");';
					var btn=new Array();
					let simbolo = '<i class="fas fa-exclamation-circle"></i>';
					btn[0]={title:'Aceptar',fn:fn1};
					// btn[1]={title:'Ver Pedidos',fn:fn2};
					Fn.showModal({ id:modalId,show:true,title:'Pedidos',content:simbolo+' Por favor ingrese una cantidad válida.',btn:btn, large: true });
				 }

			}

		});
		
		$(document).on('click','#login-form-link',function(e){

		$("#frm-cliente-login").delay(100).fadeIn(100);
 		$("#frm-cliente-registro").fadeOut(100);
		$('#register-form-link').removeClass('active');
		$(this).addClass('active');
		e.preventDefault();
	});
		$(document).on('click','#register-form-link',function(e){
		$("#frm-cliente-registro").delay(100).fadeIn(100);
 		$("#frm-cliente-login").fadeOut(100);
		$('#login-form-link').removeClass('active');
		$(this).addClass('active');
		e.preventDefault();
	});

	$(document).on('click','#btn-iniciar-sesion-cliente',function(e){
		Cliente.cargar_form_login_cliente();
	});
	$('#btn-cambiar-clave').on('click',function(){
		 
		var data={};
		var jsonString={'data':JSON.stringify(data)};
		var url="cliente/form_cambiar_clave_usuario";
		var config={ url:url,data:jsonString };

		$.when( Fn.ajax(config) ).then(function(a){
			// Pedidos.enproceso = 1;
			if (a.result == 1) {
				++modalId;
				var fn1='Fn.showModal({ id:'+modalId+',show:false });';
				var fn2='Cliente.cambiar_clave_usuario();';
				var btn=new Array();
				btn[0]={title:'Cancelar',fn:fn1};
				btn[1]={title:'Guardar',fn:fn2};
				Fn.showModal({ id:modalId,show:true,title:'Cambiar Clave',content:a.data.html,btn:btn, large: false });
			}
		});
	});


	$(document).on('click','#btn_mis_pedidos',function(e){

		var data= {};
		var jsonString={'data':JSON.stringify(data)};
		var url="cliente/listado_mis_pedidos";
		var config={ url:url,data:jsonString };
		let title = '<h3><a> Mis Pedidos </a><h3>';
		   
					   $.when( Fn.ajax(config) ).then(function(a){
						   // Pedidos.enproceso = 1;
						   if (a.result == 1) {
							   ++modalId;
								$('#divllenar').html(a.data.html);
							   	$('#divTitle').html(title);
							   
						   }
						   $('#divllenar').html(a.data.html);
						   $('#tb-list').DataTable({
							   columnDefs: [ {
								   orderable: true,
								   className: 'select-checkbox',
								   targets:   0
							   } ],
							   select: {
								   style:    'single',
								   selector: 'td:first-child'
							   },
							   //order: [[ 1, 'asc' ]],
							   buttons: []
						   });
					   });
	});

		$(document).on('click','#btn-login-cliente',function(e){
			
			e.preventDefault();
			$.when( Fn.validateForm({ id:"frm-cliente-login" }) ).then(function(a){
				if( a===true ){
					var data={};
					data=Fn.formSerializeObject("frm-cliente-login");
					var jsonString={ 'data':JSON.stringify(data) };
					var url="cliente/acceder";
					var config={ url:url,data:jsonString };
					$.when( Fn.ajax(config) ).then(function(b){
						if( b.result!=2 ){
							++modalId;
							if($('#btn-login-cliente').attr('redir') !=''){
								console.log($('#btn-login-cliente').attr('redir'));
								$('#btn-iniciar-sesion-cliente').remove();	
								$('#div_carrito').remove();	
								let urlx = 'cliente/logout_cliente';
								$('#btn-pasar-a-despacho').attr('validar_sess',1);
								$('.widget-content-wrapper').prepend('<div class="widget-content-left"> <div class="btn-group"><a data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="p-0 btn validar_sess" sess="1"><img width="42" class="rounded-circle" src="assets/images/avatars/user_icon.png" alt=""> <i class="fa fa-angle-down ml-2 opacity-8"></i> </a><div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu dropdown-menu-right"><button type="button" tabindex="0" class="dropdown-item" disabled><i class="fa fa-unlock" ></i>&nbsp;Cambiar Contraseña</button> <div tabindex="-1" class="dropdown-divider"></div><a  href="javascript:;" onclick="Cliente.logOut_cliente();" class="dropdown-item"><i class="fa fa-close"></i>&nbsp;Cerrar Sesion</a></div></div></div><a href="javascript:;" id="#cargar_pedidos_cliente" onclick="Cliente.listado_pedidos_cliente();"><i class="fas fa-cart-arrow-down" style="font-size: 2em;" ></i></a></div>');
								var fn='Fn.showModal({ id:'+modalId+',show:false });Fn.showModal({ id:'+(modalId - 1)+',show:false });';
							}else{
								console.log('no existe');
								var fn='Fn.showModal({ id:'+modalId+',show:false });Fn.loadPage("cliente");';//
							}

							// if(b.status==1){
							// 	var fn='Fn.showModal({ id:'+modalId+',show:false });Fn.loadPage("cliente");';//
							// }
							// else var fn='Fn.showModal({ id:'+modalId+',show:false });';

							var btn=new Array();
							btn[0]={title:'Continuar',fn:fn};
							Fn.showModal({ id:modalId,show:true,title:b.msg.title,content:b.msg.content,btn:btn });
						}
					});
				}
			});
		});
		// $(document).on('change','#userdni',function(e){
		// 			var data={'dni':$(this).val()};
		// 			// data=Fn.formSerializeObject("frm-cliente-registro");
		// 			var jsonString={ 'data':JSON.stringify(data) };
		// 			var url="cliente/obtener_datos_reniec";
		// 			var config={ url:url,data:jsonString };
		// 			$.when( Fn.ajax(config) ).then(function(b){
		// 				if( b.result = 1 ){
		// 					$('#username_registro').attr("value",b.data.nombres);
		// 					$('#userapellido').attr("value",b.data.apellidos);
		// 					$('body').attr('class','modal-open');
		// 				}
		// 				if( b.result = 2 ){
		// 					$('#username_registro').attr("placeholder",b.data.nombres);
		// 					$('#userapellido').attr("placeholder",b.data.apellidos);
		// 					$('body').attr('class','modal-open');

		// 				}

		// 			});
		// });
		$(document).on('keyup','.cantidad_platos',function(e){

			let importe_todo = 0;
			let importe_cu = 0;
			$(".cantidad_platos").each(function( index ) {
				console.log( index + ": " + $( this ).val() );
				if($( this ).val() <= 0||$( this ).val() ==''){
					$(this).css('border-color','red');
				}else if($.isNumeric($(this).val()) && $( this ).val() !='' && $( this ).val() >0){
					$(this).css('border-color','blue');
					// let importe_pedido = ($('#precio_plato'+index).val() * $(this).val());
					let cantidad = ($('#cantidad_platos'+index).val());
					let precio_cu = ($('#precio_plato'+index).val());
					let precio_empaque = ($('#precio_empaque_uni'+index).val());

					importe_cu = Number(Number(cantidad*precio_cu) + Number(precio_empaque*cantidad)) ;
					console.log(importe_cu);
					importe_todo += Number(importe_cu);
					if($.isNumeric(importe_cu)){
						$('#total_pedido_det'+index).attr('value',(importe_cu).toFixed(2));
						$('#precio_empaque'+index).attr('value',Number(precio_empaque*cantidad).toFixed(2));
						// alert(importe_cu + ' ' + cantidad + ' '+ precio_cu); 
						$('#total_pedido').attr('value',(Math.round(importe_todo*100)/100).toFixed(2) );
					}
				}else{
					$(this).css('border-color','red');
				}
			});
			importe_todo = 0;
		});
		
		// $(document).on('keyup','.cantidad_platos',function(e){
		// 	$(".cantidad_platos").each(function( index ) {
		// 		console.log( index + ": " + $( this ).val() );
		// 		if($( this ).val() <= 0||$( this ).val() ==''){
		// 			$(this).css('border-color','red');
		// 		}else if($.isNumeric($(this).val()) && $( this ).val() !='' && $( this ).val() >0){
		// 			$(this).css('border-color','blue');
		// 		}else{
		// 			$(this).css('border-color','red');
		// 		}
				
		// 	});
		// });

		$(document).on('click','#btn-registrar-cliente',function(e){
			e.preventDefault();
			$.when( Fn.validateForm({ id:"frm-cliente-registro" }) ).then(function(a){
				if( a===true ){
					var data={};
					data=Fn.formSerializeObject("frm-cliente-registro");
					var jsonString={ 'data':JSON.stringify(data) };
					var url="cliente/registrar_cliente";
					var config={ url:url,data:jsonString };
					$.when( Fn.ajax(config) ).then(function(b){
						if( b.result = 1 ){
							++modalId;

							if($('#btn-login-cliente').attr('redir') !='' && b.status ==1){
								console.log($('#btn-login-cliente').attr('redir'));
								$('#btn-iniciar-sesion-cliente').remove();	
								$('#div_carrito').remove();	
								let urlx = 'cliente/logout_cliente';
								$('#btn-pasar-a-despacho').attr('validar_sess',1);
								$('.widget-content-wrapper').prepend('<div class="widget-content-left"> <div class="btn-group"><a data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="p-0 btn validar_sess" sess="1"><img width="42" class="rounded-circle" src="assets/images/avatars/user_icon.png" alt=""> <i class="fa fa-angle-down ml-2 opacity-8"></i> </a><div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu dropdown-menu-right"><button type="button" tabindex="0" class="dropdown-item" disabled><i class="fa fa-unlock" ></i>&nbsp;Cambiar Contraseña</button> <div tabindex="-1" class="dropdown-divider"></div><a  href="javascript:;" onclick="Cliente.logOut_cliente();" class="dropdown-item"><i class="fa fa-close"></i>&nbsp;Cerrar Sesion</a></div></div></div><a href="javascript:;" id="#cargar_pedidos_cliente" onclick="Cliente.listado_pedidos_cliente();"><i class="fas fa-cart-arrow-down" style="font-size: 2em;" ></i></a></div>');
								// let fn_string = '';
								// for ( var i = 0; i >= modalId; i++ ) {
								// 	fn_string
								// }
								var fn='Fn.showModal({ id:'+modalId+',show:false });Fn.showModal({ id:'+(modalId - 1)+',show:false });Fn.showModal({ id:'+(modalId - 2)+',show:false });Fn.showModal({ id:'+(modalId - 3)+',show:false });Fn.showModal({ id:'+(modalId - 4)+',show:false }) ';
							}else if(b.status==1 && $('#btn-login-cliente').attr('redir') ==''){
								var fn='Fn.showModal({ id:'+modalId+',show:false });Fn.loadPage("'+b.url+'");';//

								// var fn='Fn.showModal({ id:'+modalId+',show:false });Fn.loadPage("cliente");';//
							}else{
								 var fn='Fn.showModal({ id:'+modalId+',show:false });';

							}
							
							// if(b.status==1 && $('#btn-login-cliente').attr('redir') ==''){
							// 	var fn='Fn.showModal({ id:'+modalId+',show:false });Fn.loadPage("'+b.url+'");';//
							// }
							// else var fn='Fn.showModal({ id:'+modalId+',show:false });';

							var btn=new Array();
							btn[0]={title:'Continuar',fn:fn};
							Fn.showModal({ id:modalId,show:true,title:b.msg.title,content:b.msg.content,btn:btn });
						}
					});
				}
			});
		});
		
	}

	
}

Cliente.load();


