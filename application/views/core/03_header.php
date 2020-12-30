<style>
	@media (max-width: 991.98px){
		.header__pane{
			display: none !important;
		}
	}
</style>
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
            </div>    <div class="app-header__content">
                <div class="app-header-left">
                    <!--<div class="search-wrapper">
                        <div class="input-holder">
                            <input type="text" class="search-input" placeholder="Type to search">
                            <button class="search-icon"><span></span></button>
                        </div>
                        <button class="close"></button>
                    </div>-->
                    <ul class="header-menu nav">
                        <li class="nav-item">
                            <a href="<?=site_url()?>home" class="nav-link active">
                                <i class="nav-link-icon fa fa-home"> </i>
                                Inicio
                            </a>
                        </li>
                        <li class="dropdown nav-item" >
                            <a href="javascript:void(0);" class="nav-link disabled" disabled>
                                <i class="nav-link-icon fa fa-cog"></i>
                                Mi Perfil
                            </a>
                        </li>
                    </ul>        </div>
                <div class="app-header-right">
                    <div class="header-btn-lg pr-0">
                        <div class="widget-content p-0">
                            <div class="widget-content-wrapper">
                                <div class="widget-content-left">
                                    <div class="btn-group">
                                        <a data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="p-0 btn">
											<?
												$id_perfil = $this->session->userdata('id_usuario_perfil');
											?>
                                            <img width="42" class="rounded-circle" src="assets/images/avatars/<?=isset($id_perfil)? $id_perfil : '1';?>.png" alt="">
                                            <i class="fa fa-angle-down ml-2 opacity-8"></i>
                                        </a>
                                        <div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu dropdown-menu-right">
                                            <button type="button" tabindex="0" class="dropdown-item" id="btn-cambiar-clave" ><i class="fa fa-unlock" ></i>&nbsp;Cambiar Contraseña</button>
                                            <div tabindex="-1" class="dropdown-divider"></div>
                                            <a href="javascript:Fn.logOut('home/logout');" class="dropdown-item"><i class="fa fa-close"></i>&nbsp;Salir</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="widget-content-left  ml-3 header-user-info">
                                    <div class="widget-heading">
										<?
											$usuario = $this->session->userdata('nombre_usuario');
										?>
                                        <?=isset($usuario)? $usuario : 'User Demo';?>
                                    </div>
										<?
											$perfil = $this->session->userdata('perfil');
										?>
                                    <div class="widget-subheading">
                                        <?=isset($perfil)? $perfil : 'Administrador';?>
                                    </div>
                                </div>
								<!--
                                <div class="widget-content-right header-user-info ml-3">
                                    <button type="button" class="btn-shadow p-1 btn btn-primary btn-sm show-toastr-example">
                                        <i class="fa text-white fa-calendar pr-1 pl-1"></i>
                                    </button>
                                </div>
								-->
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