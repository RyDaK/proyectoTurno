var Configuracion={
	new_metodos:{},

	eliminarOption:function($id){
		$('#op'+$id).remove();
	},

	load: function(){
		
		$(document).on('click','#btn-hide-all-articulos',function(e){
			var id=$('#id_comercio').val();
			++modalId;
			var btn=new Array();
			var fn1='Configuracion.ocultar_articulos('+modalId+','+id+');';
			var fn2='Fn.showModal({ id:'+modalId+',show:false });';
			btn[0]={title:'Aceptar',fn:fn1};
			btn[1]={title:'Cancelar',fn:fn2};
			Fn.showModal({ id:modalId,show:true,title:"Ocultar Articulos",content:"Desea ocultar todos los articulos?",btn:btn });
		});

		$(document).on('click','.btn-change-vis-articulo',function(e){
			var data={};
			data['id_articulo']=$(this).attr('data-id');
			data['visible']=$(this).attr('data-vis');
			var jsonString={ 'data':JSON.stringify(data), datetime: Global.dateTime };
			
			var url="carta/actualizar_visibilidad_articulo";
			var config={ url:url,data:jsonString };

			$.when( Fn.ajax(config) ).then(function(b){
				if( b.result!=2 ){
					++modalId;
					var fn='Fn.showModal({ id:'+modalId+',show:false });$("#btn-refresh-articulos").click();';
					var btn=new Array();
					btn[0]={title:'Aceptar',fn:fn};
					Fn.showModal({ id:modalId,show:true,title:b.msg.title,content:b.msg.content,btn:btn });
				}
			});
		});
		
		$("#btn-refresh-articulos").on("click",function(e){
			e.preventDefault();
			//
			var data={'nombres':$("#nombre_articulo_bus").val()};
			var jsonString={ 'data':JSON.stringify(data) };
			var url="carta/obtener_articulos";
			var config={ url:url,data:jsonString };

			$.when( Fn.ajax(config) ).then(function(a){
				if (a.result == 1) {
					$('#content-table-articulo').html(a.data.html1);
				}
			});
		});

		//$("#btn-refresh-articulos").click();

	},
	

	desactivar_articulo : function(modalId_,id){
		var data={};
		data['id_articulo']=id;
		var jsonString={ 'data':JSON.stringify(data), datetime: Global.dateTime };
		
		var url="configuracion/desactivar_articulo";
		var config={ url:url,data:jsonString };

		$.when( Fn.ajax(config) ).then(function(b){
			if( b.result!=2 ){
				++modalId;
				var fn='Fn.showModal({ id:'+modalId+',show:false });Fn.showModal({ id:'+modalId_+',show:false });$("#btn-refresh-articulos").click();';
				var btn=new Array();
				btn[0]={title:'Aceptar',fn:fn};
				Fn.showModal({ id:modalId,show:true,title:b.msg.title,content:b.msg.content,btn:btn });
			}
		});
	},
	
	ocultar_articulos : function(modalId_,id){
		var data={};
		data['id_comercio']=id
		var jsonString={ 'data':JSON.stringify(data), datetime: Global.dateTime };
		
		var url="carta/ocultar_articulos";
		var config={ url:url,data:jsonString };

		$.when( Fn.ajax(config) ).then(function(b){
			if( b.result!=2 ){
				++modalId;
				var fn='Fn.showModal({ id:'+modalId+',show:false });Fn.showModal({ id:'+modalId_+',show:false });$("#btn-refresh-articulos").click();';
				var btn=new Array();
				btn[0]={title:'Aceptar',fn:fn};
				Fn.showModal({ id:modalId,show:true,title:b.msg.title,content:b.msg.content,btn:btn });
			}
		});
	},
	
	
}
Configuracion.load();