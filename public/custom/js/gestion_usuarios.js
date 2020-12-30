var Gestion_usuarios={
	
	load: function(){

		$("#btn-refresh-usuarios").on("click",function(e){
			e.preventDefault();
			//
			var data={};
			data['id_comercio']=$('#comercio').val();
			var jsonString={ 'data':JSON.stringify(data) };
			var url="gestion_usuarios/lista_usuarios";
			var config={ url:url,data:jsonString };

			$.when( Fn.ajax(config) ).then(function(a){
				
				if (a.result == 1) {
					$('#content-table').html(a.data.html);
					
					$('#tb-list').DataTable({
						order: [[ 0, 'dsc' ]],
						buttons: {
							buttons: [
								{ extend: 'excel', className: 'btn btn-danger', title: 'pedidos_pendientes', text: 'Exportar <i class="fa fa-file-excel-o"></i>',exportOptions: {
							columns: 'th:not(:first-child):not(:nth-child(2))'
						 } }
							]
						}
					});
					//
					
				}
			});
		});


		$(document).on('click','#btn-add-usuario',function(e){
			var data={};
			var jsonString={ 'data':JSON.stringify(data), datetime: Global.dateTime };
			
				var url="gestion_usuarios/edit_usuario";
				var config={ url:url,data:jsonString };
	
				$.when( Fn.ajax(config) ).then(function(a){
					if( a.result!=2 ){
						++modalId;
						var fn1='Fn.showModal({ id:'+modalId+',show:false });';
						var fn2='Gestion_usuarios.agregar_usuario('+modalId+');';
						var btn=new Array();
							btn[0]={title:'Cancelar',fn:fn1};
							btn[1]={title:'Guardar',fn:fn2};
						Fn.showModal({ id:modalId,show:true,title:'Agregar Usuario',content:a.data.html,btn:btn, xlarge: true });
						$("#btn-generar").click();
						if($("#id_comercio_usuario :selected").length == 1){
							$("#id_comercio_usuario").change();
						}
					}else{
						++modalId;
						var fn1='Fn.showModal({ id:'+modalId+',show:false });';
						var btn=new Array();
							btn[0]={title:'Cancelar',fn:fn1};
						Fn.showModal({ id:modalId,show:true,title:'Agregar Usuario',content:a.data.html,btn:btn});
					}
				});
		});


		$(document).on('click','.btn-edit-usuario',function(e){
			var data={};
			var id_usuario=$(this).attr('data-id');
			data['id_usuario']= id_usuario;
			var id_usuario_hist=$(this).attr('data-uh');
			data['id_usuario_hist']= id_usuario_hist;

				var jsonString={ 'data':JSON.stringify(data), datetime: Global.dateTime };
			
				var url="gestion_usuarios/edit_usuario";
				var config={ url:url,data:jsonString };
	
				$.when( Fn.ajax(config) ).then(function(a){
					if( a.result!=2 ){
						++modalId;
						var fn1='Fn.showModal({ id:'+modalId+',show:false });';
						var fn2='Gestion_usuarios.actualizar_usuario('+modalId+');';
						var btn=new Array();
							btn[0]={title:'Cancelar',fn:fn1};
							btn[1]={title:'Actualizar',fn:fn2};
						Fn.showModal({ id:modalId,show:true,title:'Editar Usuario',content:a.data.html,btn:btn, xlarge: true  });
						
						//alert($("#id_comercio_usuario :selected").length);
					}else{
						++modalId;
						var fn1='Fn.showModal({ id:'+modalId+',show:false });';
						var btn=new Array();
							btn[0]={title:'Cancelar',fn:fn1};
						Fn.showModal({ id:modalId,show:true,title:'Editar Usuario',content:a.data.html,btn:btn});
					}
				});
		});

		$(document).on('click','.btn-estado-usuario_des',function(e){
			var id_articulo =$(this).attr('data-id');
			var estado =$(this).attr('data-estado');

			++modalId;
		
			var fn1='Fn.showModal({ id:'+modalId+',show:false });';
			var fn2='Gestion_usuarios.actualizar_estado_usuario('+modalId+','+id_articulo+','+estado+');';
			var btn=new Array();
				btn[0]={title:'Cancelar',fn:fn1};
				btn[1]={title:'Aceptar',fn:fn2};
			Fn.showModal({ id:modalId,show:true,title:'Editar Usuario',content:"Desea desactivar el usuario seleccionado?",btn:btn, large: true });
		});

		$(document).on('click','.btn-estado-usuario_act',function(e){
			var id_usuario =$(this).attr('data-id');
			var estado =$(this).attr('data-estado');
			++modalId;
			var fn1='Fn.showModal({ id:'+modalId+',show:false });';
			var fn2='Gestion_usuarios.actualizar_estado_usuario('+modalId+','+id_usuario+','+estado+');';
			var btn=new Array();
				btn[0]={title:'Cancelar',fn:fn1};
				btn[1]={title:'Aceptar',fn:fn2};
			Fn.showModal({ id:modalId,show:true,title:'Editar Usuario',content:"Desea activar el usuario seleccionado?",btn:btn, large: true });
		});


		$(document).on('change','#id_comercio_usuario',function(){
			var data={};
			data['id_comercio']= $('#id_comercio_usuario').val();

			if($('#id_comercio_usuario').val()!=undefined){
				var jsonString={ 'data':JSON.stringify(data), datetime: Global.dateTime };
			
				var url="gestion_usuarios/obtener_puntos_venta";
				var config={ url:url,data:jsonString };
	
				$.when( Fn.simpleAjax(config) ).then(function(b){
					if(b.data!=null){
						var options="<option value='' > --Punto Venta-- </option>";
						$.each( b.data, function( key, value ) {
							options+="<option value='"+value['id_pdv']+"' > "+value['nombre']+" </option>";
						});
						$('#id_pdv').find('option').remove();
						$('#id_pdv').append(options);

						 	
						var id_pdv_sel=$('#id_pdv_sel').val();
						if(id_pdv_sel!=""){
							$('#id_pdv').val(id_pdv_sel).change();
							id_pdv_sel="";
						}
					}
				});
			}
			
		});


		$(document).on('change','#id_perfil',function(e){
			var data={};
			if($('#id_perfil').val()!=undefined && $('#id_perfil').val()!="" ){
				data['id_usuario_perfil']= $('#id_perfil').val();
				var jsonString={ 'data':JSON.stringify(data), datetime: Global.dateTime };
			
				var url="gestion_usuarios/obtener_menus";
				var config={ url:url,data:jsonString };
	
				$.when( Fn.simpleAjax(config) ).then(function(b){
					if(b.data!=null){
						$('.menu').each(function(){
							$(this).attr('disabled','disabled');
							$(this).removeAttr('checked');
							
						});
						
						$.each( b.data, function( key, value ) {
							$('#menu_'+value['id_menu']).removeAttr('disabled');
							$('#menu_'+value['id_menu']).prop('checked','checked');
						});
					}
				});
			}
		});


		$(document).on('change','#nro_documento',function(e){
			var usuario_ = '';
			if($("#nro_documento").val() != ''){
				usuario_ = $("#nro_documento").val();
			} else if($("#apellido_pat").val() && $("#nombres").val()){
				usuario_ = $("#nombres").val().substr(0,1) + $("#apellido_pat").val();
			}
			$('#usuario').val(usuario_);
		});
		
		$(document).on('change','#apellido_pat',function(e){
			var usuario_ = '';
			if($("#nro_documento").val() != ''){
				usuario_ = $("#nro_documento").val();
			} else if($("#apellido_pat").val() && $("#nombres").val()){
				usuario_ = $("#nombres").val().substr(0,1) + $("#apellido_pat").val();
			}
			$('#usuario').val(usuario_);
		});
		
		$(document).on('change','#nombres',function(e){
			var usuario_ = '';
			if($("#nro_documento").val() != ''){
				usuario_ = $("#nro_documento").val();
			} else if($("#apellido_pat").val() && $("#nombres").val()){
				usuario_ = $("#nombres").val().substr(0,1) + $("#apellido_pat").val();
			}
			$('#usuario').val(usuario_);
		});

		$(document).on('click','#btn-generar',function(e){
			var alphabet='abcdefghijklmnopqrstuvwxyz1234567890';
			var clave_="";
			var max= (alphabet).length-1;
			var i;
			for (i = 0; i < 6; i++) {
				var rnd=Math.round(Math.random() * (max));
				console.log(rnd);
				clave_ += alphabet[rnd];
			}
			$('#clave').val(clave_);
			//
			var usuario_ = '';
			if($("#nro_documento").val() != ''){
				usuario_ = $("#nro_documento").val();
			} else if($("#apellido_pat").val() && $("#nombres").val()){
				usuario_ = $("#nombres").val().substr(0,1) + $("#apellido_pat").val();
			}
			$('#usuario').val(usuario_);
		});

		
		$("#btn-refresh-usuarios").click();
		
		
 
	} ,
	agregar_usuario : function(modalId_){
		$.when( Fn.validateForm({ id:"frm-usuarios" }) ).then(function(a){
			if( a===true ){
				var data={};
				data=Fn.formSerializeObject("frm-usuarios");
				var jsonString={ 'data':JSON.stringify(data), datetime: Global.dateTime };
				var url="gestion_usuarios/registrar_usuario";
				var config={ url:url,data:jsonString };
	
				$.when( Fn.ajax(config) ).then(function(b){
					if( b.result!=2 ){
						if( b.status==1 ){
							++modalId;
							var fn='Fn.showModal({ id:'+modalId+',show:false });Fn.showModal({ id:'+modalId_+',show:false });$("#btn-refresh-usuarios").click();';
							var btn=new Array();
							btn[0]={title:'Aceptar',fn:fn};
							//alert();
							Fn.showModal({ id:modalId,show:true,title:b.msg.title,content:b.msg.content,btn:btn});
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
	actualizar_usuario : function(modalId_){
		$.when( Fn.validateForm({ id:"frm-usuarios" }) ).then(function(a){
			if( a===true ){
				var data={};
				data=Fn.formSerializeObject("frm-usuarios");
				var jsonString={ 'data':JSON.stringify(data), datetime: Global.dateTime };
				var url="gestion_usuarios/actualizar_usuario";
				var config={ url:url,data:jsonString };
	
				$.when( Fn.ajax(config) ).then(function(b){
					if( b.result!=2 ){
						if( b.status==1 ){
							++modalId;
							var fn='Fn.showModal({ id:'+modalId+',show:false });Fn.showModal({ id:'+modalId_+',show:false });$("#btn-refresh-usuarios").click();';
							var btn=new Array();
							btn[0]={title:'Aceptar',fn:fn};
							Fn.showModal({ id:modalId,show:true,title:b.msg.title,content:b.msg.content,btn:btn, xlarge:true });
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
	actualizar_estado_usuario : function(modalId_,id,estado){
		var data={};
		data['id_usuario']=id;
		data['estado']=estado;
		var jsonString={ 'data':JSON.stringify(data), datetime: Global.dateTime };
		
		var url="gestion_usuarios/actualizar_estado_usuario";
		var config={ url:url,data:jsonString };

		$.when( Fn.ajax(config) ).then(function(b){
			if( b.result!=2 ){
				++modalId;
				var fn='Fn.showModal({ id:'+modalId+',show:false });Fn.showModal({ id:'+modalId_+',show:false });$("#btn-refresh-usuarios").click();';
				var btn=new Array();
				btn[0]={title:'Aceptar',fn:fn};
				Fn.showModal({ id:modalId,show:true,title:b.msg.title,content:b.msg.content,btn:btn });
			}
		});
	},

}
Gestion_usuarios.load();