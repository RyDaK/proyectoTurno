var Fn={

	loadPage: function(page){
		Fn.showLoading(true,'Redireccionando');
		setTimeout(function(){$(location).attr('href',site_url+page);},1000);
	},
	
	loadExternal: function(page){
		Fn.showLoading(true,'Redireccionando');
		setTimeout(function(){$(location).attr('href',page);},1000);
	},

	loadMessage: function ( config ) {
		$("#message-"+config.parent).remove();
		if( config.show ){
			var cssContent = ''
			if ( typeof config.cssContent != 'undefined' ){
				if( config.cssContent == 'red' ) cssContent = ' class="alert alert-danger" ';
				if( config.cssContent == 'green' ) cssContent = ' class="alert alert-success" ';
				if( config.cssContent == 'blue' ) cssContent = ' class="alert alert-info" ';
			}
			var msg='<div id="message-'+config.parent+'" '+cssContent+' style="margin-top: 10px" >'+config.content+'</div>';
			$('.'+config.div).append(msg);
		}
	},

	showLoading: function(show,msg){
		var modal='';
		if( show ){
			modal+="<div id='modal-loading' class='modal fade' tabindex='-1' role='dialog' data-backdrop='static' data-keyboard='false'>";
				modal+="<div class='modal-dialog' >";
					modal+="<div class='modal-content'>";
						modal+="<div class='modal-body'>";
							modal+="<div class='text-center'>"+(($.isNull(msg))?'Cargando':msg)+" <img src='assets/images/load.gif' /></div>";
						modal+="</div>";
					modal+="</div>";
				modal+="</div>";
			modal+="</div>";

			$("body").append(modal);
			$("#lk-modal").attr("data-target","#modal-loading");
			$("#lk-modal").click();
			
		}
		else{
			// $("#modal-loading").modal('hide')
			$("#modal-loading").next().remove();
			$("#modal-loading").remove();
			$("body").removeClass('modal-open');
			$("body").css("padding-right","");
			//
			$("#lk-modal").attr("data-target","");
		}
	},

	showModal: function (config){
		var modal='';
		console.log(config.large);
		console.log(config.xlarge);
		if( config.show ){
			var modal_num=$("body .modal").length;
			modal+="<div id='modal-page-"+config.id+"' class='modal fade' tabindex='-1' role='dialog' data-backdrop='static' data-keyboard='false'>";
				modal+="<div class='modal-dialog "+((!config.large)? '' :'modal-lg')+"  "+(( !config.xlarge)? '' :'modal-xl')+"' "+((!config.width)?'':"style='width:"+config.width+"'")+">";
					modal+="<div class='modal-content '>";
						modal+="<div class='modal-header'>";
							modal+="<h4 class='modal-title'>"+site_name+" - "+config.title+"</h4>";
						modal+="</div>";
						modal+="<div class='modal-body'>";
							if( !$.isNull(config.content) ) modal+="<p>"+config.content+"</p>";
							else if( !$.isNull(config.frm) ) modal+=config.frm;
						modal+="</div>";
						modal+="<div class='modal-footer'>";
					if( !$.isNull(config.btn) ){
						for(var i=0;i<config.btn.length;i++){
							var css = 'btn-success';
							if(i==0){ css = 'btn-success'; }
							modal+="<button type='button' class='btn "+css+"' onclick='"+config.btn[i].fn+"' >"+config.btn[i].title+"</button>";
						}
					}
						modal+="</div>";
                    modal+="</div>";
				modal+="</div>";
			modal+="</div>";

			$("body").append(modal);
			$("#lk-modal").attr("data-target",'#modal-page-'+config.id);
			$("#lk-modal").click();			
		}
		else{
			//$('#modal-page-'+config.id).modal('hide')
			$('#modal-page-'+config.id).next().remove();
			$('#modal-page-'+config.id).remove();
			if( $('.modal:visible').length==0 ) $("body").removeClass('modal-open');
			$("body").css("padding-right","");
			$("#lk-modal").attr("data-target","");
		}
	},

	showConfirm: function(config){
		$.when( Fn.validateForm({ id:config.idForm }) ).then(function(a){
			if( a===true ){
				++modalId;
				var btn=new Array();
				btn[0]={title:'Aceptar',fn:'Fn.showModal({ id:"'+modalId+'",show:false });'+config.fn+';'};
				btn[1]={title:'Cerrar',fn:'Fn.showModal({ id:"'+modalId+'",show:false });'};
				//Fn.showModal({ id:modalId,show:true,width:'500px',title:'Alerta',content:config.content,btn:btn });
				Fn.showModal({ id:modalId,show:true,title:'Alerta',content:config.content,btn:btn });
			}
			//else console.log("no ejecutaré mi ajax");
			else{
				++modalId;
				var btn=new Array();
				btn[0]={title:'Aceptar',fn:'Fn.showModal({ id:"'+modalId+'",show:false });'};
				var content="<div class='alert alert-danger'>Se encontraron incidencias en la operación. <strong>Verifique el formulario.</strong></div>";
				//Fn.showModal({ id:modalId,show:true,width:'500px',title:'Alerta',content:content,btn:btn });
				Fn.showModal({ id:modalId,show:true,title:'Alerta',content:content,btn:btn });				
			}
		});
	},

	download: function (url,data){
		
		Fn.showLoading(true)
		$.fileDownload(url,{
			httpMethod: "POST",
			data: data,
			successCallback:function(url){ Fn.showLoading( false ); },
			failCallback:function(responseHtml,url){
			$.when( Fn.showLoading(false) ).then(function(){
				var id=++modalId;
				var btn=new Array();
				btn[0]={title:'Aceptar',fn:'Fn.showModal({ id:'+id+',show:false });'};
				Fn.showModal({ id:id,show:true,title:'ERROR',content:'Ocurrio un error inesperado en el sistema.',btn:btn });
				})
			}
		});
	},

	validateForm: function(config){
        var result=false;

		var id=config.id;
		var inputs=$("#"+id).find("input, textarea, select").not(":input[type=button], :input[type=submit], :input[type=reset]");

		var a=$.Deferred();

		$.when( Fn.formClear(id) ).then(function(v){
			if(v===true){
				setTimeout(function(){
					$.when(
						inputs.each(function(){
							var this_=$(this);
							var name=this_.attr('name');
							var patron=this_.attr('patron');

							if( typeof(patron)=='string' ){
								var value=this_.val();
								var type=patron.split(',');

								$.each(type,function(i,v){
									if( v=='requerido' || value.length>0 ){
										if( typeof(Fn.validators[v])=='object' ){
											var validators=!Fn.validators[v]['expr'].test(value);
											if(validators){
												this_.parent().addClass('has-error');
												this_.parent().append('<div class="alert alert-danger dv-alert-error" style="margin-top: 5px" >'+Fn.validators[v]['msg']+'</div>');
												//this_.tooltip({ title:Fn.validators[v]['msg'] });
												//this_.tooltip('show');
												return false;
											}
										}
										//else console.log(name," el patron no se identifica");
									}
								});
							}
							//else console.log(name," el patron no es una cadena string");
						})
					).then(function(){
						var form_validado=$("#"+id).find(".has-error").length;
						if(form_validado==0) result=true;
						else result=false;
						a.resolve(result);
					});
				},200);
			}
			else{
				var form_validado=$("#"+id).find(".has-error").length;
				if(form_validado==0) result=true;
				else result=false;
				a.resolve(result);
			}
		});

		return a.promise();

    },

	validateInputOneFull: function(id,input,title){
		var a=$.Deferred();
		var msg="";

		$.when( Fn.formClear(id) ).then(function(v){
			if(v===true){
				setTimeout(function(){
					var total_1=input.length;
					var n_1=1;

					$.each(input,function(index,value){
						var validate=0;
						var total_2=value.length;
						var n_2=1;

						$.each(value,function(i,v){
							if( $(v).val().length>0 ) validate=1;

							if( n_2==total_2 && validate==0 ) msg+="<p>"+title[index]+"</p>";
							else{
								$.each(value,function(ind,va){
									$(va).parent().addClass('has-error');								
								});
							}
							n_2++;
						});

						if( n_1==total_1 ) a.resolve(msg);
						n_1++;
					});
				},200);
			}
		});

		return a.promise();
	},

	logOut: function(url){
		//var url=$("#a-logout").attr("page");
		$.when( Fn.ajax({ url:url,data:{} }) ).then(function(a){
			console.log(a);
			//if(a.result==1){
				Fn.loadPage(a.url);
			//}
		});
	},

	clave: function(modalIdOld){
		var data={};
		data=Fn.formSerializeObject("frm-clave");
		var jsonString={ 'data':JSON.stringify(data) };
		var url=$("#frm-clave").attr("action");
		var config={ url:url,data:jsonString };

		$.when( Fn.ajax(config) ).then(function(a){
			if( a.result!=2 ){
				//var modalIdOld=modalId-1;
				if(a.result==1) Fn.showModal({ id:modalIdOld,show:false });
				++modalId;
				var btn=new Array();
				btn[0]={title:'Aceptar',fn:'Fn.showModal({ id:'+modalId+',show:false });'};
				Fn.showModal({ id:modalId,show:true,title:a.msg.title,content:a.msg.content,btn:btn });
			}
		});
	},

	simpleAjax: function( config ){
		console.log( config );
		var a=$.Deferred();
		$.ajax({
			dataType: "json",
            url: site_url+config.url,
            data: config.data,
            //beforeSend: function(){ Fn.showLoading(true) },
			success: function(r){
				//Fn.showLoading( false );
				a.resolve(r);
            }
		});

		return a.promise();
    },
	
	ajax_arr: function( config, ix ){
		var dfd =$.Deferred();
		dfd.promise();
		//console.log(config);
		$.ajax({
            dataType: "json",
            url: site_url+config.url,
            data: config.data,
			//async:false,
			success: function(r){
				console.log(r);
				global_masivo.push(r);
				dfd.resolve( true );
            },
            error: function(){
				dfd.resolve( false );
            },
			
		});
		return dfd.promise();
    },
	
	procesar_masivo: function(url, data,view,array){
		var dfd = $.Deferred();
        var arr = [];
		global_masivo = [];
		Fn.showLoading( true );
		$.each( array , function( ix, value ){
			var jsonString={ 'data':JSON.stringify(data), 'grid': JSON.stringify(value), 'start': ix };
			var config={ url:url,data:jsonString };
			arr.push( Fn.ajax_arr(config, ix) );
		}); 
		$.when.apply(this, arr).then(dfd.resolve);
		return dfd.promise();	
		
	},
	
	ajax: function( config ){
		var a=$.Deferred();
		var result=[];
			result['result']=2;
			result['data']='';
			result['msg']='';
			result['url']='';

		$.ajax({
            dataType: "json",
            url: site_url+config.url,
            data: config.data,
			beforeSend: function(){  
				// Fn.showLoading(true) 
			},
			success: function(r){
				Fn.showLoading( false );
				result['result']=r.result;
				result['status']=r.status;
				result['data']=($.isNull(r.data))?'':r.data;
				result['msg']=($.isNull(r.msg))?'':r.msg;
				result['url']=($.isNull(r.url))?'':r.url;
				result['tipoReporte']=($.isNull(r.tipoReporte))?'':r.tipoReporte;
				a.resolve(result);
            },
            error: function(){
				$.when( Fn.showLoading(false) ).then(function(){
					var id=++modalId;
					var btn=new Array();
					btn[0]={title:'Aceptar',fn:'Fn.showModal({ id:'+id+',show:false });'};
					Fn.showModal({ id:id,show:true,title:'ERROR',content:'Ocurrio un error inesperado en el sistema.',btn:btn });
					a.resolve( result );
				})
            },
			
		});

		return a.promise();
    },

	formClear: function(id){
		var a=$.Deferred();

		//if( $("#"+id).find(".has-error").removeClass("has-error") && $("#"+id).find("input, textarea, select").tooltip('destroy') ) a.resolve(true);
		if( $("#"+id).find(".dv-alert-error").remove() ) a.resolve(true);
		if( $("#"+id).find(".has-error").removeClass("has-error") ) a.resolve(true);
		else a.resolve(false);

		return a.promise();
	},

	formClearInput: function(id){
		$("#"+id)[0].reset();
		if( $("#"+id+" table").length==1 ){
			$("#"+id+" table").find('input,select').each(function(){
				  var this_=$(this);
				  var defaultVal=this_.data('default');
				  this_.val(defaultVal);
			});
		}
	},

	formSerializeObject: function(id){
		var o={};
		var a=$("#"+id).serializeArray();
		$.each(a,function(){
			if( o[this.name]!==undefined ){
				if( !o[this.name].push ){
					o[this.name]=[o[this.name]];
				}
				o[this.name].push(this.value || '');
			}
			else{
				o[this.name]=this.value || '';
			}
		});
		return o;
	},

	validators:{
		'requerido':{
			'expr': /([^\s])/,
			'msg': ' Este campo es requerido'
		},
		'email':{
			'expr': /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/,
			'msg': ' Email invalido'
		},
		'usuario':{
			'expr': /^[A-Za-z0-9]{6,15}$/,
			'msg': ' Solo se permite letras y números. Entre 6 a 15 digitos'
		},
		'dni':{
			'expr': /^[0-9]{8}$/,
			'msg': ' DNI inválido'
		},
		'ruc':{
			'expr': /^[0-9]{11}$/,
			'msg': ' RUC inválido'
		},
		'letras':{
			'expr': /^[a-zA-Z]*$/,
			'msg': ' Ingresar solo letras'
		},
		'numeros':{
			'expr': /^-?[0-9]\d*(\.\d+)?$/,
			'msg': ' Ingresar solo números'
		},
		'enteros':{
			'expr': /^[0-9]$/,
			'msg': ' Ingresar solo enteros.'
		}
	},

	handleImage: function(e,callback,outputFormat){
		var canvas=document.createElement('CANVAS');
		var ctx=canvas.getContext('2d');

		var reader=new FileReader();
		reader.onload=function(event){
			var img=new Image();
			img.crossOrigin = 'Anonymous';
			img.onload=function(){
				canvas.width=640;
				canvas.height=480;
				ctx.drawImage(img,0,0,640,480);
				dataURL=canvas.toDataURL(outputFormat,1.0)
				callback(dataURL);
				canvas=null;
			}
			img.src=event.target.result;
		}
		reader.readAsDataURL(e.target.files[0]);     
	},

	selectpickerRefresh: function(){
		if( /Android|webOS|iPhone|iPad|iPod|BlackBerry/i.test(navigator.userAgent) ) $('.selectpicker').selectpicker('mobile').selectpicker('refresh');
		else $('.selectpicker').selectpicker('refresh');
	},

	selectOption: function(name,filter=[]){
		var html='';

		if( localStorage.getItem("vi_tv_filtros") !== null ){
			var objectLocal=$.parseJSON(localStorage.getItem('vi_tv_filtros'));
			switch(name){
				case 'zona':
				console.log(objectLocal['zona']);
					html+='<option value="" class="label label-success" >Zona (Todo)</option>';
					if( typeof(objectLocal['zona'])==='object' ){
						$.each(objectLocal['zona'],function(i,v){
							html+='<option value='+i+'>'+v+'</option>';
						});
					}
					break;
				case 'ciudad':
            console.log(objectLocal['ciudad']);
					html+='<option value="" class="label label-success" >Departamento (Todo)</option>';
					if( typeof(objectLocal['ciudad'][filter[0]])==='object' ){
						$.each(objectLocal['ciudad'][filter[0]],function(i,v){
							html+='<option value='+i+'>'+v+'</option>';
						});
					}
					break;
				case 'cadena':
					html+='<option value="" class="label label-success" >Cadena (Todo)</option>';
					if( typeof(objectLocal['cadena'])==='object' ){
						$.each(objectLocal['cadena'],function(i,v){
							html+='<option value='+i+'>'+v+'</option>';
						});
					}
					break;
				case 'banner':
					html+='<option value="" class="label label-success" >Banner (Todo)</option>';
					if( typeof(objectLocal['banner'][filter[0]])==='object' ){
						$.each(objectLocal['banner'][filter[0]],function(i,v){
							html+='<option value='+i+'>'+v+'</option>';
						});
					}
					break;
				case 'cluster':
					html+='<option value="" class="label label-success" >Cluster (Todo)</option>';
					if( typeof(objectLocal['cluster'])==='object' ){
						$.each(objectLocal['cluster'],function(i,v){
							html+='<option value='+i+'>'+v+'</option>';
						});
					}
					break;
				case 'canal':
					html+='<option value="" class="label label-success" >Canal (Todo)</option>';
					if( typeof(objectLocal['canal'])==='object' ){
						$.each(objectLocal['canal'],function(i,v){
							html+='<option value='+i+'>'+v+'</option>';
						});
					}
					break;
				case 'clienteTipo':
					html+='<option value="" class="label label-success" >Cliente Tipo (Todo)</option>';
					if( typeof(objectLocal['clienteTipo'])==='object' ){
						$.each(objectLocal['clienteTipo'],function(i,v){
							html+='<option value='+i+'>'+v+'</option>';
						});
					}
					break;
				case 'tipoUsuario':
					html+='<option value="" class="label label-success" >Tipo Usuario (Todo)</option>';
					if( typeof(objectLocal['tipoUsuario'])==='object' ){
						$.each(objectLocal['tipoUsuario'],function(i,v){
							html+='<option value='+i+'>'+v+'</option>';
						});
					}
					break;
				case 'distribuidora':
					html+='<option value="" class="label label-success" >Distribuidora (Todo)</option>';
					if( typeof(objectLocal['distribuidora'])==='object' ){
						$.each(objectLocal['distribuidora'],function(i,v){
							html+='<option value='+i+'>'+v+'</option>';
						});
					}
					break;
                case 'usuarios':
					console.log(objectLocal['usuarios']);
                    html+='<option value="" class="label label-success" >Usuario (Todos)</option>';
                    if( typeof(objectLocal['usuarios'][filter[0]])==='object' ){
                        $.each(objectLocal['usuarios'][filter[0]],function(i,v){
                            html+='<option value='+i+'>'+v+'</option>';
                        });
                    }
                    break;
			}
		}

		return html;
	},

	selectOrderOption: function(id){
		var items = $('#'+id+' option').get();
		items.sort(function(a,b){
			var keyA=$(a).text();
			var keyB=$(b).text();

			if( keyA<keyB ) return -1;
			if( keyA>keyB ) return 1;
			return 0;
		});

		var select=$('#'+id);
		$.each(items,function(i,option){
			select.append(option);
		});
	},

	obj_count: function(obj){
		var count=0;
		var i;
		for( i in obj ){
			if( obj.hasOwnProperty(i) ){ count++; }
		}
		return count;
	},



}
