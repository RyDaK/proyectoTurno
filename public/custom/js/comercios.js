var Comercios={
	idComercioSel:""
	,
	eliminar_fila_temp: function($params){
		$('#metodo_temp'+$params.id).remove();
		$('#id_metodo_pag').append('<option id="op'+$params.id+'" >'+$params.nombre+'</option>')
	},
	eliminarOption:function($id){
		$('#op'+$id).remove();
	},
	agregar_metodo_fila: function(){
		var data={};
		data=Fn.formSerializeObject("frm-comercios");
		let $id_metodo = $('#id_metodo_pag').val();
		data.id_metodo = $id_metodo;
		var jsonString={'data':JSON.stringify(data)};
		var url="comercios/agregar_metodo_comercio";
		var config={ url:url,data:jsonString };

		if($id_metodo !=''){

			$.when( Fn.ajax(config) ).then(function(a){
				if( a.result!=2 ){
					if( a.result==1 ){
						$('#tabla_metodos_comercio').append(a.data.tabla)
						$('#op'+$id_metodo).remove();
						// $('#id_metodo_pag').empty();
						// $('#id_metodo_pag').html(a.data.select)
					}else{
						++modalId;
						var fn1='Fn.showModal({ id:'+modalId+',show:false });';
						var btn=new Array();
							btn[0]={title:'Aceptar',fn:fn1};
						Fn.showModal({ id:modalId,show:true,title:a.msg.title,content:a.msg.content,btn:btn });
					}
				}
			});
		}else{console.log('No hay metodo seleccionado');}

	},
	eliminar_metodo_fila:function($id_metodo,$option){
		var data={};
		data=Fn.formSerializeObject("frm-comercios");
		data.id_metodo = $id_metodo;
		var jsonString={'data':JSON.stringify(data)};
		var url="comercios/eliminar_fila_pago_comercio";
		var config={ url:url,data:jsonString };

		$.when( Fn.ajax(config) ).then(function(a){
			if( a.result!=2 ){
				if( a.result==1 ){
					$('#tabla_metodos_comercio').empty();
					$('#tabla_metodos_comercio').append(a.data.html)
				}else{
					++modalId;
					var fn1='Fn.showModal({ id:'+modalId+',show:false });';
					var btn=new Array();
						btn[0]={title:'Aceptar',fn:fn1};
					Fn.showModal({ id:modalId,show:true,title:a.msg.title,content:a.msg.content,btn:btn });
				}
			}
		});
	},

	load: function(){

		$('#tb-list').DataTable({
			columnDefs: [ {
				orderable: false,
				targets:   0
			} ],
			select: {
				style:    'single',
				selector: 'td:first-child'
			},
			//order: [[ 1, 'asc' ]],
			buttons: {
				buttons: [
					{  attr:  {	id: 'btn-edit-comercio'},className: 'btn btn-sm btn-success', title: 'Editar', text: '<i class="fa fa-edit" ></i> Editar'},
					{  attr:  {	id: 'btn-carga-cred-turno'},className: 'btn btn-sm btn-success', title: 'Cargar Creditos', text: '<i class="fa fa-upload" ></i> Cargar Creditos Turno'}
				]
			}	
		});

		


		$("#btn-send").on("click",function(e){
			$.when( Fn.validateForm({ id:"frm-register" }) ).then(function(a){
				if( a===true ){
					var data={};
					data=Fn.formSerializeObject("frm-register");
					var jsonString={ 'data':JSON.stringify(data), datetime: Global.dateTime };
					
					var url="comercios/registrar";
					var config={ url:url,data:jsonString };
		
					$.when( Fn.ajax(config) ).then(function(b){
						if( b.result!=2 ){
							if( b.status==1 ){
								++modalId;
								var fn='Fn.showModal({ id:'+modalId+',show:false });Comercios.limpiar_campos();Comercios.cargar_list_comercios();';
								var btn=new Array();
								
								btn[0]={title:'Aceptar',fn:fn};
								Fn.showModal({ id:modalId,show:true,title:b.msg.title,content:b.msg.content,btn:btn });
	
								
							}else{
								++modalId;
								var fn='Fn.showModal({ id:'+modalId+',show:false });';
								var btn=new Array();
								btn[0]={title:'Aceptar',fn:fn};
								Fn.showModal({ id:modalId,show:true,title:b.msg.title,content:b.msg.content,btn:btn });
							}
						}
					});
				}
			});
		});

		$(document).on('change','input[name="comercio"]',function(e){
			Comercios.idComercioSel=$(this).val();
			$('input[name="comercio"]').each(function(){
				$(this).removeAttr('checked');
			});
			if( $(this).prop('checked')==true){
				$(this).removeAttr('checked');
			}else{
				$(this).prop('checked','checked');
			}
			
		});

		$(document).on('click','#btn-carga-cred-turno',function(e){
			var data={};
			data=Fn.formSerializeObject("frm-comercios");
			data['comercio']=Comercios.idComercioSel;
			var jsonString={'data':JSON.stringify(data)};
			var url="comercios/carga_creditos";
			var config={ url:url,data:jsonString };

			$.when( Fn.ajax(config) ).then(function(a){
				if( a.result!=2 ){
					if( a.status==1 ){
						++modalId;
						var fn1='Fn.showModal({ id:'+modalId+',show:false });';
						var btn=new Array();
							btn[0]={title:'Salir',fn:fn1};
						Fn.showModal({ id:modalId,show:true,title:'Carga de Creditos',content:a.data.html,btn:btn, large: true });
						$('input[name="txt-fechas_simple"]').daterangepicker({
							locale: {
								"format": "DD/MM/YYYY",
								"applyLabel": "Aplicar",
								"cancelLabel": "Cerrar",
								"daysOfWeek": ["Do","Lu","Ma","Mi","Ju","Vi","Sa"],
								"monthNames": ["Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Setiembre","Octubre","Noviembre","Diciembre"],
								"firstDay": 1
							},
							singleDatePicker: true,
							showDropdowns: false,
							autoApply: true,
						});
					}else{
						++modalId;
						var fn1='Fn.showModal({ id:'+modalId+',show:false });';
						var btn=new Array();
							btn[0]={title:'Salir',fn:fn1};
						Fn.showModal({ id:modalId,show:true,title:a.msg.title,content:a.msg.content,btn:btn });
					}
				}
			});
		});


		$(document).on('click','#btn-add-credito',function(e){
			$.when( Fn.validateForm({ id:"frm-creditos" }) ).then(function(a){
				if( a===true ){
					var data={};
					data=Fn.formSerializeObject("frm-creditos");
					var jsonString={ 'data':JSON.stringify(data), datetime: Global.dateTime };
					
					var url="comercios/agregar_credito";
					var config={ url:url,data:jsonString };
		
					$.when( Fn.ajax(config) ).then(function(b){
						if( b.result!=2 ){
							Fn.showModal({ id:modalId,show:false });
							++modalId;
							var fn='Fn.showModal({ id:'+modalId+',show:false });$("#btn-carga-cred-turno").click();Comercios.cargar_list_comercios();';
							var btn=new Array();
							btn[0]={title:'Salir',fn:fn};
							Fn.showModal({ id:modalId,show:true,title:b.msg.title,content:b.msg.content,btn:btn });
						}
					});
				}
			});
		});

		$(document).on('change','#id_rubro',function(e){
			// $.when( Fn.validateForm({ id:"frm-creditos" }) ).then(function(a){
			// 	if( a===true ){
				// alert($('#id_rubro').val());
					var data={'id_rubro':$('#id_rubro').val()};
					// data=Fn.formSerializeObject("frm-creditos");
					var jsonString={ 'data':JSON.stringify(data) };
					
					var url="comercios/obtener_giros_rubro";
					var config={ url:url,data:jsonString };
		
					$.when( Fn.ajax(config) ).then(function(b){
						if( b.result!=2 ){
							// Fn.showModal({ id:modalId,show:false });
							// ++modalId;
							// var fn='Fn.showModal({ id:'+modalId+',show:false });$("#btn-carga-cred-turno").click();Comercios.cargar_list_comercios();';
							// var btn=new Array();
							// btn[0]={title:'Aceptar',fn:fn};
							// Fn.showModal({ id:modalId,show:true,title:b.msg.title,content:b.msg.content,btn:btn });
							$('#id_giro').empty();
							$('#id_giro').html(b.data.select);
							$('body').attr('class','modal-open');

						}
					});
				// }
			// });
		});
		
		$(document).on('change','#id_rubro_p',function(e){
			// $.when( Fn.validateForm({ id:"frm-creditos" }) ).then(function(a){
			// 	if( a===true ){
				// alert($('#id_rubro').val());
					var data={'id_rubro':$('#id_rubro_p').val()};
					// data=Fn.formSerializeObject("frm-creditos");
					var jsonString={ 'data':JSON.stringify(data) };
					
					var url="comercios/obtener_giros_rubro";
					var config={ url:url,data:jsonString };
		
					$.when( Fn.ajax(config) ).then(function(b){
						if( b.result!=2 ){
							// Fn.showModal({ id:modalId,show:false });
							// ++modalId;
							// var fn='Fn.showModal({ id:'+modalId+',show:false });$("#btn-carga-cred-turno").click();Comercios.cargar_list_comercios();';
							// var btn=new Array();
							// btn[0]={title:'Aceptar',fn:fn};
							// Fn.showModal({ id:modalId,show:true,title:b.msg.title,content:b.msg.content,btn:btn });
							$('#id_giro_p').empty();
							$('#id_giro_p').html(b.data.select);
							//$('body').attr('class','modal-open');

						}
					});
				// }
			// });
		});


		$(document).on('click','#btn-edit-comercio',function(e){
			var data={};
			data=Fn.formSerializeObject("frm-comercios");
			var jsonString={'data':JSON.stringify(data)};
			var url="comercios/edit_comercio";
			var config={ url:url,data:jsonString };

			$.when( Fn.ajax(config) ).then(function(a){
				if( a.result!=2 ){
					if( a.status==1 ){
						++modalId;
						var fn1='Fn.showModal({ id:'+modalId+',show:false });';
						var fn2='Comercios.guardar_comercio('+modalId+');';
						var btn=new Array();
							btn[0]={title:'Cancelar',fn:fn1};
							btn[1]={title:'Guardar',fn:fn2};
						Fn.showModal({ id:modalId,show:true,title:'Editar Comercio',content:a.data.html,btn:btn, large: true });
					}else{
						++modalId;
						var fn1='Fn.showModal({ id:'+modalId+',show:false });';
						var btn=new Array();
							btn[0]={title:'Salir',fn:fn1};
						Fn.showModal({ id:modalId,show:true,title:a.msg.title,content:a.msg.content,btn:btn });
					}
				}
			});
		});
		$(document).on('change',"#check-estado-envio",function(e){
			var data={};
			data['id_comercio']=$("#id_comercio").val();
			var estado=$('#check-estado-envio').prop('checked');
			data['estado']=estado;
			var jsonString={'data':JSON.stringify(data)};
			var url="comercios/cambiar_estado_comercio";
			var config={ url:url,data:jsonString };

			$.when( Fn.simpleAjax(config) ).then(function(a){
				++modalId;
				var fn1='Fn.showModal({ id:'+modalId+',show:false });Comercios.cargar_list_comercios();';
				var btn=new Array();
					btn[0]={title:'Aceptar',fn:fn1};
				Fn.showModal({ id:modalId,show:true,title:a.msg.title,content:a.msg.content,btn:btn });
			});
		});

		// $(document).on('click',"#btn-activar-comercio",function(e){
		// 	var data={};
		// 	data=$("#id_comercio").val();
		// 	var jsonString={'data':JSON.stringify(data)};
		// 	var url="comercios/activar_comercio";
		// 	var config={ url:url,data:jsonString };

		// 	$.when( Fn.ajax(config) ).then(function(a){
		// 			++modalId;
		// 			var fn1='Fn.showModal({ id:'+modalId+',show:false });Comercios.cargar_list_comercios();';
		// 			var btn=new Array();
		// 				btn[0]={title:'Aceptar',fn:fn1};
		// 			Fn.showModal({ id:modalId,show:true,title:a.msg.title,content:a.msg.content,btn:btn });
		// 	});
		// });

		// $(document).on('click',"#btn-desactivar-comercio",function(e){
		// 	var data={};
		// 	data=$("#id_comercio").val();
		// 	var jsonString={'data':JSON.stringify(data)};
		// 	var url="comercios/desactivar_comercio";
		// 	var config={ url:url,data:jsonString };

		// 	$.when( Fn.ajax(config) ).then(function(a){
		// 			++modalId;
		// 			var fn1='Fn.showModal({ id:'+modalId+',show:false });Comercios.cargar_list_comercios();';
		// 			var btn=new Array();
		// 				btn[0]={title:'Aceptar',fn:fn1};
		// 				Fn.showModal({ id:modalId,show:true,title:a.msg.title,content:a.msg.content,btn:btn });
		// 	});
		// });

		$(document).on('click','.btn-estado-credito-des',function(e){
			var id =$(this).attr('data-id');
			var estado =$(this).attr('data-estado');
			var cr =$(this).attr('data-creditos');
			
			++modalId;
			var fn1='Fn.showModal({ id:'+modalId+',show:false });';
			var fn2='Comercios.actualizar_estado_credito('+modalId+','+id+','+estado+','+cr+');';
			console.log(fn2);
			var btn=new Array();
				btn[0]={title:'Cancelar',fn:fn1};
				btn[1]={title:'Aceptar',fn:fn2};
			Fn.showModal({ id:modalId,show:true,title:'Desactivar credito',content:"Desea desactivar el credito seleccionado?",btn:btn, large: true });
		});

		$(document).on('click','.btn-estado-credito-act',function(e){
			var id =$(this).attr('data-id');
			var estado =$(this).attr('data-estado');
			var cr =$(this).attr('data-creditos');

			++modalId;
			var fn1='Fn.showModal({ id:'+modalId+',show:false });';
			var fn2='Comercios.actualizar_estado_credito('+modalId+','+id+','+estado+','+cr+');';
			
			var btn=new Array();
				btn[0]={title:'Cancelar',fn:fn1};
				btn[1]={title:'Aceptar',fn:fn2};
			Fn.showModal({ id:modalId,show:true,title:'Activar credito',content:"Desea activar el credito seleccionado?",btn:btn, large: true });
		});

		Comercios.cargar_list_comercios();

	},
	guardar_comercio: function(modalId_){
		$.when( Fn.validateForm({ id:"frm-edit-comercio" }) ).then(function(a){
			if( a===true ){
				var data={};
				data=Fn.formSerializeObject("frm-edit-comercio");
				var estado=$('#estado_comercio').prop('checked');
				data['estado']=estado;
				var jsonString={ 'data':JSON.stringify(data), datetime: Global.dateTime };
				
				var url="comercios/guardar_comercio";
				var config={ url:url,data:jsonString };
	
				$.when( Fn.ajax(config) ).then(function(b){
					if( b.result!=2 ){
						if( b.status==1 ){
							++modalId;
							var fn='Fn.showModal({ id:'+modalId+',show:false });Fn.showModal({ id:'+modalId_+',show:false });Comercios.cargar_list_comercios();';
							var btn=new Array();
							btn[0]={title:'Aceptar',fn:fn};
							Fn.showModal({ id:modalId,show:true,title:b.msg.title,content:b.msg.content,btn:btn });
						}else{
							++modalId;
							var fn='Fn.showModal({ id:'+modalId+',show:false });';
							var btn=new Array();
							btn[0]={title:'Aceptar',fn:fn};
							Fn.showModal({ id:modalId,show:true,title:b.msg.title,content:b.msg.content,btn:btn });
						}

					}
					
				});
			}
		});
	},
	actualizar_estado_credito : function(modalId_,id,estado,cr){
		var data={};
		data['id_hist_cred']=id;
		data['estado']=estado;
		data['credito']=cr;
		data['id_comercio']=$("#id_comercio").val();
		
		
		var jsonString={ 'data':JSON.stringify(data), datetime: Global.dateTime };
		
		var url="comercios/actualizar_estado_credito";
		
		var config={ url:url,data:jsonString };

		$.when( Fn.ajax(config) ).then(function(b){
			if( b.result!=2 ){
				++modalId;
				var fn='Fn.showModal({ id:'+modalId+',show:false });Fn.showModal({ id:'+modalId_+',show:false });Fn.showModal({ id:'+(--modalId_)+',show:false });$("#btn-carga-cred-turno").click();Comercios.cargar_list_comercios();';
				var btn=new Array();
				btn[0]={title:'Aceptar',fn:fn};
				Fn.showModal({ id:modalId,show:true,title:b.msg.title,content:b.msg.content,btn:btn });
			}
		});
	} ,
	cargar_list_comercios : function(){
		var data={};
		var jsonString={ 'data':JSON.stringify(data) };
		var url="comercios/obtener_comercios";
		var config={ url:url,data:jsonString };

		$.when( Fn.simpleAjax(config) ).then(function(a){
			if (a.result == 1) {
				$('#content-table-comercios').html(a.data.html1);
				$('#tb-list').DataTable({
					columnDefs: [ {
						orderable: false,
						targets:   0
					} ],
					select: {
						style:    'single',
						selector: 'td:first-child'
					},
					//order: [[ 1, 'asc' ]],
					buttons: {
						buttons: [
							{  attr:  {	id: 'btn-edit-comercio'},className: 'btn btn-sm btn-success active', title: 'Editar', text: '<i class="fa fa-edit" ></i> Editar '},
							{  attr:  {	id: 'btn-carga-cred-turno'},className: 'btn btn-sm btn-success', title: 'Cargar Creditos', text: '<i class="fa fa-upload" ></i> Cargar Creditos'}
						]
					}	
				});
			}
		});
	},
	limpiar_campos : function(){
		/*
		$('#nombre_comercial').val("");
		$('#razon_social').val("");
		$('#dni').val("");
		$('#nombre').val("");
		$('#ruc').val("");
		$('#email').val("");
		$('#telefono').val("");
		$('#creditos_turno').val("");
		$('#dni_representante').val("");
		*/
		document.getElementById("frm-register").reset();

	}

}
Comercios.load();