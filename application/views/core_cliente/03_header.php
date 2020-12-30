<style>
	.show_alert{
		diplay:none;
	}
	@media (max-width: 991.98px){
		.header__pane{
			display: none !important;
		}
		.show_alert{
			position:absolute; 
			top:50px; left:0;
			z-index: 2000;
		}
    }
    .badge{
        color: white;
        background-color: red;
        border-radius: 2em;
    }
    .caret{
        color: transparent;
    }
    .app-header .app-header__content.header-mobile-open{visibility:visible;opacity:1;top:100px;display:block}
    /* .fa-cart-arrow-down{
        padding-top: 10px;
    } */
    /* @media (max-width: 991.98px) */
    .app-header .app-header__content{
        border-radius: 30px;
        padding: 5px 15px
    }

</style>
<?
 $cliente_usuario = $this->session->userdata('idUsuarioCliente');
 $nombre_cliente = $this->session->userdata('nombres');
?>

<div class="show_alert">
	<span class="badge badge-danger" >  Filtros </span>
</div>

<div class="app-header header-shadow">
    <div class="app-header__logo">
        <div class="logo-src"></div>
        <div class="header__pane ml-auto" >
            <div>
                <button type="button" class="hamburger close-sidebar-btn hamburger--elastic" data-class="closed-sidebar">
                    <span class="hamburger-box">
                        <span class="hamburger-inner"></span>
                    </span>
                </button>
            </div>
        </div>
    </div>
    <div class="app-header__mobile-menu">
        <div>
            <button type="button" class="hamburger hamburger--elastic mobile-toggle-nav">
                <span class="hamburger-box">
                    <span class="hamburger-inner"></span>
					
                </span>
            </button>
        </div>
    </div>
    <div class="app-header__menu">
        <span>
            <button type="button" class="btn-icon btn-icon-only btn btn-primary btn-sm mobile-toggle-header-nav">
                <span class="btn-icon-wrapper">
                    <i class="fa fa-ellipsis-v fa-w-6"></i>
                </span>
            </button>
        </span>
    </div>   
    <div class="app-header__content" style="height: auto;">
        <!-- <div class="app-header-left"> -->
        <div class="app-header-center">
                    <!--<div class="search-wrapper">
                        <div class="input-holder">
                            <input type="text" class="search-input" placeholder="Type to search">
                            <button class="search-icon"><span></span></button>
                        </div>
                        <button class="close"></button>
                    </div>-->
            <ul class="header-menu nav">
                <li class="nav-item">
                    <a href="<?=site_url()?>home_cliente" class="nav-link active">
                        <i class="nav-link-icon fa fa-home"> </i>
                        Inicio
                    </a>
                </li>
                <!--<li class="dropdown nav-item" >
                    <a href="javascript:void(0);" class="nav-link disabled" disabled>
                        <i class="nav-link-icon fa fa-cog"></i>
                                Mi Perfil
                    </a>
                </li>-->
                <li class="dropdown nav-item" id="btn_libro_reclamaciones" cod_cliente_usuario="<?= isset($cliente_usuario)? $cliente_usuario:""?>" >
                    <a class="nav-link">
                        <i class="nav-link-icon fas fa-book"></i>
                        Libro de Reclamaciones
                    </a>
                </li>
                <?php if(isset($cliente_usuario)){ ?>
                <li class="dropdown nav-item">
                <a class="nav-link" id="btn_mis_pedidos">
                        <i class="nav-link-icon fas fa-list-alt"></i>
                                 Mis Pedidos
                    </a>
                </li>
                <?php } else{}?>
            </ul>        
        </div>
                <div class="app-header-right">
                    <div class="header-btn-lg pr-0">
                        <div class="widget-content p-0">
                                 <span class="badge pull-right" id="cantidad-notificaciones"></span>
                            <div class="widget-content-wrapper">
                                <div class="shop-car-user">
                                    <?
                                    // $usuario_cliente = array(
                                    //     'id_usuario_cliente' => "Prueba",
                                    //     'nombre_usuario_cliente' => "NOmbre_prueba"
                                    // );

                                    // $this->session->set_userdata($usuario_cliente);
                                   
                                    if(isset($cliente_usuario)){
                                    ?>
                                <br>
                                <div class="widget-content-left">
                                    <div class="row">
                                        <div class="btn-group">
                                            <a data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="p-0 btn validar_sess" sess="1">
                                                <img width="42" class="rounded-circle" src="assets/images/avatars/user_icon.png" alt="" style="height:40px">
                                                <i class="fa fa-angle-down ml-2 opacity-8"></i>
                                            </a>
                                            <div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu dropdown-menu-right">
                                                <button type="button" tabindex="0" class="dropdown-item" id="btn-cambiar-clave" ><i class="fa fa-unlock" ></i>&nbsp;Cambiar Contraseña</button>
                                                <div tabindex="-1" class="dropdown-divider"></div>
                                                <a href="javascript:Cliente.logOut_cliente('cliente/logout_cliente');" class="dropdown-item"><i class="fa fa-close"></i>&nbsp;Cerrar Sesion</a>
                                            </div>
                                        </div>
                                        <a href="javascript:;" id="#cargar_pedidos_cliente" onclick="Cliente.listado_pedidos_cliente();">
                                            <i class="fas fa-cart-arrow-down" style="font-size: 2em;" ></i><p style="font-size:10px">ver carrito</p>
                                        </a>
                                    </div>
                                </div>
                                <?
                                   }else{  
                                    ?>

                                    <div class="header-btn-lg pr-0" id="div_carrito">
                                        <br>                                        
                                        <div class="widget-content p-0">
                                           <div class="row">
                                                    <button id="btn-iniciar-sesion-cliente" sess="0" class="btn btn-outline-primary my-2 my-sm-0 validar_sess" type="submit" style="margin-right: 10px;height: 40px">Iniciar Sesión</button>
                                                        <a href="javascript:;" id="#cargar_pedidos_cliente" onclick="Cliente.listado_pedidos_cliente();">
                                                         <!--<img  width="35" class="" src="assets/images/car-ico.png" alt="">-->
                                                            <i class="fas fa-cart-arrow-down" style="font-size: 2em;" ></i><p style="font-size:10px">ver carrito</p>
                                                         </a>
                                           </div>
                                        </div>
                                    </div>
                            <?}?>
                                                     
                                        
                            </div>
                        </div>
                    </div>
                </div>        
            </div>
        </div>
    </div>        
	
	<!-- MANDAR LA VARIABLE CIRCULO_INFO-->
<div class="ui-theme-settings hide">
	
	<button type="button" id="TooltipDemo" class="btn-open-options btn btn-warning">
		<i class="fa fa-info fa-w-16 fa-spin fa-2x"></i>
	</button>
	<div class="theme-settings__inner">
		<div class="scrollbar-container">
			<div class="theme-settings__options-wrapper">
				<h3 class="themeoptions-heading">
					<div>
						<?=isset($info['title'])? $info['title'] : ''?>
					</div>
					
				</h3>
				<div class="p-3">
				  <?=isset($info['content'])? $info['content'] : ''?>
				</div>
  
			</div>
		</div>
	</div>
</div>     		