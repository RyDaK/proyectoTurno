var Login={
	load: function(){

		$("#btn-login").on("click",function(e){
			e.preventDefault();
			$.when( Fn.validateForm({ id:"frm-login" }) ).then(function(a){
				if( a===true ){
					var data={};
					data=Fn.formSerializeObject("frm-login");
					var jsonString={ 'data':JSON.stringify(data) };
					var url="login/acceder";
					var config={ url:url,data:jsonString };

					$.when( Fn.ajax(config) ).then(function(b){
						if( b.result!=2 ){
							++modalId;

							if(b.status==1){
								var fn='Fn.showModal({ id:'+modalId+',show:false });Fn.loadPage("'+b.url+'");';//
							}
							else var fn='Fn.showModal({ id:'+modalId+',show:false });';

							var btn=new Array();
							btn[0]={title:'Continuar',fn:fn};
							Fn.showModal({ id:modalId,show:true,title:b.msg.title,content:b.msg.content,btn:btn });
						}
					});
				}
			});
		});
	}

}
Login.load();