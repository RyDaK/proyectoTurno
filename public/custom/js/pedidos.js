var Pedidos={
	
	num_pedidos: 0,
	enproceso: 0,
	
	meavisan: function(modalId_){
		$.when( Fn.validateForm({ id:"frm-register" }) ).then(function(a){
			if( a===true ){
				var data={};
				data=Fn.formSerializeObject("frm-register");
				var jsonString={ 'data':JSON.stringify(data), datetime: Global.dateTime };
				
				var url="ticket/registrar";
				var config={ url:url,data:jsonString };

				$.when( Fn.ajax(config) ).then(function(b){
					if( b.result!=2 ){
						++modalId;

						if(b.result==1){
							var fn='Fn.showModal({ id:'+modalId+',show:false });Fn.showModal({ id:'+modalId_+',show:false });$("#btn-refresh").click();';
						} else var fn='Fn.showModal({ id:'+modalId+',show:false })';

						var btn=new Array();
						btn[0]={title:'Aceptar',fn:fn};
						Fn.showModal({ id:modalId,show:true,title:b.msg.title,content:b.msg.content,btn:btn });
					}
				});
				
			}
		});
		
		
	},
	
	editar: function(modalId_){
		$.when( Fn.validateForm({ id:"frm-register" }) ).then(function(a){
			if( a===true ){
				var data={};
				data=Fn.formSerializeObject("frm-register");
				var jsonString={ 'data':JSON.stringify(data), datetime: Global.dateTime };
				
				var url="pedidos/editar";
				var config={ url:url,data:jsonString };

				$.when( Fn.ajax(config) ).then(function(b){
					if( b.result!=2 ){
						++modalId;

						if(b.result==1){
							var fn='Fn.showModal({ id:'+modalId+',show:false });Fn.showModal({ id:'+modalId_+',show:false });$("#btn-refresh").click();';
						} else var fn='Fn.showModal({ id:'+modalId+',show:false })';

						var btn=new Array();
						btn[0]={title:'Aceptar',fn:fn};
						Fn.showModal({ id:modalId,show:true,title:b.msg.title,content:b.msg.content,btn:btn });
					}
				});
				
			}
		});
	},
	
	validar_pedidos: function() {
		console.log(Pedidos.enproceso);
		if(Pedidos.enproceso == 0){
			console.log("entro");
			
			var data={};
			var jsonString={ 'data':JSON.stringify(data) };
			var url="pedidos/pendientes_online";
			var config={ url:url,data:jsonString };
			Pedidos.enproceso = 1;
			$.when( Fn.simpleAjax(config) ).then(function(a){
				Pedidos.enproceso = 0;
				console.log(a.result);
				if (a.result == 1) {
					console.log(Pedidos.num_pedidos);
					console.log(a.data.rows);
					if(Pedidos.num_pedidos < a.data.rows){
						Pedidos.enproceso = 1;
						swal({
						  title: "Nuevo Pedido Registrado",
						  text: "Presione aceptar para continuar.",
						  type: "success",
						  showCancelButton: false,
						  confirmButtonClass: 'btn-success',
						  confirmButtonText: 'Vamos!'
						}, function () {
							//Pedidos.enproceso = 0;
							$("#btn-refresh").click();
						});
					} 
				}
				
			});
		}
		setInterval('Pedidos.validar_pedidos()',15000);
	},
	
	load: function(){

		$("#btn-send").on("click",function(e){
			Pedidos.enproceso = 1;
			var pedidos = [];
			$('#tb-list').DataTable().rows().every(function (rowIdx, tableLoop, rowLoop) {
				var data = this.node();
				//var checked = $(data).find('input[type="checkbox"]').prop('checked');
				if($(data).hasClass( "selected" )){
					pedidos.push($(data).attr("data-id"));
				}
				
			});
			if(pedidos.length > 0){
				var data={pedidos:pedidos};
				var jsonString={ 'data':JSON.stringify(data), datetime: Global.dateTime };
				var url="pedidos/avisar";
				var config={ url:url,data:jsonString };

				$.when( Fn.ajax(config) ).then(function(a){
					Pedidos.enproceso = 0;
					if (a.result == 1) {
						++modalId;
						if(a.status==1){
							var fn='Fn.showModal({ id:'+modalId+',show:false });$("#btn-refresh").click();';//
						}
						else var fn='Fn.showModal({ id:'+modalId+',show:false });';

						var btn=new Array();
						btn[0]={title:'Continuar',fn:fn};
						Fn.showModal({ id:modalId,show:true,title:'Pedidos',content:a.data.html,btn:btn });
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
			Pedidos.enproceso = 1;
			var id = $(this).attr("data-id");
			var value = $(this).attr("data-value");
			var data={id:id,value:value};
			var jsonString={'data':JSON.stringify(data)};
			var url="pedidos/edit_pedido";
			var config={ url:url,data:jsonString };

			$.when( Fn.ajax(config) ).then(function(a){
				//Pedidos.enproceso = 0;
				if (a.result == 1) {
					++modalId;
					var fn1='Fn.showModal({ id:'+modalId+',show:false });';
					var fn2='Pedidos.editar("'+modalId+'");';
					var btn=new Array();
						btn[0]={title:'Cancelar',fn:fn1};
						btn[1]={title:'Guardar',fn:fn2};
					Fn.showModal({ id:modalId,show:true,title:'Pedidos',content:a.data.html,btn:btn, large: true });
				}
			});
		});
		
		$("#btn-refresh").on("click",function(e){
			e.preventDefault();
			//
			Pedidos.enproceso = 1;
			var data={};
			var jsonString={ 'data':JSON.stringify(data) };
			var url="pedidos/pendientes";
			var config={ url:url,data:jsonString };

			$.when( Fn.ajax(config) ).then(function(a){
				Pedidos.enproceso = 0;
				if (a.result == 1) {
					$('#content-table').html(a.data.html);
					Pedidos.num_pedidos = a.data.rows;
					console.log(Pedidos.num_pedidos);
					$('#tb-list').DataTable({
						columnDefs: [ {
							orderable: false,
							className: 'select-checkbox',
							targets:   0
						} ],
						select: {
							style:    'multi',
							selector: 'td:first-child'
						},
						//order: [[ 1, 'asc' ]],
						buttons: {
							buttons: [
								{ extend: 'excel', className: 'btn btn-danger', title: 'pedidos_pendientes', text: 'Exportar <i class="fa fa-file-excel-o"></i>',exportOptions: {
							columns: 'th:not(:first-child):not(:nth-child(2))'
						 } }
							]
						}
					});
					//
					Pedidos.validar_pedidos();
				}
			});
		});
		
		
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
				Pedidos.enproceso = 1;
				if (a.result == 1) {
					++modalId;
					var fn1='Fn.showModal({ id:'+modalId+',show:false });';
					var fn2='Pedidos.meavisan("'+modalId+'");';
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
		
		
		$(document).on('change','#numero_doc',function(e){
			Pedidos.enproceso = 1;
			var tipo = $("#tipo_doc").val();
			var numero = $(this).val();
			if( tipo == 1 && numero.length > 0 ){
				var url = 'ticket/get_dni/' + numero;
				$.when( Fn.ajax({ 'url': url }) ).then(function(a){
					Pedidos.enproceso = 0;
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
Pedidos.load();