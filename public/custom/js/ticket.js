var Ticket = {

	load: function(){
		
		$("#full-data").on("click",function(e){
			if($(this).is(':checked')){
				$(".content-more").removeClass( "hide" );
				$(".content-more").show( "slow" );
			} else {
				$(".content-more").addClass( "hide" );
				$(".content-more").hide( "slow" );
				
			}
			
		});
		
		$("#numero_doc").on("change", function() {
			var tipo = $("#tipo_doc").val();
			var numero = $(this).val();
			if( tipo == 1 && numero.length > 0 ){
				var url = 'ticket/get_dni/' + numero;
				$.when( Fn.ajax({ 'url': url }) ).then(function(a){
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
		
		$("#btn-meavisan").on("click", function() {
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
								var fn='Fn.showModal({ id:'+modalId+',show:false });Fn.loadExternal("https://turno.com.pe/promociones-y-descuentos/");';
							} else var fn='Fn.showModal({ id:'+modalId+',show:false })';

							var btn=new Array();
							btn[0]={title:'Aceptar',fn:fn};
							Fn.showModal({ id:modalId,show:true,title:b.msg.title,content:b.msg.content,btn:btn });
						}
					});
					
				}
			});
		});
		
	}
}
Ticket.load();