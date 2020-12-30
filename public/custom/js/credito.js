var Credito={
	
	num_pedidos: 0,
	enproceso: 0,
	
	load: function(){
		
		$("#btn-refresh-liq").on("click",function(e){
			e.preventDefault();
			//
			var data={'fechas':$("#txt-fechas").val(), 'id_comercio' :  $("#comercio").val(), 'id_pdv' :  $("#pdv").val()};
			var jsonString={ 'data':JSON.stringify(data) };
			var url="credito/rpt_liquidacion";
			var config={ url:url,data:jsonString };

			$.when( Fn.ajax(config) ).then(function(a){
				if (a.result == 1) {
					$('#content-boxes').html(a.data.html1);
					$('#content-table').html(a.data.html2);
					$('#tb-list').DataTable({
						"ordering": false,
						buttons: {
							buttons: [
								{ extend: 'excel', className: 'btn btn-danger', title: 'credito_delivery', text: 'Exportar <i class="fa fa-file-excel-o"></i>'}
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
			var url="credito/table_liquidacion";
			var config={ url:url,data:jsonString };

			$.when( Fn.ajax(config) ).then(function(a){
				if (a.result == 1) {
					//$('#content-boxes').html(a.data.html1);
					$('#content-table').html(a.data.html2);
					$('#tb-list').DataTable({
						"columnDefs": [ {
							"targets": 0,
							"orderable": false
						} ],
						buttons: {
							buttons: [
								{ extend: 'excel', className: 'btn btn-danger', title: 'pedidos_pendientes', text: 'Exportar <i class="fa fa-file-excel-o"></i>'}
							]
						}
					});
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
		 
		$("#btn-refresh-liq").click();
	}

}
Credito.load();