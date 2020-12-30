var Recover={
	

	cerrar_modales: function($id){
		for (var i=0; i<=$id; i++) {
			Fn.showModal({ id:i,show:false })
		}

	},
	cambiar_clave_operario: function(){
		var data={'nuevaClave':$('#nuevaClave').val(),'nuevaClave2':$("#nuevaClave2").val()};
		var jsonString={'data':JSON.stringify(data)};
		var url="pedidosOP/cambiar_clave_operario";
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
		if(data.nuevaClave.length < 6){
			data.html = "La clave debe ser de al menos 6 caracteres";
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
						var fn1='Fn.showModal({ id:'+modalId+',show:false });Recover.cerrar_modales("'+modalId+'")';
					}else{
						var fn1='Fn.showModal({ id:'+modalId+',show:false })';

					}

				var btn=new Array();
				btn[0]={title:'Aceptar',fn:fn1};
				Fn.showModal({ id:modalId,show:true,title:'Cambiar Clave',content:a.data.message,btn:btn, large: false });
			}
		});


	},
	
	load: function(){


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
					var fn2='Recover.cambiar_clave_operario();';
					var btn=new Array();
					btn[0]={title:'Cancelar',fn:fn1};
					btn[1]={title:'Guardar',fn:fn2};
					Fn.showModal({ id:modalId,show:true,title:'Cambiar Clave',content:a.data.html,btn:btn, large: false });
				}
			});
		});
	

    }
}

Recover.load();