$.extend({
	isNull: function(val){
		if( typeof val=='undefined' ) return true;
		//else if( val.length==0) return true;
		else return false
	},

	replaceAll: function(string,target,replacement){
		return string.split(target).join(replacement);
	}
});

$.ajaxSetup({
	type: "POST",
	global: false,
	cache: false,
	timeout: 1*800*1000,/*1 minuto*/
});

var site_name='Turno';
var site_url=$('base').attr('site_url');
var modalId=0;
var global_masivo = [];

var View={

	go_print: function(page, id){
		var data={};
		data['id']=id;

		var jsonString={ 'data':JSON.stringify(data) };
		var url='Print_page/'+page;
		var config={ url:url,data:jsonString };

		$.when( Fn.ajax(config) ).then(function(a){
			Global.print(a.data);
		});
	},
	
	load: function(){

        if( typeof($BODY)!='undefined' ) $BODY.toggleClass('nav-md nav-sm');

		$(".arrowLogo").removeClass("arrowLogoHorizontal");
		$(".arrowLogo").addClass("arrowLogoVertical");
		$(".arrowLogo").attr("src","images/visual-logo-vertical.png");
		
		$(document).on('show.bs.modal','.modal',function(e){
            var zIndex = 1040+(10*$('.modal:visible').length);
            $(this).css('z-index',zIndex);
            setTimeout(function(){
                $('.modal-backdrop').not('.modal-stack').css('z-index',zIndex-1).addClass('modal-stack');
            },0);
        });
		
		$(document).on('click','.btn-go-section',function(e){
           var id = $(this).attr("data-section");
		   $('html,body').animate({ scrollTop: $("#"+id).offset().top - 80 }, 1000);
        });
		
		
		$(document).on('click','#btn-print-produccion',function(e){
			e.preventDefault();
			
			//
			var pedidos = ['prueba'];
		
			if(pedidos.length > 0){
				var id= $(this).attr('data-id');
				var page = "print_delivery_produccion";
				View.go_print(page, id);
			} else {
				++modalId;
				var fn='Fn.showModal({ id:'+modalId+',show:false });';
				var btn=new Array();
				btn[0]={title:'Aceptar',fn:fn};
				Fn.showModal({ id:modalId,show:true,title:"Pedidos",content:'<i class="fa fa-info-circle" ></i> Debe seleccionar un pedido para continuar.',btn:btn });
			}
		});

		$(document).on('click','#btn-print-despacho',function(e){
			e.preventDefault();
			
			//
			var pedidos = ['prueba'];
		
			if(pedidos.length > 0){
				var id= $(this).attr('data-id');
				var page = "print_delivery_despacho";
				View.go_print(page, id);
			} else {
				++modalId;
				var fn='Fn.showModal({ id:'+modalId+',show:false });';
				var btn=new Array();
				btn[0]={title:'Aceptar',fn:fn};
				Fn.showModal({ id:modalId,show:true,title:"Pedidos",content:'<i class="fa fa-info-circle" ></i> Debe seleccionar un pedido para continuar.',btn:btn });
			}
		});

		$(document).on('click','#btn-print',function(e){
			e.preventDefault();
			
			//
			var pedidos = [];
			$('#tb-list').DataTable().rows().every(function (rowIdx, tableLoop, rowLoop) {
				var data = this.node();
				//var checked = $(data).find('input[type="checkbox"]').prop('checked');
				if($(data).hasClass( "selected" )){
					pedidos.push($(data).attr("data-id"));
				}
				
			});
			if(pedidos.length > 0){
				var id=pedidos[0];
				var page = "print_delivery";
				View.go_print(page, id);
			} else {
				++modalId;
				var fn='Fn.showModal({ id:'+modalId+',show:false });';
				var btn=new Array();
				btn[0]={title:'Aceptar',fn:fn};
				Fn.showModal({ id:modalId,show:true,title:"Pedidos",content:'<i class="fa fa-info-circle" ></i> Debe seleccionar un pedido para continuar.',btn:btn });
			}
		});
		
		$(document).on('click','.close-sidebar-btn',function(e){
			if($(this).hasClass('is-active')){
				$('#tb-list-content').css("max-width","1200px")
				$('#tb-list').DataTable().columns.adjust();
				//
				$('#tb-list').DataTable().responsive.recalc();
			} else {
				$('#tb-list-content').css("max-width","1000px")
				$('.dataTables_scrollHeadInner').css("width", "100%");//DataTable({responsive: true});
				$('.dataTables_scrollHeadInner').find("table").css("width", "100%");
				//
				
			}
			
		});
		

		$(document).on('click','.a-show-body',function(e){
           	var show = $(this).attr("data-show");
			if( show == 'false' ) {
				$(this).parent().parent().parent().parent().find('tbody').removeClass('hide');
				$(this).html('<i class="fa fa-minus-circle" ></i>');
				$(this).attr("data-show", true);
			} else {
				$(this).parent().parent().parent().parent().find('tbody').addClass('hide');
				$(this).html('<i class="fa fa-plus-circle" ></i>');
				$(this).attr("data-show", false);
			}
        });

		$(document).on('click','.a-href',function(){
			var page=$(this).attr('page');
			if( page.length>0 ) Fn.loadPage(page);
			else return false;
		});

		$(document).on('click','#a-logout',function(){
			++modalId;
			alert();
			var btn=new Array();
			btn[0]={title:'Si',fn:'Fn.showModal({ id:'+modalId+',show:false });Fn.logOut();'};
			btn[1]={title:'No',fn:'Fn.showModal({ id:'+modalId+',show:false });'};
			Fn.showModal({ id:modalId,show:true,title:'Cerrar Sesión',content:'¿Desea salir del sistema?',btn:btn });
		});

		$(document).on('click','#a-changelock',function(){
			++modalId;
			var btn=new Array();
			btn[0]={title:'Aceptar',fn:'Fn.showConfirm({ idForm:"frm-clave",fn:"Fn.clave('+modalId+')",content:"¿Desea registrar los datos?" });'};
			btn[1]={title:'Cerrar',fn:'Fn.showModal({ id:"'+modalId+'",show:false });'};
			Fn.showModal({ id:modalId,show:true,title:'Cambiar Clave',frm:View.frmClave(),btn:btn });
		});

		$(document).on('click', '.lk-export-excel', function() {
			var content = $(this).attr("data-content");
			var title = $(this).attr("data-title");
			if( content != '' ){
				var datos = ExportarExcel.getData( content );
				var reporte = title;
				if(datos) {
					var contenido = ExportarExcel.generateExcel(datos);
					if(contenido) { ExportarExcel.downloadExcel(contenido, reporte); }
				}	
			}
		});

		$(document).on('click','span#img-close',function(e){
			e.preventDefault();

			var span=$(this);
			var view=$('#popover-img');
			var img=$('div.img').find('img');

			if( img.attr('src') || span.addClass('alert-danger') ){
				if( view ){
					view.popover("hide");
					view.removeClass('alert-info pointer').addClass('alert-default');
				}
				if( img ) img.removeAttr('src');

				span.removeClass('alert-danger pointer').addClass('alert-default');
			}
		});

	$('body').on('click', '.lk-show-gps', function(){			var lati_1 = $(this).attr('data-lati-1');		    var long_1 = $(this).attr('data-long-1');			var lati_2 = $(this).attr('data-lati-2');		    var long_2 = $(this).attr('data-long-2');			var modulo = $(this).attr('data-modulo');			var data_ = $(this).attr('data-info');			$.post(site_url + "control/mostrarMaps", { lati_1:lati_1, long_1:long_1, lati_2:lati_2, long_2:long_2, modulo:modulo, data:data_ }, function (data) {				++modalId;				var fn='Fn.showModal({ id:'+modalId+',show:false });';				var btn=new Array();					btn[0]={title:'Cerrar',fn:fn};				Fn.showModal({ id:modalId,show:true,title:"GOOGLE MAPS",content:data,btn:btn, width:"90%" });			});		});

		$(document).on('change','select[name="sl-zona"]',function(){
			var idZona=$(this).val();
			$('select[name="sl-ciudad"]').html(Fn.selectOption('ciudad',[idZona])).selectpicker('refresh');

		});

		/*$(document).on('change','select[name="sl-ciudad"]',function(){
            var cod_ubigeo=$(this).val();
            $('select[name="sl-gtm"]').html(Fn.selectOption('gtm',[cod_ubigeo])).selectpicker('refresh');
        });

		$(document).on('change','select[name="sl-canal"]',function(){
			var idCanal=$(this).val();
			$('select[name="sl-subcanal"]').html(Fn.selectOption('subcanal',[idCanal])).selectpicker('refresh');
		});*/
		
		$(document).on('change','select[name="sl-tipoUsuario"]',function(){
			var idTipoUsuario=$(this).val();
			$('select[name="sl-usuario"]').html(Fn.selectOption('usuarios',[idTipoUsuario])).selectpicker('refresh');
		});
		
		$(document).on('change','select[name="sl-cadena"]',function(){
			var idCadena=$(this).val();
			$('select[name="sl-banner"]').html(Fn.selectOption('banner',[idCadena])).selectpicker('refresh');
		});

		$('input[name="txt-fechas"]').daterangepicker({
			locale: {
				"format": "DD/MM/YYYY",
				"applyLabel": "Aplicar",
				"cancelLabel": "Cerrar",
				"daysOfWeek": ["Do","Lu","Ma","Mi","Ju","Vi","Sa"],
				"monthNames": ["Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Setiembre","Octubre","Noviembre","Diciembre"],
				"firstDay": 1
			},
			singleDatePicker: false,
			showDropdowns: false,
			autoApply: true,
		});
		
		$('.rango_fechas').daterangepicker({
			locale: {
				"format": "DD/MM/YYYY",
				"applyLabel": "Aplicar",
				"cancelLabel": "Cerrar",
				"daysOfWeek": ["Do","Lu","Ma","Mi","Ju","Vi","Sa"],
				"monthNames": ["Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Setiembre","Octubre","Noviembre","Diciembre"],
				"firstDay": 1
			},
			singleDatePicker: false,
			showDropdowns: false,
			autoApply: true,
		});

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

	},

	frmClave: function(){
		var html='';
		html+="<form id='frm-clave' class='form-horizontal' role='form' action='control/clave'>";
			html+="<div class='row'>";
				html+="<div class='col-sm-12 col-md-10  col-md-offset-1'>";
					html+="<div class='form-group'>";
						html+="<label class='col-lg-5 control-label'>Clave Actual</label>";
						html+="<div class='input-group col-lg-5'>";
							html+="<span class='input-group-addon'>";
								html+="<i class='glyphicon glyphicon-lock'></i>";
							html+="</span>";
							html+="<input type='password' name='clave_old' class='form-control' patron='requerido'>";
						html+="</div>";
					html+="</div>";
					html+="<div class='form-group'>";
						html+="<label class='col-lg-5 control-label'>Clave Nueva</label>";
						html+="<div class='input-group col-lg-5'>";
							html+="<span class='input-group-addon'>";
								html+="<i class='glyphicon glyphicon-lock'></i>";
							html+="</span>";
							html+="<input type='password' name='clave_new' class='form-control' patron='requerido'>";
						html+="</div>";
					html+="</div>";
					html+="<div class='form-group'>";
						html+="<label class='col-lg-5 control-label'>*Confirmar Clave Nueva</label>";
						html+="<div class='input-group col-lg-5'>";
							html+="<span class='input-group-addon'>";
								html+="<i class='glyphicon glyphicon-lock'></i>";
							html+="</span>";
							html+="<input type='password' name='clave_repeat' class='form-control' patron='requerido,identico[clave_new]'>";
						html+="</div>";
					html+="</div>";
				html+="</div>";
			html+="</div>";
		html+="</form>";

		return html;
	},

    showTable: function(){
		if( $(".table").height() >= 500 ){ $(".table-content").css("overflow-y","scroll");}
		$("#lb-num-rows").html( 'Resultados: ' + $('.table >tbody >tr').length);
	},
}
View.load()

var Global={
	fechaHoraString: function(){
        var dt=new Date();
        var day=dt.getDate();
        var month=dt.getMonth()+1;
        var year=dt.getFullYear();
        var hour=dt.getHours();
        var minute=dt.getMinutes();
        var second=dt.getSeconds();

		var day=day.toString();
		var month=month.toString();
		var year=year.toString();
		var hour=hour.toString();
		var minute=minute.toString();
		var second=second.toString();

		if( day.length==1 ) var day="0"+day;
		if( month.length==1 ) var month="0"+month;
		if( hour.length==1 ) var hour="0"+hour;
		if( minute.length==1 ) var minute="0"+minute;
		if( second.length==1 ) var second="0"+second;

        return year+month+day+"_"+hour+minute+second;
	},
	
	dateTime: function(){
        var dt=new Date();
        var day=dt.getDate();
        var month=dt.getMonth()+1;
        var year=dt.getFullYear();
        var hour=dt.getHours();
        var minute=dt.getMinutes();
        var second=dt.getSeconds();

		var day=day.toString();
		var month=month.toString();
		var year=year.toString();
		var hour=hour.toString();
		var minute=minute.toString();
		var second=second.toString();

		if( day.length==1 ) var day="0"+day;
		if( month.length==1 ) var month="0"+month;
		if( hour.length==1 ) var hour="0"+hour;
		if( minute.length==1 ) var minute="0"+minute;
		if( second.length==1 ) var second="0"+second;

        return year+'/'+month+'/'+day+" "+hour+':'+minute+':'+second;
	},
	
	fechaActual: function() {
		var d   = new Date();
		var mes =  ( (d.getMonth()+1) > 9)?(d.getMonth()+1):'0'+(d.getMonth()+1);
		var dia =  ( d.getDate() > 9)?d.getDate():'0'+d.getDate();
		return dia+'/'+mes+'/'+d.getFullYear();
	},
	
	fechaActual_: function() {
		var d   = new Date();
		var mes =  ( (d.getMonth()+1) > 9)?(d.getMonth()+1):'0'+(d.getMonth()+1);
		var dia =  ( d.getDate() > 9)?d.getDate():'0'+d.getDate();
		return d.getFullYear()+'-'+mes+'-'+dia;
	},
	
	horaActual: function() {
		var d = new Date();
		var hora    =  ( d.getHours() > 9)?d.getHours():'0'+d.getHours();
		var minuto  =  ( d.getMinutes() > 9)?d.getMinutes():'0'+d.getMinutes();
		var segundo =  ( d.getSeconds() > 9)?d.getSeconds():'0'+d.getSeconds();
		return hora+':'+minuto+':'+segundo;
	},
	
	formatDate: function(date) {
		var arr_date = date.split("-");
		return  arr_date[2]+ '/' + arr_date[1] + '/' + arr_date[0];
	},
	
	print: function(data){
        var mywindow=window.open('','Turno');
        mywindow.document.write(data);
        mywindow.print();
        mywindow.close();
		
        return true;
    }
}


var ExportarExcel = {
	
	getData: function( contenedor ) {
		var html = "";
		var css = $("#css-excel").html();
		var contenido = $( "#"+contenedor ).html();
		html += '<html>';
		html += '<head>';
			html += '<meta http-equiv="Content-Type" content="text/html; charset=utf-8">';
			html += '<style type="text/css">';
				html += css;
			html += '</style>';
		html += '</head>';
		html += '<body>';
			html += contenido;
		html += '</body>';
		html += '</html>';
		
		html=html.replace(/<a[^>]*>|<\/a>/g,"");//remove if u want links in your table
		html=html.replace(/<A[^>]*>|<\/A>/g,"");//remove if u want links in your table
		html=html.replace(/<img[^>]*>/gi,""); // remove if u want images in your table
		html=html.replace(/<IMG[^>]*>/gi,""); // remove if u want images in your table
		html=html.replace(/<input[^>]*>|<\/input>/gi,""); // remove input params
		html=html.replace(/<INPUT[^>]*>|<\/INPUT>/gi,""); // remove input params
			
		return { html: html };
	},
	
	generateExcel: function(datos) {
		var contenidoArchivo = [];
		contenidoArchivo.push(datos.html);
		return new Blob(contenidoArchivo, {
			type: 'application/vnd.ms-excel'
		});
	},
	
	downloadExcel: function(contenidoEnBlob, nombreArchivo) {
		//Compatibilidad
		window.URL = window.URL || window.webkitURL;
		//Usaremos un link para iniciar la descarga
		var save = document.createElement('a');
		save.target = '_blank';
		save.download = nombreArchivo;
		//Identifica el navegador
		var nav = navigator.userAgent.toLowerCase();
		//console.log(nav);
		//Internet Explorer
		if((nav.indexOf("msie") != -1)||(nav.indexOf(".net4") != -1)){
			window.navigator.msSaveBlob(contenidoEnBlob, nombreArchivo);
		}
		//Chrome
		if(nav.indexOf("chrome") != -1){
			var url = window.URL.createObjectURL(contenidoEnBlob);
			save.href = url;
			if (document.createEvent) {
				var event = document.createEvent("MouseEvents");
				event.initEvent("click", true, true);
				save.dispatchEvent(event);
			} else if (save.click) {
				save.click();
			}
			window.URL.revokeObjectURL(save.href);
		}
		//Firefox
		if(nav.indexOf("firefox") != -1){
			var reader = new FileReader();
			reader.onload = function (event) {
				save.href = event.target.result;
				if (document.createEvent) {
					var event = document.createEvent("MouseEvents");
					event.initEvent("click", true, true);
					save.dispatchEvent(event);
				} else if (save.click) {
					save.click();
				}
				window.URL.revokeObjectURL(save.href);
			};
			reader.readAsDataURL(contenidoEnBlob);
		}
	}
}

var Imagen = {

	show: function ( e, content, input, flControl ) {
		var files = e.target.files || e.dataTransfer.files;
        file = files[0];
		var content = $("#"+ content);
		var reader = new FileReader();
		reader.onload = function (e) {
			content.attr("src",e.target.result)
			$("#"+input).val( content.attr("src") );
			$("#"+input+'_show').val( $(flControl).val() );
		};
		reader.readAsDataURL(file);
		
	}
	
}


var File = {

	data: [],
	
	encode_utf8: function(s) {
	  return unescape(encodeURIComponent(s));
	},

	decode_utf8: function(s) {
	  return decodeURIComponent(escape(s));
	},

	format_col: function (value, format){
		var msg = '';
		if ( format == 'entero' ) {
            expr = /^\d+$/;
			msg = 'Solo números.';
        }
		if ( format == 'decimal' ) {
            expr = /^-?[0-9]+([.])?([0-9]+)?$/;
			msg = 'Solo números.';
        }
		if ( format == 'porcentaje' ) {
            expr = /^([0]{1}.[0-9]{1}|[0]{1}.[0-9]{2}|[1]{1})$/;
			msg = 'Solo porcentajes (0.00 a 1).';
        }
		if ( format == 'texto') {
            expr = /([^\s])/;
			msg = 'Mínimo una palabra.';
        }
		if ( format == 'bit') {
            expr =  /[SI-NO]/;
			value  = value.toUpperCase();
			msg = 'Solo SI/NO.';
        }
		var array_result = {result: true, msg : ''};
		//console.log(value + '-' + format);
		var result = !expr.test(value);
		if(result){
			array_result = {result: false, msg : '('+ value + ')' +msg};
		} 
		return array_result;
	},
	
	load: function ( e, content, input, flControl, valFormat ) {
		var files = e.target.files || e.dataTransfer.files;
		Fn.showLoading( true, 'Procesando...' );
		$("#data-content-grid").html('<i class="fa fa-spinner fa-pulse fa-3x fa-fw" style="font-size: 1em" aria-hidden="true"></i> Procesando...' );
        file = files[0];
		var content = $("#"+ content);
		var reader = new FileReader();
		File.data = [];
		reader.onload = function (e) {
			content.attr("src",e.target.result)
			//$("#"+input).val( content.attr("src") );
			$("#"+input+'_show').val( $(flControl).val() );
			
			//
			Papa.parse(file,{
				delimiter: "",	// auto-detect
				newline: "",	// auto-detect
				quoteChar: '"',
				escapeChar: '"',
				header: false,
				trimHeaders: false,
				//dynamicTyping: false,
				preview: 0,
				dynamicTyping: true,
				encoding: "",
				worker: true,
				step: undefined,
				error: function(){
					Fn.showLoading(false);
					++modalId;
					var btn=[];
					var fn='Fn.showModal({ id:'+modalId+',show:false });';

					btn[0]={title:'Continuar',fn:fn};
					Fn.showModal({ id:modalId,show:true,title:'Archivo',content:"Error al procesar el archivo intentelo nuevamente.",btn:btn });
					$("#data-content-grid").html('' );
				},
				download: false,
				skipEmptyLines: false,
				chunk: undefined,
				fastMode: undefined,
				beforeFirstChunk: undefined,
				withCredentials: undefined,
				transform: undefined,
				complete: function(results) {
				
					File.data = results.data;
					console.log(File.data)
					//
					var idEncuesta = $('#'+Procesar.idFormEdit+' select[name=idEncuesta_]').val();
					var select_='<option  value="" >-- Ninguno --</option>';
					if( typeof(pregunta_select[idEncuesta])=='object'){
						$.each(pregunta_select[idEncuesta],function(i,v){
							select_+='<option value="'+i+'">'+v+'</option>';
						});
					}
					console.log(select_)
					//
					var html = '';
					var arrayVal = [];
					
					console.log(File.data[0].length);
					var array_error = [], array_ = [];
					var array_head = [];
					if(File.data.length < 2) html = '<div class="alert alert-danger" ><i class="fa fa-exclamation-circle" ></i> No se encontraron filas en el archivo procesado</div>'; 
					else {
						//
						html = '';
						var numReg = 0;
						var numError = 0;
						var html = '<table class="table" >'
						$.each(File.data,function(ix,value){ 
							if(ix == 0){
								html += '<thead>';
									html += '<tr>';
										console.log(value[0])
										var head = value[0].split(',');
										$.each(head,function(ix_,value_){ 
											html += '<td><select class="form-control input-xs" name="sl_pregunta_'+ix_+'" title="-- Ninguno --" data-actions-box="true" data-live-search="true" patron="requerido"  >'+select_+'</select ></td>';
										});
									html += '</tr>';
									html += '<tr>';
										console.log(value[0])
										var head = value[0].split(',');
										$.each(head,function(ix_,value_){ 
											html += '<th>'+value_+'</th>';
										});
									html += '</tr>';
								html += '</thead><tbody>';
							} else {
								html += '<tr>';
									//console.log(value[0])
									if($.isArray(value)){
										var row = value;
										if(value.length == 1){
											var json = JSON.stringify(value[0]);
											var string = json.substr(1,json.length - 2)
											console.log(string.split(/([^,]+)/g));
											if(value[0] != 'null' && value[0] != null  && value[0] != 'NULL' ) var row = value[0].split(',');
											else row = [];
										}
									} 
									
									$.each(row,function(ix_,value_){ 
										html += '<td>'+value_+'</td>';
									});
								html += '</tr>';
							}
						});
						html += '</tbody></table>'
						$("#btn-procesar").removeClass("disabled");
					}
					
					$("#dv-preview").html(html);
					$(".selectpicker").selectpicker('refresh');
					Fn.showLoading(false);
				}
			});
			
			//
			
		};
		reader.readAsDataURL(file);
		
	}
}