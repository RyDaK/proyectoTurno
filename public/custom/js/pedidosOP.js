var PedidosOP={
	
	num_pedidos: 0,
	enproceso: 0,
	despacho: '',
	pago: '',
	cod_local: '',
	perfil_usuario : '',
	total_nuevo:0,
	llenado : 0,
	bucledet: 0,

	click : false,
	cerrar_modales: function($id){
		for (var i=0; i<=$id; i++) {
			Fn.showModal({ id:i,show:false })
		}

	},
	desactivar_boton: function($this){
		
		$this.val('Please wait..');
		$this.prop('hidden', true);
		// $this.disabled = true;
		// $("#btn-refresh-wait").removeAttr("hidden");
			setTimeout(function() { 
				$this.prop('hidden', false);
				// $this.disabled = false;
				$this.val('Actualizar');
				// $("#btn-refresh-wait").attr("hidden","hidden");

		}, 4000);
	},

	validar_pedidos: function() {
		console.log(PedidosOP.enproceso);
		if(PedidosOP.enproceso == 0){
			console.log("entro");
			
			var data={};
			var jsonString={ 'data':JSON.stringify(data) };
			var url="pedidos/pendientes_online";
			var config={ url:url,data:jsonString };
			PedidosOP.enproceso = 1;
			$.when( Fn.simpleAjax(config) ).then(function(a){
				PedidosOP.enproceso = 0;
				console.log(a.result);
				if (a.result == 1) {
					console.log(PedidosOP.num_pedidos);
					console.log(a.data.rows);
					if(PedidosOP.num_pedidos < a.data.rows){
						PedidosOP.enproceso = 1;
						swal({
						  title: "Nuevo Pedido Registrado",
						  text: "Presione aceptar para continuar.",
						  type: "success",
						  showCancelButton: false,
						  confirmButtonClass: 'btn-success',
						  confirmButtonText: 'Vamos!'
						}, function () {
							//PedidosOP.enproceso = 0;
							$("#btn-refresh").click();
						});
					} 
				}
				
			});
		}
		setInterval('PedidosOP.validar_pedidos()',15000);
	},
	registrar_pedido : function(){
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
		let $i = -1;
		if(direccion_envio != ''){
		   direccion_envio = direccion_envio;
		}else{
			direccion_envio == '';
		}

		$(".recojo-envio").each(function( index ) {
			if($(this).is(':checked')){
				PedidosOP.despacho = $(this).attr('value');
			}
		});

	

		var data={'metodo_despacho':PedidosOP.despacho,
		'metodo_pago':PedidosOP.pago,
		'direccion_envio':direccion_envio,
		'fecha_pedido':$('#txtfechapedido').val(),
		'dni':$('#txtdniped').val(),
		'delivery':$('#txtcosto_envio_vista').val(),
		'telf':$('#txttelfped').val(),
		'nombre':$('#txtnombre').val(),
		'apepat':$('#txtapepat').val(),
		'apemat':$('#txtapemat').val(),
		'email':$('#txtemail').val(),
		'distrito':$('#sl_mi_distrito').val(),
		};
		
		let cancelar = false;
		if(data.metodo_pago == 2){data.delivery = 0;}
		$(".cantidad_platos").each(function( index ) {
			console.log( index + ": " + $( this ).val() );
		
			
				let cantidad = ($('#txtcant'+index).val());
				let precio_cu = Number($('#td_precio'+index).text());

				data['articulo'+index] = ($('#txtcant'+index).attr('art_cod'))
				data['cantidad'+index] = cantidad;
			
				$i++;

				if(cantidad < 1 || !$.isNumeric( cantidad )){

					cancelar =  true;
				}
				
		});
	
		if(cancelar){
			++modalId;
		
			var fn='Fn.showModal({ id:'+modalId+',show:false });';
			let content = "La cantidad debe ser siempre mayor a 0."
		   var btn=new Array();
		   btn[0]={title:'Aceptar',fn:fn};
		   Fn.showModal({ id:modalId,show:true,title:'Alerta!',content:content,btn:btn });

		   return false;
		}
		data['bucle'] = $i;
	   // data=Fn.formSerializeObject("frm_despacho_pedido");
	   var jsonString={ 'data':JSON.stringify(data) };
	   var url="pedidosOP/agregar_pedido_op";
	   var config={ url:url,data:jsonString };
	   $.when( Fn.ajax(config) ).then(function(b){

		   if( b.result!=2 ){
			   ++modalId;
				if(b.status !=0){
					var fn='Fn.showModal({ id:'+modalId+',show:false });Fn.loadPage("'+'pedidosOP'+'");';
				}else{
					var fn='Fn.showModal({ id:'+modalId+',show:false });';
				}

			   var btn=new Array();
			   btn[0]={title:'Aceptar',fn:fn};
			   Fn.showModal({ id:modalId,show:true,title:'DESPACHO',content:b.data.content,btn:btn });
		   }
	   });
	},
	confirmar_pedidos: function(cod_ped,btn){

		if(PedidosOP.click == true){
			
			PedidosOP.click = false;

			if(btn == "confirmar"){

				var data={'cod_ped':cod_ped,'cod_etapa_ped':2,'medio_envio':$('#medio_envio').val()};
			}else if(btn == "despacho"){
				var data={'cod_ped':cod_ped,'cod_etapa_ped':4};
			}else if(btn == "produccion"){
				var data={'cod_ped':cod_ped,'cod_etapa_ped':3};
			}

			
			var jsonString={'data':JSON.stringify(data)};
			var url="pedidosOP/actualizar_estado_pedido";
			var config={ url:url,data:jsonString };

			$.when( Fn.ajax(config) ).then(function(a){
				//PedidosOP.enproceso = 0;
				if (a.result == 1) {
					++modalId;
					// alert(a.data.status);return false;
					if(a.data.status == 0){
						var fn1='Fn.showModal({ id:'+modalId+',show:false });';
					}else{
						var fn1='Fn.showModal({ id:'+modalId+',show:false });PedidosOP.cerrar_modales("'+modalId+'");$("#btn-refresh").click();';

					}
					// var fn2='PedidosOP.editar("'+modalId+'");';
					var btn=new Array();
						btn[0]={title:'Aceptar',fn:fn1};
						// btn[1]={title:'Guardar',fn:fn2};
					Fn.showModal({ id:modalId,show:true,title:'Detalle de Pedido',content:a.data.html,btn:btn, large: true });
				}
			});
		

		}else{
			// alert('click');
		}


	},
	
	load: function(){

	
		$('#btn-acceso-regresar').hide();
		$(document).on('click','#btn_nuevo_op',function(e){
			var data={'idLocal':$('#txtidlocal').val()};
			var jsonString={ 'data':JSON.stringify(data), datetime: Global.dateTime };
			var url="pedidosOP/frm_nuevo_pedido";
			var config={ url:url,data:jsonString };

			$.when( Fn.ajax(config) ).then(function(a){
				PedidosOP.enproceso = 0;
				if (a.result == 1) {
					++modalId;
					if(a.status==1){
						var fn='Fn.showModal({ id:'+modalId+',show:false });$("#btn-refresh").click();';//
					}
					else var fn='Fn.showModal({ id:'+modalId+',show:false });'; PedidosOP.llenado = 0; PedidosOP.bucledet = 0;

					var btn=new Array();
					btn[0]={title:'Cerrar',fn:fn};
					Fn.showModal({ id:modalId,show:true,title:'Pedidos',content:a.data.html,btn:btn, xlarge:true });
				}
			});
		});
	
		$(document).on('click','#btn-al-carrito',function(e){

			let validar_cant = $('#txt_cantidad_pedidos'+$(this).attr('cod_plato')).val();
				if(validar_cant != '' && $.isNumeric(validar_cant) && validar_cant>0){

					if($('#txtdniped').val() == "" || $('#txtelfped').val() == ""){
						++modalId;
					var fn1='Fn.showModal({ id:'+modalId+',show:false });';
					// var fn2='Fn.showModal({ id:'+modalId+',show:false });Fn.loadPage("'+a.url+'");';
					var btn=new Array();
					let simbolo = '<i class="fas fa-exclamation-circle"></i>';
					btn[0]={title:'Aceptar',fn:fn1};
					// btn[1]={title:'Ver Pedidos',fn:fn2};
					Fn.showModal({ id:modalId,show:true,title:'Pedidos',content:simbolo+' Debe completar todos los campos.',btn:btn, large: true });
						return false;
					}
					var data={'cantidad_pedidos': $('#txt_cantidad_pedidos'+$(this).attr('cod_plato')).val(),
					'cod_comercio': $(this).attr('cod_comercio'),
					'cod_plato': $(this).attr('cod_plato'),
					'cod_local_comercio': $(this).attr('cod_local_comercio'),
					'dni':$('#txtdniped').val(),
					'telf':$('#txtelfped').val(),
					'delivery':$('#txtcosto_envio_vista').val(),
					'nombre':$('#txtnombre').val(),
					'apepat':$('#txtapepat').val(),
					'apemat':$('#txtapemat').val(),
					'email':$('#txtemail').val(),

						};
						console.log(data);
					var jsonString={'data':JSON.stringify(data)};
					var url="pedidosOP/agregar_pedido_op";
					var config={ url:url,data:jsonString };
		
					$.when( Fn.ajax(config) ).then(function(a){
						// Pedidos.enproceso = 1;
						if (a.result == 1) {
							
							$('cantidad-notificaciones').html('1');
							++modalId;
							var fn1='Fn.showModal({ id:'+modalId+',show:false });';
							var fn2='Fn.showModal({ id:'+modalId+',show:false });Fn.loadPage("'+a.url+'");';
							var btn=new Array();
							btn[0]={title:'Aceptar',fn:fn1};
							// btn[1]={title:'Ver Pedidos',fn:fn2};
							Fn.showModal({ id:modalId,show:true,title:'Detalle de Pedido',content:a.data.message,btn:btn, large: true });
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
		})
		$(document).on('click','#btn_nuevo_op',function(e){
			let sesion_ini = $('.validar_sess').attr('sess');
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
							var fn2='Fn.showModal({ id:'+modalId+',show:false });Fn.loadPage("'+a.url+'");';
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
		$("#btn-send").on("click",function(e){
			PedidosOP.click = true;
			PedidosOP.enproceso = 1;
			var cod_estado_ped = Number($(this).attr('id_estado_ped'))+ 1;
			// alert(cod_estado_ped);return false;
			var pedidos = [];
			$('#tb-list').DataTable().rows().every(function (rowIdx, tableLoop, rowLoop) {
				var data = this.node();
				//var checked = $(data).find('input[type="checkbox"]').prop('checked');
				if($(data).hasClass( "selected" )){
					pedidos.push($(data).attr("data-id"));
				}
				
			});
			if(pedidos.length > 0){
				var data={pedidos:pedidos,cod_estado_ped:cod_estado_ped};
				var jsonString={ 'data':JSON.stringify(data), datetime: Global.dateTime };
				var url="pedidosOP/frm_confirmar_pedidos";
				var config={ url:url,data:jsonString };

				$.when( Fn.ajax(config) ).then(function(a){
					PedidosOP.enproceso = 0;
					if (a.result == 1) {
						++modalId;
						if(a.status==1){
							var fn='Fn.showModal({ id:'+modalId+',show:false });$("#btn-refresh").click();';//
						}
						else var fn='Fn.showModal({ id:'+modalId+',show:false });';

						var btn=new Array();
						btn[0]={title:'Cerrar',fn:fn};
						Fn.showModal({ id:modalId,show:true,title:'Detalle de Pedido',content:a.data.html,btn:btn, xlarge:true });
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
	
		$(document).on('click','.btn-edit-telefono',function(e){
			PedidosOP.enproceso = 1;
			var id = $(this).attr("data-id");
			var value = $(this).attr("data-value");
			var data={id:id,value:value};
			var jsonString={'data':JSON.stringify(data)};
			var url="pedidos/edit_pedido";
			var config={ url:url,data:jsonString };

			$.when( Fn.ajax(config) ).then(function(a){
				//PedidosOP.enproceso = 0;
				if (a.result == 1) {
					++modalId;
					var fn1='Fn.showModal({ id:'+modalId+',show:false });';
					var fn2='PedidosOP.editar("'+modalId+'");';
					var btn=new Array();
						btn[0]={title:'Cancelar',fn:fn1};
						btn[1]={title:'Guardar',fn:fn2};
					Fn.showModal({ id:modalId,show:true,title:'Pedidos',content:a.data.html,btn:btn, large: true });
				}
			});
		});
		
		$(document).on('click','#btn_actualizar_pago_enlinea',function(e){
			PedidosOP.enproceso = 1;
			var id = $(this).attr("data-id");
			var data={id:id};
			var jsonString={'data':JSON.stringify(data)};
			var url="pedidosOP/confirmar_pego_en_linea";
			var config={ url:url,data:jsonString };

			$.when( Fn.ajax(config) ).then(function(a){
				//PedidosOP.enproceso = 0;
				if (a.result == 1) {
					++modalId;
					var fn1='Fn.showModal({ id:'+modalId+',show:false });Fn.loadPage("'+"pedidosOP"+'");';
					var btn=new Array();
						btn[0]={title:'Aceptar',fn:fn1};
					Fn.showModal({ id:modalId,show:true,title:'Pedidos',content:a.data.html,btn:btn, large: true });
				}
			});
		});

		$(document).on('click','#fila_para_carrito',function(e){

			PedidosOP.bucledet = PedidosOP.bucledet - 1; 
			
			$(this).closest('tr').remove();
			let importe_todo = 0;
			let importe_cu = 0;
			$(".cantidad_platos").each(function( index ) {
				if($( this ).val() <= 0||$( this ).val() ==''){
					$(this).css('border-color','red');
				}else if($.isNumeric($(this).val()) && $( this ).val() !='' && $( this ).val() >0){
					$(this).css('border-color','blue');
					// let importe_pedido = ($('#precio_plato'+index).val() * $(this).val());
					let cantidad = ($('#txtcant'+index).val());
					let precio_cu = Number($('#td_precio'+index).text());
					importe_cu = cantidad*precio_cu;
					importe_todo += Number(importe_cu);

					if($.isNumeric(importe_cu)){
						$('#txtsubtotal'+index).attr('value',importe_cu);
						// alert(importe_cu + ' ' + cantidad + ' '+ precio_cu); 
						$('#total_pedido').attr('value',Math.round(importe_todo*100)/100);
					}
				}else{
					$(this).css('border-color','red');
				}
			});
			importe_todo = 0;

		});
		
		$(document).on('click','.btn-acceso-pedidos',function(e){

			PedidosOP.enproceso = 1;
			var id = $(this).attr("data-id");
			var value = $(this).attr("data-value");
			var data={id:id,value:value};
			var jsonString={'data':JSON.stringify(data)};
			var url="pedidosOP/pedidos_proceso";
			var config={ url:url,data:jsonString };

			$.when( Fn.ajax(config) ).then(function(a){
				//PedidosOP.enproceso = 0;
				if (a.result == 1) {

					
					if(value == 2 && $('#btn-send').attr('profile')!=7){
					
					$('#btn_nuevo_op').html('<i class="fa fa-times" ></i> Informar No Produccion');
					$('#btn_nuevo_op').attr('data-original-title','Informar No Produccion');
					$('#btn_nuevo_op').attr('id','btn-no-produccion');

					$('#btn-send').html('<i class="fa fa-check" ></i> Enviar a Produccion / Confirmar produccion');
					$('#btn-send').attr('data-original-title','Enviar a Produccion / Confirmar produccion');
					$('#btn-send').attr('id_estado_ped',2);
					$('#btn-refresh').attr('id_estado_ped',2);
						
					$('#btn-acceso').html('<i class="fa fa-truck" ></i> Pedidos listos para Despacho');
					$('#btn-acceso').attr('data-original-title','Pedidos listos para Despacho');
					$('#btn-acceso').attr('data-value','3');
					
					$('#btn-acceso-regresar').attr('data-value','1');
					$('#btn-acceso-regresar').show();

					$('#btn-acceso').show();

					$('#title__').html('Central de Pedidos - Producción');

					if($('#btn-send').attr('profile') == 6 && $('#btn-acceso').attr('data-value') ==3 ){
						$('#btn-acceso').hide();
					}
					
				}else if (value == 3 || $('#btn-send').attr('profile')==7){
					$('#btn-send').html('<i class="fa fa-check" ></i> Confirmar Despacho');
					$('#btn-send').attr('data-original-title','Confirmar Despacho');
					$('#btn-send').attr('id_estado_ped',3);
					$('#btn-refresh').attr('id_estado_ped',3);

					
				$('#btn-no-produccion').html('<i class="fa fa-times" ></i> Informar No Despacho');
				$('#btn-no-produccion').attr('data-original-title','Informar No Despacho');
				$('#btn-no-produccion').attr('id','btn-no-despacho');

				$('#btn-acceso').html('<i class="fa fa-truck" ></i> Pedidos en Produccion');
				$('#btn-acceso').attr('data-original-title','Pedidos en Produccion');
				$('#btn-acceso').attr('data-value','4');
				$('#btn-acceso').hide();
				$('#btn-acceso-regresar').attr('data-value','2');


				$('#title__').html('Central de Pedidos - Despacho');

				}else if(value == 4){
					$('#btn-acceso-regresar').attr('data-value','1');
					
				}
				$('#btn-no-produccion').hide();
				$('#btn-no-despacho').hide();


					// $('#btn-refresh').hide();
					
					$('#content-table').html(a.data.html);
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
						buttons: [],
					});
				}
			});
			
		});

		$(document).on('click','#btn-acceso-regresar',function(e){

			if($('#btn-acceso').attr("data-value") == 3){
				$('#btn-acceso-regresar').attr('data-value','1');

			}

			PedidosOP.enproceso = 1;
			var id = $(this).attr("data-id");
			var value = $(this).attr("data-value");
			var data={id:id,value:value};
			var jsonString={'data':JSON.stringify(data)};
			var url="pedidosOP/pedidos_proceso";
			var config={ url:url,data:jsonString };

			$.when( Fn.ajax(config) ).then(function(a){
				//PedidosOP.enproceso = 0;
				if (a.result == 1) {

					
					if(value == 2 && $('#btn-send').attr('profile')!=7){
					
					$('#btn_nuevo_op').html('<i class="fa fa-times" ></i> Informar No Produccion');
					$('#btn_nuevo_op').attr('data-original-title','Informar No Produccion');
					$('#btn_nuevo_op').attr('id','btn-no-produccion');

					$('#btn-send').html('<i class="fa fa-check" ></i> Enviar a Produccion / Confirmar produccion');
					$('#btn-send').attr('data-original-title','Enviar a Produccion / Confirmar produccion');
					$('#btn-send').attr('id_estado_ped',2);
					$('#btn-refresh').attr('id_estado_ped',2);
						
					$('#btn-acceso').html('<i class="fa fa-truck" ></i> Pedidos listos para Despacho');
					$('#btn-acceso').attr('data-original-title','Pedidos listos para Despacho');
					$('#btn-acceso').attr('data-value','3');
					
					// $('#btn-acceso-regresar').attr('data-value','1');
					$('#btn-acceso-regresar').show();


					$('#btn-acceso').show();

					$('#title__').html('Central de Pedidos - Producción');

					$('#btn-acceso').show();

					
				}else if (value == 3 || $('#btn-send').attr('profile')==7){
					$('#btn-send').html('<i class="fa fa-check" ></i> Confirmar Despacho');
					$('#btn-send').attr('data-original-title','Confirmar Despacho');
					$('#btn-send').attr('id_estado_ped',3);
					$('#btn-refresh').attr('id_estado_ped',3);

					
				$('#btn-no-produccion').html('<i class="fa fa-times" ></i> Informar No Despacho');
				$('#btn-no-produccion').attr('data-original-title','Informar No Despacho');
				$('#btn-no-produccion').attr('id','btn-no-despacho');

				$('#btn-acceso').html('<i class="fa fa-truck" ></i> Pedidos en Produccion');
				$('#btn-acceso').attr('data-original-title','Pedidos en Produccion');
				$('#btn-acceso').attr('data-value','4');
				$('#btn-acceso').show();

				$('#title__').html('Central de Pedidos - Despacho');

				$('#btn-acceso-regresar').attr('data-value','2');
				$('#btn-acceso-regresar').show();
				}else if(value == 4){
				$('#btn-acceso-regresar').attr('data-value','2');
					
				}else if(value == 1){
					Fn.loadPage('PedidosOP');
				}

				if($('#btn-acceso').attr("data-value") == 4){
					$('#btn-acceso-regresar').attr('data-value','1');
	
				}

	
					$('#content-table').html(a.data.html);
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
						buttons: [],
					});
				}
			});
			
		});
	

		$("#btn-refresh").on("click",function(e){
			
			e.preventDefault();
			let estado_ped = $('#btn-send').attr('id_estado_ped')
			PedidosOP.enproceso = 1;
			var data={'value': estado_ped, 'value_':$('#btn-refresh').attr('id_estado_ped')};
			var jsonString={ 'data':JSON.stringify(data) };
			if(estado_ped == 1){
				var url="pedidosOP/pendientes";
			}else{
				var url="pedidosOP/pedidos_proceso";
			}
			var config={ url:url,data:jsonString };
			
			if($('#btn-send').attr('id_rol') == 5){
				$('#title__').html('Central de Pedidos - Recepcion');
				// $('#btn_nuevo_op').hide();
				$('.btn-acceso-pedidos').hide();
			}else if($('#btn-send').attr('id_rol') == 6){
				$('#title__').html('Central de Pedidos - Produccion');
				$('#btn_nuevo_op').hide();
				$('.btn-acceso-pedidos').hide();
				
			}else if($('#btn-send').attr('id_rol') == 7){
				$('#title__').html('Central de Pedidos - Despacho');
				$('#btn_nuevo_op').hide();
				$('.btn-acceso-pedidos').hide();
				
			}
			$.when( Fn.ajax(config) ).then(function(a){
				PedidosOP.enproceso = 0;
				if (a.result == 1) {

					
					$('#content-table').html(a.data.html);
					PedidosOP.num_pedidos = a.data.rows;
					console.log(PedidosOP.num_pedidos);
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
					//
					// PedidosOP.validar_pedidos();
				}
			});
			
			var $this = $(this);
			$this.val('Please wait..');
			$this.prop('hidden', true);
			// $this.disabled = true;
			$("#btn-refresh-wait").removeAttr("hidden");
				setTimeout(function() { 
					$this.prop('hidden', false);
					// $this.disabled = false;
					$this.val('Actualizar');
					$("#btn-refresh-wait").attr("hidden","hidden");

			}, 4000);

		});
		// $( "#btn-refresh" ).hover(
		// 	function() {
		// 	  $(this).attr( "data-original-title","Actualizar" ) ;
		// 	}, function() {
		// 	//   $( this ).find( "span" ).last().remove();
		// 	$(this).attr( "data-original-title","" ) ;

		// 	}
		//   );
	

		
		$("#btn-refresh-liq").on("click",function(e){
			e.preventDefault();
			//
			var data={'fechas':$("#txt-fechas").val(), 'id_comercio' :  $("#comercio").val(), 'id_pdv' :  $("#pdv").val()};
			var jsonString={ 'data':JSON.stringify(data) };
			var url="pedidos/rpt_liquidacion";
			var config={ url:url,data:jsonString };

			$.when( Fn.ajax(config) ).then(function(a){
				if (a.result == 1) {
					$('#content-boxes').html(a.data.html1);
					$('#content-table').html(a.data.html2);
					$('#tb-list').DataTable({
						buttons: {
							buttons: [
								{ extend: 'excel', className: 'btn btn-danger', title: 'pedidos_pendientes', text: 'Exportar <i class="fa fa-file-excel-o"></i>'}
							]
						}
					});
				}
			});
		});
		
		
		$(document).on('click','.lk-pedidos-table',function(e){
			e.preventDefault();
			//
			var auto = $(this).attr("data-auto");
			var etapa = $(this).attr("data-etapa");
			//
			var data={'fechas':$("#txt-fechas").val(), 'id_comercio' :  $("#comercio").val(), 'id_pdv' :  $("#pdv").val(), 'auto':auto, 'etapa':etapa};
			var jsonString={ 'data':JSON.stringify(data) };
			var url="pedidos/table_liquidacion";
			var config={ url:url,data:jsonString };

			$.when( Fn.ajax(config) ).then(function(a){
				if (a.result == 1) {
					//$('#content-boxes').html(a.data.html1);
					$('#content-table').html(a.data.html2);
					$('#tb-list').DataTable({
						buttons: {
							buttons: [
								{ extend: 'excel', className: 'btn btn-danger', title: 'pedidos_pendientes', text: 'Exportar <i class="fa fa-file-excel-o"></i>'}
							]
						}
					});
				}
			});
		});
		
		$("#btn-new").on("click",function(e){
			var data={};
			var jsonString={'data':JSON.stringify(data)};
			var url="pedidos/nuevo";
			var config={ url:url,data:jsonString };

			$.when( Fn.ajax(config) ).then(function(a){
				PedidosOP.enproceso = 1;
				if (a.result == 1) {
					++modalId;
					var fn1='Fn.showModal({ id:'+modalId+',show:false });';
					var fn2='PedidosOP.meavisan("'+modalId+'");';
					var btn=new Array();
						btn[0]={title:'Cancelar',fn:fn1};
						btn[1]={title:'Guardar',fn:fn2};
					Fn.showModal({ id:modalId,show:true,title:'Pedidos',content:a.data.html,btn:btn, large: true });
				}
			});
		});
	
	
		$("#comercio").on("change",function(e){
			var id = $(this).val();
			//
			var html='<option value="" >-- PDV --</option>';
			$('#pdv').html(html);
			if( typeof(json_pdv[id])=='object'){
				$.each(json_pdv[id],function(i,v){
					var selected = '';
					html+='<option value='+v.id_pdv+' '+selected+' >'+v.pdv+'</option>';
				});
			}
			$('#pdv').html(html);
		});

		$(document).on('keyup','.cantidad_platos',function(e){

			let importe_todo = 0;
			let importe_cu = 0;
			$(".cantidad_platos").each(function( index ) {
				if($( this ).val() <= 0||$( this ).val() ==''){
					$(this).css('border-color','red');
				}else if($.isNumeric($(this).val()) && $( this ).val() !='' && $( this ).val() >0){
					$(this).css('border-color','blue');
					// let importe_pedido = ($('#precio_plato'+index).val() * $(this).val());
					let cantidad = ($('#txtcant'+index).val());
					let precio_cu = Number($('#td_precio'+index).text());
					importe_cu = cantidad*precio_cu;
					importe_todo += Number(importe_cu);

					if($.isNumeric(importe_cu)){
						$('#txtsubtotal'+index).attr('value',(importe_cu).toFixed(2));
						// alert(importe_cu + ' ' + cantidad + ' '+ precio_cu); 
						$('#total_pedido').attr('value',(Math.round(importe_todo*100)/100).toFixed(2));
					}
				}else{
					$(this).css('border-color','red');
				}
			});
			importe_todo = 0;
		});

		$(document).on('click','#btn_buscar_usuario',function(e){

			var data={'dni':$('#txtdniped').val()};
			var jsonString={'data':JSON.stringify(data)};
			var url="pedidosOP/buscar_usuario";
			var config={ url:url,data:jsonString };
			if(data.cod_art != ''){

				$.when( Fn.ajax(config) ).then(function(a){
					if (a.result == 0) {
						$('#txtnombre').val('');
						$('#txtapepat').val('');
						$('#txtapemat').val('');
						$('#txtemail').val('');
						$('#txttelfped').val('');
					}else if(a.result == 1){
						$('#txtnombre').val(a.data.nombre);
						$('#txtapepat').val(a.data.apepat);
						$('#txtapemat').val(a.data.apemat);
						$('#txtemail').val(a.data.email);
						$('#txttelfped').val(a.data.telefono);

					}

					++modalId;
					var fn1='Fn.showModal({ id:'+modalId+',show:false });';
					// var fn2='PedidosOP.editar("'+modalId+'");';
					var btn=new Array();
						btn[0]={title:'Aceptar',fn:fn1};
						// btn[1]={title:'Guardar',fn:fn2};
					Fn.showModal({ id:modalId,show:true,title:'Pedidos',content:a.data.msg,btn:btn, large: true });
				});
			}
		});
		
		$(document).on('click','#agregar_articulo',function(e){
			
			var data={'cod_art':$('#sel_articulos').val(),'bucle':PedidosOP.bucledet};
			var jsonString={'data':JSON.stringify(data)};
			var url="pedidosOP/para_el_carrito";
			var config={ url:url,data:jsonString };
			if(data.cod_art != ''){

				$.when( Fn.ajax(config) ).then(function(a){
					//PedidosOP.enproceso = 0;
					if (a.result == 1) {
						// ++modalId;
						// var fn1='Fn.showModal({ id:'+modalId+',show:false });Fn.loadPage("'+"pedidosOP"+'");';
						// // var fn2='PedidosOP.editar("'+modalId+'");';
						// var btn=new Array();
						// 	btn[0]={title:'Aceptar',fn:fn1};
						// 	// btn[1]={title:'Guardar',fn:fn2};
						// Fn.showModal({ id:modalId,show:true,title:'Pedidos',content:a.data.html,btn:btn, large: true });
						console.log(a.data.tabla);
						if(PedidosOP.llenado == 0){
							$('#llenartabla').html(a.data.html)
							PedidosOP.llenado = 1
						}
						$('body').attr('class','modal-open');
						$('#cuerpo_carrito').append(a.data.tabla)
						PedidosOP.bucledet++;

					}
				});
			}
		});
		

		
		$(document).on('click','#btn_anular_pedido',function(e){

	
		var data={'cod_ped':$('#btn_anular_pedido').attr('cod_ped'), 'cod_etapa_ped':5};
			var jsonString={'data':JSON.stringify(data)};
			var url="pedidosOP/rechazar_pedido";
			var config={ url:url,data:jsonString };
	
			$.when( Fn.ajax(config) ).then(function(a){
				//PedidosOP.enproceso = 0;
				if (a.result == 1) {
					++modalId;
					var fn1='Fn.showModal({ id:'+modalId+',show:false });Fn.loadPage("'+"pedidosOP"+'");';
					// var fn2='PedidosOP.editar("'+modalId+'");';
					var btn=new Array();
						btn[0]={title:'Aceptar',fn:fn1};
						// btn[1]={title:'Guardar',fn:fn2};
					Fn.showModal({ id:modalId,show:true,title:'Pedidos',content:a.data.html,btn:btn, large: true });
				}
			});
		});
		$(document).on('change','#numero_doc',function(e){
			PedidosOP.enproceso = 1;
			var tipo = $("#tipo_doc").val();
			var numero = $(this).val();
			if( tipo == 1 && numero.length > 0 ){
				var url = 'ticket/get_dni/' + numero;
				$.when( Fn.ajax({ 'url': url }) ).then(function(a){
					PedidosOP.enproceso = 0;
					if( a['status'] == null ){
						return false;
					}
					if( a['status'] == 1 ){
						console.log(a['status']);
						var nombres = typeof(a['data']['nombres']) == 'undefined' ? '' : a['data']['nombres'];
						var apePaterno = typeof(a['data']['apellidoPaterno']) == 'undefined' ? '' : a['data']['apellidoPaterno'];
						var apeMaterno = typeof(a['data']['apellidoMaterno']) == 'undefined' ? '' : a['data']['apellidoMaterno'];
						//
						console.log('aqui');
						console.log(a['data']);
						//
						$('input[name="nombre"]').val(nombres);
						$('input[name="apePaterno"]').val(apePaterno);
						$('input[name="apeMaterno"]').val(apeMaterno);
					} else {
						$('input[name="nombre"]').val('');
						$('input[name="apePaterno"]').val('');
						$('input[name="apeMaterno"]').val('');
					}
				});
			}
		});
		
		$("#btn-refresh").click();
		$("#btn-refresh-liq").click();
	}

}

PedidosOP.load();