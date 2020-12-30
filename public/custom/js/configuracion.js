var Configuracion={
	cod_prov: "",
	id_ubigeo: "",
	new_metodos:{},

	eliminar_fila_temp: function($params){
		$('#metodo_temp'+$params.id).remove();
		$('#op'+$params.id).remove();
		console.log($params);
		$('#id_metodo_pag').append('<option value="'+$params.id+'" id="op'+$params.id+'" >'+$params.nombre+'</option>')
		delete Configuracion.new_metodos['new'+$params.id];
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
		var url="Configuracion/agregar_metodo_comercio";
		var config={ url:url,data:jsonString };

		if($id_metodo !=''){

			$.when( Fn.ajax(config) ).then(function(a){
				if( a.result!=2 ){
					if( a.result==1 ){
						$('#tabla_metodos_comercio').append(a.data.tabla)
						$('#op'+$id_metodo).remove();
						Configuracion.new_metodos['new'+$id_metodo] = $id_metodo;
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
		var url="Configuracion/eliminar_fila_pago_comercio";
		var config={ url:url,data:jsonString };

		$.when( Fn.ajax(config) ).then(function(a){
			if( a.result!=2 ){
				if( a.result==1 ){
					$('#tabla_metodos_comercio').empty();
					$('#tabla_metodos_comercio').append(a.data.html)
					++modalId;
					var fn1='Fn.showModal({ id:'+modalId+',show:false });Fn.loadPage("Configuracion")';
					var btn=new Array();
						btn[0]={title:'Aceptar',fn:fn1};
					Fn.showModal({ id:modalId,show:true,title:a.msg.title,content:a.msg.content,btn:btn });
				
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

	maps:function(){
		initialize();
		var geocoder;
		var map; 
		var markers=[];

		function setMapOnAll(map){
			for(var i=0; i<markers.length; i++){ markers[i].setMap(map); }
		}

		function clearMarkers(){
			setMapOnAll(null);
		}

		function openInfoWindow(marker){
			var markerLatLng=marker.getPosition();
			$('input[name=latitud]').val(markerLatLng.lat());
			$('input[name=longitud]').val(markerLatLng.lng());
		}

		function initialize(){
			var latitud=-10.453098189337464;
			var longitud=-76.04625830371094;
			var setZoom=5;

			if( $('input[name=latitud]').val().length>0 &&
				$('input[name=longitud]').val().length>0
			){
				latitud=$('input[name=latitud]').val();
				longitud=$('input[name=longitud]').val();
				setZoom=15;
			}

			geocoder=new google.maps.Geocoder();
			var latlng=new google.maps.LatLng(latitud, longitud);
			var mapOptions={ zoom: 20, center: latlng }

			map=new google.maps.Map(document.getElementById('map_canvas'), mapOptions);
			google.maps.event.addListenerOnce(map, 'idle', function(){
				var currentCenter=map.getCenter();
				google.maps.event.trigger(map, 'resize');
				map.setCenter(currentCenter);
				map.setZoom(setZoom);

				var marker=new google.maps.Marker({
					map: map,
					draggable: true,
					position: currentCenter
				});
				markers.push(marker);

				google.maps.event.addListener(marker, 'dragend', function(){ openInfoWindow(marker);codeLatLng(); });
				google.maps.event.addListener(marker, 'click', function(){ openInfoWindow(marker);codeLatLng(); });
			});
		}

		function codeLatLng() {
			var latitud=$('input[name=latitud]').val();
			var longitud=$('input[name=longitud]').val();

			var lat=parseFloat(latitud);
			var lng=parseFloat(longitud);

			var latlng=new google.maps.LatLng(lat, lng);

			geocoder.geocode({'latLng': latlng}, function(results, status){
				if( status == 'OK'){
					if( results[0] ){
						// if( $('#'+GestorBaseMadre.idFormEdit+' input[name=direccion]').val().length==0 )
						// 	$('#'+GestorBaseMadre.idFormEdit+' input[name=direccion]').val(results[0].formatted_address);
					}
				}
			});
		}

		this.codeAddress = function() {
			var departamento=$('select[name=departamento_local] option:selected').text();
			var provincia=$('select[name=provincia_local] option:selected').text();
			var distrito=$('select[name=distrito_local] option:selected').text();

			console.log(departamento);
			console.log(provincia);
			console.log(distrito);
			
			var direccion="";
			if($('#id_via_local').val()!="" && $('#via_local').val()!=""){
				direccion+=" "+ $('#id_via_local').val()+". "+$('#via_local').val();
			}

			if($('#id_zona_local').val()!="" && $('#zona_local').val()!=""){
				direccion+=" "+$('#id_zona_local').val()+". "+$('#zona_local').val();
			}

			if($('#km_local').val()!=""){
				direccion+=" Km. "+$('#km_local').val();
			}
			if($('#mza_local').val()!=""){
				direccion+=" Mza. "+$('#mza_local').val();
			}
			if($('#dep_local').val()!=""){
				direccion+=" Dep. "+$('#dep_local').val();
			}
			if($('#int_local').val()!=""){
				direccion+=" Int. "+$('#int_local').val();
			}
			if($('#lote_local').val()!=""){
				direccion+=" Lc. "+$('#lote_local').val();
			}
			if($('#num_local').val()!=""){
				direccion+=" Num. "+$('#num_local').val();
			}

 
			
			var buscar='Peru'+' '+departamento+' '+provincia+' '+distrito+' '+direccion;
				buscar=$.trim(buscar);
			 	buscar=buscar.replace(/ +(?= )/g,'');

			geocoder.geocode( {'address': buscar}, function(results,status){
				if( status == 'OK'){
					clearMarkers();

					var latitud=results[0].geometry.location.lat();
					var longitud=results[0].geometry.location.lng();

					var latlng=new google.maps.LatLng(latitud, longitud);
					var mapOptions={ zoom: 20, center: latlng }

					map=new google.maps.Map(document.getElementById('map_canvas'), mapOptions);
					google.maps.event.addListenerOnce(map, 'idle', function(){
						google.maps.event.trigger(map, 'resize');
						map.setCenter(results[0].geometry.location);
						map.setZoom(15);

						var marker=new google.maps.Marker({
							map: map,
							draggable: true,
							position: results[0].geometry.location
						});

						markers.push(marker);
						 $('input[name=latitud]').val(latitud);
						 $('input[name=longitud]').val(longitud);

						google.maps.event.addListener(marker, 'dragend', function(){ openInfoWindow(marker);codeLatLng(); });
						google.maps.event.addListener(marker, 'click', function(){ openInfoWindow(marker);codeLatLng(); });
					});
				}
			});
		}

	},
	load: function(){

		$("#btn-img-file").on("click",function(e){
			$("#img_logo").click();
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
		
		$('#img_logo').on('change',  function (evt) {
			var tgt = evt.target || window.event.srcElement,
			files = tgt.files;
			if (FileReader && files && files.length) {
				var fr = new FileReader();
				fr.onload = function () {
					$('#img_logo_1').attr("src",fr.result);	
					$('#img_logo_1').attr("data-estado","1");					
				}
				fr.readAsDataURL(files[0]);
				if(files[0].name!=null){
					console.log(files[0]);
					
					$('#text-img_1').val(files[0].name);
					$('#text-img_1').attr('title',files[0].name);
					$('#logo_name').val(files[0].name);
					
				}
			} 
		});


		$("#btn-img-terminos").on("click",function(e){
			$("#file_terminos").click();
		});
		
		$("#btn-img-terminos-del").on("click",function(e){
			$('#img_terminos').attr("value","");	
			$('#text-img-terminos').val("");
			$('#text-img-terminos').attr("");
		});
		$('#file_terminos').on('change',  function (evt) {
			var tgt = evt.target || window.event.srcElement,
			files = tgt.files;
			if (FileReader && files && files.length) {
				var fr = new FileReader();
				fr.onload = function () {
					$('#img_terminos').attr("value",fr.result);	
				}
				fr.readAsDataURL(files[0]);
				if(files[0].name!=null){
					$('#text-img-terminos').val(files[0].name);
					$('#text-img-terminos').attr('title',files[0].name);
				}
			} 
		});



		$(document).on('click','.btn-img-articulo',function(evt){
			var id_art=$(this).attr('data-id');
			$("#file_articulo_"+id_art).click();
		});
		$(document).on('change','.file_articulo',function(evt){
			var id_art=$(this).attr('data-id');
			console.log(id_art);

			var tgt = evt.target || window.event.srcElement,
			files = tgt.files;
			console.log(files);
			console.log(files.length);
			
			if (FileReader && files && files.length) {
				var fr = new FileReader();
				fr.onload = function () {
					$('#img_articulo_'+id_art).attr("src",fr.result);	
					$('#img_articulo_'+id_art).attr("data-estado","1");					
				}
				fr.readAsDataURL(files[0]);
				if(files[0].name!=null){
					$('#text-img-articulo_0').val(files[0].name);
					$('#text-img-articulo_0').attr('title',files[0].name);
				}
			} 
		});

		Configuracion.maps();
		

		$('#horario_atencion').daterangepicker({
            timePicker: true,
            timePicker24Hour: true,
            timePickerIncrement: 1,
            timePickerSeconds: true,
            locale: {
                format: 'HH:mm:ss'
            }
        }).on('show.daterangepicker', function (ev, picker) {
            picker.container.find(".calendar-table").hide();
		});
		
		


		$('#tb-punto-venta-hist').DataTable({
			sScrollY: "200px",
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
				 
				]
			}
		});

		$(document).on('click','#btn-update-mensaje',function(e){
			$.when( Fn.validateForm({ id:"frm-mensajes" }) ).then(function(a){
				if( a===true ){
					var data={};
					data=Fn.formSerializeObject("frm-mensajes");
					var jsonString={ 'data':JSON.stringify(data), datetime: Global.dateTime };
					
					var url="configuracion/actualizar_mensaje";
					var config={ url:url,data:jsonString };
		
					$.when( Fn.ajax(config) ).then(function(b){
						if( b.result!=2 ){
							Fn.showModal({ id:modalId,show:false });
							++modalId;
							var fn='Fn.showModal({ id:'+modalId+',show:false });$("#btn-conf-mensaje").click();';
							var btn=new Array();
							btn[0]={title:'Aceptar',fn:fn};
							Fn.showModal({ id:modalId,show:true,title:b.msg.title,content:b.msg.content,btn:btn });
						}
					});
				}
			});
		});

	 
		
		$("#btn-update").on("click",function(e){
			$.when( Fn.validateForm({ id:"frm-update-comercio" }) ).then(function(a){
				if( a===true ){
					var data={};
					data=Fn.formSerializeObject("frm-update-comercio");
					if($('#img_logo_1').attr("data-estado")=="1"){
						data['img_logo']=$('#img_logo_1').prop("src");
					}
					let ite = 0;
					$.each(  Configuracion.new_metodos, function( key, value ) {
						data['row_method'+ite] = value;
						data['numero'+ite] = $('#new_numero'+value).val();
						ite++;
					  });
					console.log(data); 
					  data['cant_for'] = ite;
					var jsonString={ 'data':JSON.stringify(data), datetime: Global.dateTime };
					

					
					// console.log(data); return false;
					var url="configuracion/actualizar_comercio";
					var config={ url:url,data:jsonString };
		
					$.when( Fn.ajax(config) ).then(function(b){
						if( b.result!=2 ){
							++modalId;
							var fn='Fn.showModal({ id:'+modalId+',show:false });Fn.loadPage("Configuracion")';
							var btn=new Array();
							btn[0]={title:'Aceptar',fn:fn};
							Fn.showModal({ id:modalId,show:true,title:b.msg.title,content:b.msg.content,btn:btn });
						}
					});
				}
			});
		});


		$("#btn-historial-creditos").on("click",function(e){
			var data={};
			var jsonString={'data':JSON.stringify(data)};
			var url="configuracion/historial_creditos";
			var config={ url:url,data:jsonString };

			$.when( Fn.ajax(config) ).then(function(a){
					++modalId;
					var fn1='Fn.showModal({ id:'+modalId+',show:false });';
					var btn=new Array();
						btn[0]={title:'Salir',fn:fn1};
					Fn.showModal({ id:modalId,show:true,title:'Historial Creditos',content:a.data.html,btn:btn, large: true });
					var table=$('#tb-creditos-hist').DataTable({
						sScrollY: "150px",
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
								{ extend: 'excel', className: 'btn btn-danger', title: 'historial_creditos', text: 'Exportar <i class="fa fa-file-excel-o"></i>',exportOptions: {
							columns: 'th:not(:nth-child(1))'
						 } }
							]
						}
					});
					setTimeout(function(){ table.columns.adjust().draw() }, 500);
			});
		});

 

		$("#btn-conf-mensaje").on("click",function(e){
			var data={};
			var jsonString={'data':JSON.stringify(data)};
			var url="configuracion/configuracion_mensajes";
			var config={ url:url,data:jsonString };

			$.when( Fn.ajax(config) ).then(function(a){
					++modalId;
					var fn1='Fn.showModal({ id:'+modalId+',show:false });';
					//var fn2='Configuracion.actualizar_mensajes('+modalId+');';
					var btn=new Array();
						btn[0]={title:'Salir',fn:fn1};
						//btn[1]={title:'Cancelar',fn:fn1};
						//btn[1]={title:'Actualizar',fn:fn2};
					Fn.showModal({ id:modalId,show:true,title:'Configuración De Mensajes',content:a.data.html,btn:btn, large: true });
					var table=$('#tb-mensajes-hist').DataTable({
						sScrollY: "200px",
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
							
							]
						}
						});
					setTimeout(function(){ table.columns.adjust().draw() }, 500);
			});
		});

		$(document).on('click','#btn-add-mensaje',function(e){
			$.when( Fn.validateForm({ id:"frm-mensajes" }) ).then(function(a){
				if( a===true ){
					var data={};
					data=Fn.formSerializeObject("frm-mensajes");
					var jsonString={ 'data':JSON.stringify(data), datetime: Global.dateTime };
					
					var url="configuracion/agregar_mensaje";
					var config={ url:url,data:jsonString };
		
					$.when( Fn.ajax(config) ).then(function(b){
						if( b.result!=2 ){
							Fn.showModal({ id:modalId,show:false });
							++modalId;
							var fn='Fn.showModal({ id:'+modalId+',show:false });$("#btn-conf-mensaje").click();';
							var btn=new Array();
							btn[0]={title:'Aceptar',fn:fn};
							Fn.showModal({ id:modalId,show:true,title:b.msg.title,content:b.msg.content,btn:btn });
						}
					});
				}
			});
		});

		$(document).on('click','#btn-add-medio',function(e){
			$.when( Fn.validateForm({ id:"frm-medio-envio" }) ).then(function(a){
				if( a===true ){
					var data={};
					data=Fn.formSerializeObject("frm-medio-envio");
					var jsonString={ 'data':JSON.stringify(data), datetime: Global.dateTime };
					
					var url="configuracion/agregar_medio_envio";
					var config={ url:url,data:jsonString };
		
					$.when( Fn.ajax(config) ).then(function(b){
						if( b.result!=2 ){
							++modalId;
							var fn='Fn.showModal({ id:'+modalId+',show:false });Configuracion.cargar_list_medio_envio();$("#btn-cancel-medio").click();';
							var btn=new Array();
							btn[0]={title:'Aceptar',fn:fn};
							Fn.showModal({ id:modalId,show:true,title:b.msg.title,content:b.msg.content,btn:btn });
						}
					});
				}
			});
		});

		
		$(document).on('click','#btn-copy-link',function(e){
			var aux = document.createElement("input");
			var cont=$('#link_comp').val();
			aux.setAttribute("value", cont);
			document.body.appendChild(aux);
			aux.select();
			document.execCommand("copy");
			document.body.removeChild(aux);
		
		});

		$(document).on('click','.btn-editar-mensaje',function(e){
			var data={};
			var id_mensaje=$(this).attr('data-id');
			data['id_mens']= id_mensaje;
			var jsonString={ 'data':JSON.stringify(data), datetime: Global.dateTime };
		
			var url="configuracion/editar_mensaje";
			var config={ url:url,data:jsonString };

			$.when( Fn.simpleAjax(config) ).then(function(b){
				if(b.data!=null){
					
					$('#id_mens').val(b.data['id_conf_mens']);
					$('#id_proceso_new').val(b.data['id_proceso']).change();
					$('#mensaje_new').val(b.data['mensaje']);
						
					$("#id_proceso_new").focus();

					$("#btn-add-mensaje").hide();
					$("#btn-update-mensaje").show();
					$("#btn-cancel-mensaje").show();
				}
			});
		});

		$(document).on('click','#btn-cancel-mensaje',function(e){
			$('#id_mens').val("");
			$('#id_proceso_new').val("");
			$('#mensaje_new').val("");
			$("#id_proceso_new").focus();

			$("#btn-add-mensaje").show();
			$("#btn-update-mensaje").hide();
			$("#btn-cancel-mensaje").hide();
		});

		


		$(document).on('click','.btn-editar-medio',function(e){
			var data={};
			var id_medio=$(this).attr('data-id');
			data['id_medio']= id_medio;

			var jsonString={ 'data':JSON.stringify(data), datetime: Global.dateTime };
		
			var url="configuracion/editar_medio_envio";
			var config={ url:url,data:jsonString };

			$.when( Fn.ajax(config) ).then(function(b){
				if(b.data!=null){
					$('#id_medio').val(b.data['id_medio_env']);

					$('#titulo').val(b.data['titulo']);
					$('#email_medio').val(b.data['email']);
					$('#telefono_medio').val(b.data['telefono']);

					if(b.data['id_medio_tipo']==1){
						$('#tipo_1').attr("checked","checked");
					}else if(b.data['id_medio_tipo']==2){
						$('#tipo_2').attr("checked","checked");
					}

					$('#id_empresa').val(b.data['id_empresa_del']);

					$("#empresa_medio").attr('disabled','');
					$("#empresa_medio").val("");
					$("#id_empresa").removeAttr('disabled');


					$("#titulo").focus();

					$("#btn-add-medio").hide();
					$("#btn-update-medio").show();
					$("#btn-cancel-medio").show();
				}
			});
			
		});

		$(document).on('click','#btn-cancel-medio',function(e){
			//$('#metodo_1').removeAttr("checked");
			//$('#metodo_2').removeAttr("checked");
			$('#titulo').val("");
			$('#email_medio').val("");
			$('#telefono_medio').val("");

			$('#tipo_1').removeAttr("checked");
			$('#tipo_2').removeAttr("checked");
			$('#id_empresa').val("");
			$('#empresa_medio').val("");
			$("#btn-add-medio").show();
			$("#btn-update-medio").hide();
			$("#btn-cancel-medio").hide();
		});

		$(document).on('click','#btn-update-medio',function(e){
			$.when( Fn.validateForm({ id:"frm-medio-envio" }) ).then(function(a){
				if( a===true ){
					var data={};
					data=Fn.formSerializeObject("frm-medio-envio");
					var jsonString={ 'data':JSON.stringify(data), datetime: Global.dateTime };
					
					var url="configuracion/actualizar_medio_envio";
					var config={ url:url,data:jsonString };
		
					$.when( Fn.ajax(config) ).then(function(b){
						if( b.result!=2 ){
							++modalId;
							var fn='Fn.showModal({ id:'+modalId+',show:false });Configuracion.cargar_list_medio_envio();$("#btn-cancel-medio").click();';
							var btn=new Array();
							btn[0]={title:'Aceptar',fn:fn};
							Fn.showModal({ id:modalId,show:true,title:b.msg.title,content:b.msg.content,btn:btn });
						}
					});
				}
			});
		});


		$(document).on('click','#btn-add-pdv',function(e){
			$.when( Fn.validateForm({ id:"frm-register-pdv" }) ).then(function(a){
				if( a===true ){
					var data={};
					data=Fn.formSerializeObject("frm-register-pdv");
					var jsonString={ 'data':JSON.stringify(data), datetime: Global.dateTime };
					
					var url="configuracion/agregar_pdv";
					var config={ url:url,data:jsonString };
		
					$.when( Fn.ajax(config) ).then(function(b){
						if( b.result!=2 ){
							++modalId;
							var fn='Fn.showModal({ id:'+modalId+',show:false });Configuracion.cargar_list_punto_venta();$("#btn-cancel-pdv").click();';
							var btn=new Array();
							btn[0]={title:'Aceptar',fn:fn};
							Fn.showModal({ id:modalId,show:true,title:b.msg.title,content:b.msg.content,btn:btn });
						}
					});
				}
			});
		});

		$(document).on('click','#btn-update-pdv',function(e){
			$.when( Fn.validateForm({ id:"frm-register-pdv" }) ).then(function(a){
				if( a===true ){
					var data={};
					data=Fn.formSerializeObject("frm-register-pdv");
					var jsonString={ 'data':JSON.stringify(data), datetime: Global.dateTime };
					
					var url="configuracion/actualizar_pdv";
					var config={ url:url,data:jsonString };
		
					$.when( Fn.ajax(config) ).then(function(b){
						if( b.result!=2 ){
							++modalId;
							var fn='Fn.showModal({ id:'+modalId+',show:false });Configuracion.cargar_list_punto_venta();';
							var btn=new Array();
							btn[0]={title:'Aceptar',fn:fn};
							Fn.showModal({ id:modalId,show:true,title:b.msg.title,content:b.msg.content,btn:btn });
							$('#btn-add-pdv').show();
							$('#btn-update-pdv').hide();
							$('#btn-cancel-pdv').hide();
							$("#btn-cancel-pdv").click();
						}
					});
				}
			});
		});

		



		$(document).on('change','#departamento_local',function(e){
			var data={};
			data['cod_dep']= $('#departamento_local').val();

			if($('#departamento_local').val()!=undefined){
				var jsonString={ 'data':JSON.stringify(data), datetime: Global.dateTime };
			
				var url="configuracion/obtener_provincias";
				var config={ url:url,data:jsonString };
	
				$.when( Fn.ajax(config) ).then(function(b){
					if(b.data!=null){
						var options="<option value='' > Provincia </option>";
						$.each( b.data, function( key, value ) {
							options+="<option value='"+value['cod_prov']+"' > "+value['provincia']+" </option>";
						});
						$('#provincia_local').find('option').remove();
						$('#provincia_local').append(options);

						if(Configuracion.cod_prov!="" && Configuracion.cod_prov!=null){
							$('#provincia_local').val(Configuracion.cod_prov).change();
						}
					}
				});
			}
			
		});

		$(document).on('change','#provincia_local',function(e){
			var data={};
			data['cod_prov']= $('#provincia_local').val();
			data['cod_dep']= $('#departamento_local').val();
			if($('#provincia_local').val()!=undefined){
				var jsonString={ 'data':JSON.stringify(data), datetime: Global.dateTime };
			
				var url="configuracion/obtener_distritos";
				var config={ url:url,data:jsonString };
	
				$.when( Fn.ajax(config) ).then(function(b){
					if(b.data!=null){
						var options="<option value='' > Distrito </option>";
						$.each( b.data, function( key, value ) {
							options+="<option value='"+value['id_ubigeo']+"' > "+value['distrito']+" </option>";
	
						});
						$('#distrito_local').find('option').remove();
						$('#distrito_local').append(options);

						if(Configuracion.id_ubigeo!=""){
							$('#distrito_local').val(Configuracion.id_ubigeo).change();
						}
					}
				});
			}
			
		});


		
		$(document).on('click','.btn-editar-pdv',function(e){
			var data={};
			var id_pdv=$(this).attr('data-id-pdv');
			data['id_pdv']= id_pdv;

				var jsonString={ 'data':JSON.stringify(data), datetime: Global.dateTime };
			
				var url="configuracion/editar_pdv";
				var config={ url:url,data:jsonString };
	
				$.when( Fn.ajax(config) ).then(function(b){
					if(b.data!=null){
						

						$('#id_pdv').val(b.data['id_pdv']);
						$('#latitud').val(b.data['latitud']);
						$('#longitud').val(b.data['longitud']);

						var numero_1="";
						var id_numero_1="";
						$.each( b.data['telefonos'], function( key, value ) {
							numero_1=value;
							id_numero_1=key;
							return false;
						});

						$('#id_telefono').val(id_numero_1);
						$('#telefono_local').val(numero_1);

						$('#nombre_local').val(b.data['nombre']);
						$('#email_local').val(b.data['email']);

						Configuracion.cod_prov=b.data['cod_prov'];
						Configuracion.id_ubigeo=b.data['id_ubigeo'];
						$('#departamento_local').val(b.data['cod_dep']).change();
						
						$('#dep_local').val(b.data['dep']);
						$('#int_local').val(b.data['int']);
						$('#km_local').val(b.data['km']);
						$('#lote_local').val(b.data['lt']);
						$('#mza_local').val(b.data['mza']);
						$('#num_local').val(b.data['num']);


						if(b.data['hora_ini']!=null && b.data['hora_fin']){
							$('#horario_atencion').val(b.data['hora_ini']+ " - "+ b.data['hora_fin']);
						}else{
							$('#horario_atencion').val("00:00:00 - 00:00:00");
						}
						

						
						$('#id_via_local').val(b.data['via_abr']).change();
						$('#via_local').val(b.data['via_cont']);

						$('#id_zona_local').val(b.data['zona_abr']).change();
						$('#zona_local').val(b.data['zona_cont']);

						$('#btn-add-pdv').hide();
						$('#btn-update-pdv').show();
						$('#btn-cancel-pdv').show();

						$("#nombre_local").focus();


						Configuracion.maps();

					}
				});
			
		});


		$(document).on('click','#btn-cancel-pdv',function(e){
			$('#id_pdv').val("");
			$('#latitud').val("");
			$('#longitud').val("");


			$('#nombre_local').val("");
			$('#email_local').val("");
			$('#telefono_local').val("");

			Configuracion.cod_prov="";
			Configuracion.id_ubigeo="";
			$('#departamento_local').val("").change();
			$('#provincia_local').val("").change();
			$('#distrito_local').val("");
			
			$('#dep_local').val("");
			$('#int_local').val("");
			$('#km_local').val("");
			$('#lote_local').val("");
			$('#mza_local').val("");
			$('#num_local').val("");
			

			$('#horario_atencion').val("00:00:00 - 00:00:00");

			$('#id_via_local').val("").change();
			$('#via_local').val("");

			$('#id_zona_local').val("").change();
			$('#zona_local').val("");


			$('#btn-add-pdv').show();
			$('#btn-update-pdv').hide();
			$('#btn-cancel-pdv').hide();

			Configuracion.maps();

			
		});


		$(document).on('click','.btn-zona-atencion',function(e){
			var data={};
			var id_pdv=$(this).attr('data-id-pdv');
			data['id_pdv']= id_pdv;

			var cod_dep=$(this).attr('data-cod-dep');
			data['cod_dep']= cod_dep;
			var cod_prov=$(this).attr('data-cod-prov');
			data['cod_prov']= cod_prov;

			var jsonString={'data':JSON.stringify(data)};
			var url="configuracion/editar_punto_venta_zonas";
			var config={ url:url,data:jsonString };

			$.when( Fn.ajax(config) ).then(function(a){
				if( a.status==1 ){
					++modalId;
					var fn1='Fn.showModal({ id:'+modalId+',show:false });';
					var fn2='Configuracion.actualizar_zonas('+modalId+');';
					var btn=new Array();
						btn[0]={title:'Salir',fn:fn1};
						btn[1]={title:'Actualizar',fn:fn2};
					Fn.showModal({ id:modalId,show:true,title:'Delivery - Costos',content:a.data.html,btn:btn, large: false });
				}else{
					++modalId;
					var fn1='Fn.showModal({ id:'+modalId+',show:false });';
					var btn=new Array();
						btn[0]={title:'Aceptar',fn:fn1};
					Fn.showModal({ id:modalId,show:true,title:'Delivery - Costos',content:a.data.html,btn:btn, large: true });
				}
			});
		});

		$(document).on('click','#btn-add-zona',function(e){
			$.when( Fn.validateForm({ id:"frm-zonas" }) ).then(function(a){
				if( a===true ){
					var data={};
					data=Fn.formSerializeObject("frm-zonas");
					var id_pdv=$('#id_pdv_zona').val();
					var jsonString={ 'data':JSON.stringify(data), datetime: Global.dateTime };
					
					var url="configuracion/agregar_punto_venta_zonas";
					var config={ url:url,data:jsonString };
		
					$.when( Fn.ajax(config) ).then(function(b){
						if( b.result!=2 ){
							Fn.showModal({ id:modalId,show:false });
							++modalId;
							
							var fn='Fn.showModal({ id:'+modalId+',show:false });$("#boton-zona-atencion-'+id_pdv+'").click();';
							var btn=new Array();
							btn[0]={title:'Aceptar',fn:fn};
							Fn.showModal({ id:modalId,show:true,title:b.msg.title,content:b.msg.content,btn:btn });
						}
					});
				}
			});
		});

		$(document).on('click','.btn-edit-articulo',function(e){
			var data={};
			var id_articulo=$(this).attr('data-id');
			data['id_articulo']= id_articulo;

				var jsonString={ 'data':JSON.stringify(data), datetime: Global.dateTime };
			
				var url="configuracion/editar_articulo";
				var config={ url:url,data:jsonString };
	
				$.when( Fn.ajax(config) ).then(function(b){
					if(b.data!=null){
						console.log(b.data);
						$('#id_articulo').val(b.data['id_articulo']);
						$('#nombre_articulo').val(b.data['nombre']);
						$('#precio_articulo').val(b.data['precio']);
						$('#observacion_articulo').val(b.data['observacion']);
						$('#costo_emp_articulo').val(b.data['costo_empaque']);

						if(b.data['ruta_imagen']!=null && b.data['ruta_imagen']!=undefined){
							$('#img_articulo_0').attr('src','../files/articulos/'+(b.data['ruta_imagen'])+".jpg");
						}else{
							$('#img_articulo_0').attr('src',"../public/assets/images/default-image.jpg");
						}
						$('#img_articulo_0').attr('data-estado',"0");
						$("#nombre_articulo").focus();

						$("#btn-add-articulo").hide();
						$("#btn-update-articulo").show();
						$("#btn-cancel-articulo").show();
						
					}
				});
		});

		$(document).on('click','#btn-cancel-articulo',function(e){
			$('#id_articulo').val("");
			$('#nombre_articulo').val("");
			$('#precio_articulo').val("");
			$('#observacion_articulo').val("");
			$('#costo_emp_articulo').val("");
 
			$('#img_articulo_0').attr('data-estado',"0");


			$("#btn-add-articulo").show();
			$("#btn-update-articulo").hide();
			$("#btn-cancel-articulo").hide();
			$('#img_articulo_0').attr('src',"../public/assets/images/default-image.jpg");
		});


		$(document).on('click','#btn-update-articulo',function(e){
			$.when( Fn.validateForm({ id:"frm-register-articulos" }) ).then(function(a){
				if( a===true ){
					var data={};
					data=Fn.formSerializeObject("frm-register-articulos");
					if($('#img_articulo_0').attr("data-estado")=="1"){
						data['img_articulo']=$('#img_articulo_0').prop("src");
					}
					var jsonString={ 'data':JSON.stringify(data), datetime: Global.dateTime };
					
					var url="configuracion/actualizar_articulo";
					var config={ url:url,data:jsonString };
		
					$("#nombre_articulo_bus").val("");
					$.when( Fn.ajax(config) ).then(function(b){
						if( b.result!=2 ){
							++modalId;
							var fn='Fn.showModal({ id:'+modalId+',show:false });$("#btn-refresh-articulos").click();$("#btn-cancel-articulo").click();';
							var btn=new Array();
							btn[0]={title:'Aceptar',fn:fn};
							Fn.showModal({ id:modalId,show:true,title:b.msg.title,content:b.msg.content,btn:btn });
						}
					});
				}
			});
		});

		
		$(document).on('click','#btn-update-metodos',function(e){
			var data={};
			data['metodo_1']=($('#metodo_1').prop('checked')==true) ? 1 :0 ;
			data['metodo_2']=($('#metodo_2').prop('checked')==true) ? 1 :0 ;
			console.log(data['metodo_1']);
			console.log(data['metodo_2']);
			
			var jsonString={ 'data':JSON.stringify(data), datetime: Global.dateTime };
			
			var url="configuracion/actualizar_comercio_metodos";
			var config={ url:url,data:jsonString };

			$.when( Fn.ajax(config) ).then(function(b){
				if( b.result!=2 ){
					++modalId;
					var fn='Fn.showModal({ id:'+modalId+',show:false });';
					var btn=new Array();
					btn[0]={title:'Aceptar',fn:fn};
					Fn.showModal({ id:modalId,show:true,title:b.msg.title,content:b.msg.content,btn:btn });
				}
			});
		});

		
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
			
			var url="configuracion/actualizar_visibilidad_articulo";
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

		$(document).on('click','.btn-remove-articulo',function(e){
			var id=$(this).attr('data-id');
			++modalId;
			var btn=new Array();
			var fn1='Configuracion.desactivar_articulo('+modalId+','+id+');';
			var fn2='Fn.showModal({ id:'+modalId+',show:false });';
			btn[0]={title:'Aceptar',fn:fn1};
			btn[1]={title:'Cancelar',fn:fn2};
			Fn.showModal({ id:modalId,show:true,title:"Desactivar Articulo",content:"Desea desactivar el articulo seleccionado?",btn:btn });
		});


		$(document).on('click','.btn-estado-cnf-mensaje-des',function(e){
			var id_articulo =$(this).attr('data-id');
			var estado =$(this).attr('data-estado');
			++modalId;
			var fn1='Fn.showModal({ id:'+modalId+',show:false });';
			var fn2='Configuracion.actualizar_estado_mensaje('+modalId+','+id_articulo+','+estado+');';
			var btn=new Array();
				btn[0]={title:'Cancelar',fn:fn1};
				btn[1]={title:'Aceptar',fn:fn2};
			Fn.showModal({ id:modalId,show:true,title:'Desactivar mensaje',content:"Desea desactivar el mensaje seleccionado?",btn:btn, large: true });
		});

		$(document).on('click','.btn-estado-cnf-mensaje-act',function(e){
			var id_usuario =$(this).attr('data-id');
			var estado =$(this).attr('data-estado');
			++modalId;
			var fn1='Fn.showModal({ id:'+modalId+',show:false });';
			var fn2='Configuracion.actualizar_estado_mensaje('+modalId+','+id_usuario+','+estado+');';
			var btn=new Array();
				btn[0]={title:'Cancelar',fn:fn1};
				btn[1]={title:'Aceptar',fn:fn2};
			Fn.showModal({ id:modalId,show:true,title:'Activar Mensaje',content:"Desea activar el mensaje seleccionado?",btn:btn, large: true });
		});

		$(document).on('click','.btn-estado-venta-zona-des',function(e){
			var id_articulo =$(this).attr('data-id');
			var estado =$(this).attr('data-estado');
			++modalId;
			var fn1='Fn.showModal({ id:'+modalId+',show:false });';
			var fn2='Configuracion.actualizar_estado_venta_zona('+modalId+','+id_articulo+','+estado+');';
			var btn=new Array();
				btn[0]={title:'Cancelar',fn:fn1};
				btn[1]={title:'Aceptar',fn:fn2};
			Fn.showModal({ id:modalId,show:true,title:'Desactivar Costo por delivery',content:"Desea desactivar el Costo por delivery seleccionado?",btn:btn, large: true });
		});

		$(document).on('click','.tn-estado-venta-zona-act',function(e){
			var id_usuario =$(this).attr('data-id');
			var estado =$(this).attr('data-estado');
			++modalId;
			var fn1='Fn.showModal({ id:'+modalId+',show:false });';
			var fn2='Configuracion.actualizar_estado_venta_zona('+modalId+','+id_usuario+','+estado+');';
			var btn=new Array();
				btn[0]={title:'Cancelar',fn:fn1};
				btn[1]={title:'Aceptar',fn:fn2};
			Fn.showModal({ id:modalId,show:true,title:'Activar Costo por delivery',content:"Desea activar el Costo por delivery seleccionado?",btn:btn, large: true });
		});

		$(document).on('click','.btn-estado-medio-des',function(e){
			var id_medio =$(this).attr('data-id');
			var estado =$(this).attr('data-estado');
			++modalId;
			var fn1='Fn.showModal({ id:'+modalId+',show:false });';
			var fn2='Configuracion.actualizar_estado_medio_envio('+modalId+','+id_medio+','+estado+');';
			var btn=new Array();
				btn[0]={title:'Cancelar',fn:fn1};
				btn[1]={title:'Aceptar',fn:fn2};
			Fn.showModal({ id:modalId,show:true,title:'Desactivar Medio de Envio',content:"Desea desactivar el Medio de Envio seleccionado?",btn:btn, large: true });
		});

		$(document).on('click','.btn-estado-medio-act',function(e){
			var id_medio =$(this).attr('data-id');
			var estado =$(this).attr('data-estado');
			++modalId;
			var fn1='Fn.showModal({ id:'+modalId+',show:false });';
			var fn2='Configuracion.actualizar_estado_medio_envio('+modalId+','+id_medio+','+estado+');';
			var btn=new Array();
				btn[0]={title:'Cancelar',fn:fn1};
				btn[1]={title:'Aceptar',fn:fn2};
			Fn.showModal({ id:modalId,show:true,title:'Activar Medio de Envio',content:"Desea activar el Medio de Envio seleccionado?",btn:btn, large: true });
		});


		$(document).on('click','.btn-estado-punto-venta-des',function(e){
			var id_medio =$(this).attr('data-id');
			var estado =$(this).attr('data-estado');
			++modalId;
			var fn1='Fn.showModal({ id:'+modalId+',show:false });';
			var fn2='Configuracion.actualizar_estado_punto_venta('+modalId+','+id_medio+','+estado+');';
			var btn=new Array();
				btn[0]={title:'Cancelar',fn:fn1};
				btn[1]={title:'Aceptar',fn:fn2};
			Fn.showModal({ id:modalId,show:true,title:'Desactivar Punto de Venta',content:"Desea desactivar el Punto de Venta seleccionado?",btn:btn, large: true });
		});

		$(document).on('click','.btn-estado-punto-venta-act',function(e){
			var id_medio =$(this).attr('data-id');
			var estado =$(this).attr('data-estado');
			++modalId;
			var fn1='Fn.showModal({ id:'+modalId+',show:false });';
			var fn2='Configuracion.actualizar_estado_punto_venta('+modalId+','+id_medio+','+estado+');';
			var btn=new Array();
				btn[0]={title:'Cancelar',fn:fn1};
				btn[1]={title:'Aceptar',fn:fn2};
			Fn.showModal({ id:modalId,show:true,title:'Activar Punto de Venta',content:"Desea activar el Punto de Venta seleccionado?",btn:btn, large: true });
		});

		$(document).on('click','#btn-add-articulo',function(e){
			$.when( Fn.validateForm({ id:"frm-register-articulos" }) ).then(function(a){
				if( a===true ){
					var data={};
					data=Fn.formSerializeObject("frm-register-articulos");
					if($('#img_articulo_0').attr("data-estado")=="1"){
						data['img_articulo']=$('#img_articulo_0').prop("src");
					}
					var jsonString={ 'data':JSON.stringify(data), datetime: Global.dateTime };
					
					var url="configuracion/agregar_articulo";
					var config={ url:url,data:jsonString };
					$("#nombre_articulo_bus").val("");
					$.when( Fn.ajax(config) ).then(function(b){
						if( b.result!=2 ){
							Fn.showModal({ id:modalId,show:false });
							++modalId;
							
							var fn='Fn.showModal({ id:'+modalId+',show:false });$("#btn-refresh-articulos").click();$("#btn-cancel-articulo").click();';
							var btn=new Array();
							btn[0]={title:'Aceptar',fn:fn};
							Fn.showModal({ id:modalId,show:true,title:b.msg.title,content:b.msg.content,btn:btn });
							
						}
					});
				}
			});
			var $this = $(this);
			$this.val('Please wait..');
			$this.prop('disabled', true);
				setTimeout(function() { 
					$this.prop('disabled', false);
					// $this.disabled = false;
					$this.val('Actualizar');
					$("#btn-refresh-wait").attr("hidden","hidden");
			}, 4000);
		});

		$("#otraEmpresa").on("click",function(e){
			var estado=$(this).prop('checked');
			if(!estado){
				$("#empresa_medio").attr('disabled','');
				$("#empresa_medio").val("");
				$("#id_empresa").removeAttr('disabled');
				$("#id_empresa").val("");
			}else{
				$("#id_empresa").attr('disabled','');
				$("#id_empresa").val("");
				$("#empresa_medio").removeAttr('disabled');
				$("#empresa_medio").val("");
			}
		});

		$( document ).ready(function() {
			var id_comercio=$('#id_comercio').val();
			var conf=$('#configurado').val();
			
			if(conf!=1 && id_comercio!=""){
				var data={};
				data['id_comercio']=id_comercio;
				var jsonString={ 'data':JSON.stringify(data), datetime: Global.dateTime };
				var url="configuracion/actualizar_comercio_configuracion";
				var config={ url:url,data:jsonString };
				Fn.simpleAjax(config);
					
			}			
		});	
	
		$(document).on('click','.btn-cnf-cmd',function(e){
			e.preventDefault();
			$('#mensaje_new').focus();
			var cmd=$(this).attr('data-cmd');
			var pos = $('#mensaje_new').prop("selectionStart");
			var text= $('#mensaje_new').val();
			var out = text.substring(0, pos) +" "+ cmd+" " +text.substring(pos);
			$('#mensaje_new').val(out);
		});
		
		$("#btn-refresh-articulos").on("click",function(e){
			e.preventDefault();
			//
			var data={'nombres':$("#nombre_articulo_bus").val()};
			var jsonString={ 'data':JSON.stringify(data) };
			var url="configuracion/obtener_articulos";
			var config={ url:url,data:jsonString };

			$.when( Fn.ajax(config) ).then(function(a){
				if (a.result == 1) {
					$('#content-table-articulo').html(a.data.html1);
				}
			});
		});

		$(document).on('change','#metodo_1',function(e){
			var estado=$('#metodo_1').prop('checked');
			console.log(estado);
			if(estado){
				$('#row_medios_envio').show();
			}else{
				$('#row_medios_envio').hide();
			}
		});

		
		

		$("#btn-refresh-articulos").click();

		Configuracion.cargar_list_medio_envio();
		Configuracion.cargar_list_punto_venta();
		

	},
	
	actualizar_mensajes : function(modalId_){
		$.when( Fn.validateForm({ id:"frm-mensajes" }) ).then(function(a){
			if( a===true ){
				var data={};
				data=Fn.formSerializeObject("frm-mensajes");
				var jsonString={ 'data':JSON.stringify(data), datetime: Global.dateTime };
				
				var url="configuracion/actualizar_mensaje";
				var config={ url:url,data:jsonString };
	
				$.when( Fn.ajax(config) ).then(function(b){
					if( b.result!=2 ){
						++modalId;
						var fn='Fn.showModal({ id:'+modalId+',show:false });Fn.showModal({ id:'+modalId_+',show:false });$("#btn-conf-mensaje").click();';
						var btn=new Array();
						btn[0]={title:'Aceptar',fn:fn};
						Fn.showModal({ id:modalId,show:true,title:b.msg.title,content:b.msg.content,btn:btn });
					}
				});
			}
		});
	},
	
	actualizar_zonas : function(modalId_){
		$.when( Fn.validateForm({ id:"frm-zonas" }) ).then(function(a){
			if( a===true ){
				var data={};
				data=Fn.formSerializeObject("frm-zonas");
				var jsonString={ 'data':JSON.stringify(data), datetime: Global.dateTime };
				var id_pdv=$('#id_pdv_zona').val();
				var url="configuracion/actualizar_punto_venta_zonas";
				var config={ url:url,data:jsonString };
	
				$.when( Fn.ajax(config) ).then(function(b){
					if( b.result!=2 ){
						++modalId;
						var fn='Fn.showModal({ id:'+modalId+',show:false });Fn.showModal({ id:'+modalId_+',show:false });$("#boton-zona-atencion-'+id_pdv+'").click();';
						var btn=new Array();
						btn[0]={title:'Aceptar',fn:fn};
						Fn.showModal({ id:modalId,show:true,title:b.msg.title,content:b.msg.content,btn:btn });
					}
				});
			}
		});
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
	
	actualizar_estado_mensaje : function(modalId_,id,estado){
		var data={};
		data['id_mensaje']=id;
		data['estado']=estado;
		var jsonString={ 'data':JSON.stringify(data), datetime: Global.dateTime };
		
		var url="configuracion/actualizar_estado_mensaje";
		
		var config={ url:url,data:jsonString };

		$.when( Fn.ajax(config) ).then(function(b){
			if( b.result!=2 ){
				++modalId;
				var fn='Fn.showModal({ id:'+modalId+',show:false });Fn.showModal({ id:'+modalId_+',show:false });Fn.showModal({ id:'+(--modalId_)+',show:false });$("#btn-conf-mensaje").click();';
				var btn=new Array();
				btn[0]={title:'Aceptar',fn:fn};
				Fn.showModal({ id:modalId,show:true,title:b.msg.title,content:b.msg.content,btn:btn });
			}
		});
	},
	actualizar_estado_venta_zona : function(modalId_,id,estado){
		var data={};
		data['id_venta_zona']=id;
		data['estado']=estado;
		var jsonString={ 'data':JSON.stringify(data), datetime: Global.dateTime };
		var id_pdv_zona=$('#id_pdv_zona').val();
		var url="configuracion/actualizar_estado_venta_zona";
		
		var config={ url:url,data:jsonString };

		$.when( Fn.ajax(config) ).then(function(b){
			if( b.result!=2 ){
				++modalId;
				var fn='Fn.showModal({ id:'+modalId+',show:false });Fn.showModal({ id:'+modalId_+',show:false });Fn.showModal({ id:'+(--modalId_)+',show:false });$("#boton-zona-atencion-'+id_pdv_zona+'").click();';
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
		
		var url="configuracion/ocultar_articulos";
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
	actualizar_estado_medio_envio : function(modalId_,id,estado){
		var data={};
		data['id_medio']=id;
		data['estado']=estado;
		var jsonString={ 'data':JSON.stringify(data), datetime: Global.dateTime };
		
		var url="configuracion/actualizar_estado_medio_envio";
		
		var config={ url:url,data:jsonString };

		$.when( Fn.ajax(config) ).then(function(b){
			if( b.result!=2 ){
				++modalId;
				var fn='Fn.showModal({ id:'+modalId+',show:false });Fn.showModal({ id:'+modalId_+',show:false });Fn.showModal({ id:'+(--modalId_)+',show:false });Configuracion.cargar_list_medio_envio();';
				var btn=new Array();
				btn[0]={title:'Aceptar',fn:fn};
				Fn.showModal({ id:modalId,show:true,title:b.msg.title,content:b.msg.content,btn:btn });
			}
		});
	},
	
	actualizar_estado_punto_venta : function(modalId_,id,estado){
		var data={};
		data['id_pdv']=id;
		data['estado']=estado;
		var jsonString={ 'data':JSON.stringify(data), datetime: Global.dateTime };
		
		var url="configuracion/actualizar_estado_punto_venta";
		
		var config={ url:url,data:jsonString };

		$.when( Fn.ajax(config) ).then(function(b){
			if( b.result!=2 ){
				++modalId;
				var fn='Fn.showModal({ id:'+modalId+',show:false });Fn.showModal({ id:'+modalId_+',show:false });Fn.showModal({ id:'+(--modalId_)+',show:false });Configuracion.cargar_list_punto_venta();';
				var btn=new Array();
				btn[0]={title:'Aceptar',fn:fn};
				Fn.showModal({ id:modalId,show:true,title:b.msg.title,content:b.msg.content,btn:btn });
			}
		});
	},
	cargar_list_medio_envio : function(){
		var data={};
		var jsonString={ 'data':JSON.stringify(data) };
		var url="configuracion/obtener_medios_envio";
		var config={ url:url,data:jsonString };

		$.when( Fn.ajax(config) ).then(function(a){
			if (a.result == 1) {
				$('#content-table-medio-envio').html(a.data.html1);
				$('#tb-medio-hist').DataTable({
					sScrollY: "220px",
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
						 
						]
					}
				});
			}
		});
	},
	cargar_list_punto_venta : function(){
		var data={};
		var jsonString={ 'data':JSON.stringify(data) };
		var url="configuracion/obtener_puntos_venta";
		var config={ url:url,data:jsonString };

		$.when( Fn.ajax(config) ).then(function(a){
			if (a.result == 1) {
				$('#content-table-pdv').html(a.data.html1);
				$('#tb-punto-venta-hist').DataTable({
					sScrollY: "220px",
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
						 
						]
					}
				});
			}
		});
	},

}
Configuracion.load();