<div class="app-sidebar sidebar-shadow bg-danger sidebar-text-light">
                    <div class="app-header__logo">
                        <div class="logo-src"></div>
                        <div class="header__pane ml-auto">
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
					<?
						$menu_active_ = isset($menu_active)? $menu_active : '';
					?>  
                    
                    <div class="scrollbar-sidebar">
                        <div class="app-sidebar__inner">
                            <!-- <ul class="vertical-nav-menu">
								<?
									$menu = $this->session->userdata('menu');
									foreach($menu as $row){
										$grupo_menu[$row['id_menu_grupo']] = $row;
										$menu_[$row['id_menu_grupo']][$row['id_menu']] = $row;
									}
								?>
								<?foreach($grupo_menu as $ix_g => $row_g){?>
									<li class="app-sidebar__heading"><?=$row_g['menu_grupo']?>bola</li>
									<?foreach($menu_[$ix_g] as $ix_m => $row_m){?>
										<li>
											
											<a href="<?=site_url().$row_m['ruta_menu']?>" class="<?=($menu_active_==$ix_m)? 'mm-active': ''?>">
												<i class="metismenu-icon <?=$row_m['icon_menu']?>"></i>
												<?=$row_m['menu']?>
											</a>
										</li>
									<?}?>
								<?}?>
                                        
                            </ul>    -->

                            <ul class="vertical-nav-menu" style="color:white;margin-bottom: 2em">
                                <?foreach($rubros as $row){?>
                                <li class="app-sidebar__heading">
									 <a href="#">
                                        <i class="metismenu-icon pe-7s-flag"></i>
                                        <?=$row['nombre']?>
                                        <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                                    </a>
                                    <!--<label><?=$row['nombre']?>bola</label>-->
									<ul>
                                    <?foreach($comercios as $row_comercios){?>
                                        <?if($row['id_rubro'] == $row_comercios['id_rubro']){?>
                                            <li id="li_cargar_comercios" nombre_comercio="<?=$row_comercios['nombre']?>" value="<?=$row_comercios['id_giro']?>">
                                            <!-- <a  href = "<?=site_url().'Cliente?cod_comercio='.base64_encode($row_comercios['idTipoComercio'])?>" class="<?=($menu_active_==$ix_m)? 'mm-active': ''?>"> -->
                                            <a class="" style="cursor: pointer" >
                                                <div >
                                                    <i class="metismenu-icon <?="fas fa-drumstick-bite"?>"></i>
                                                    <?=$row_comercios['nombre']?>
                                                    
                                                </div>
                                            </a>
                                        </li>
                                        <?}?>
                                    <?}?>
									</ul>
                                </li>
                            <?}?>

                                <?/*?>
                                <li class="app-sidebar__heading">
                                    
                                    <label>Localidad</label>
                            
                                    <form action="" id="frm-ubigeo" >
										<div class="row" >
											<div class="col-md-12">
												<div class="position-relative form-group">
													<select class="mb-2 form-control" id="distrito_pdv" name="distrito_pdv" >
														<option value=''>Puntos de Venta</option>
														<? foreach($distritos_pdv as $row){ ?>
															<option value="<?=$row['id_ubigeo']?>"><?=$row['distrito']?></option>
														<? } ?>
													</select >
												</div>
											</div>
										</div>
										<div class="row provincias" >
											<div class="col-md-12">
												<div class="position-relative form-group">
													<select class="form-control" id="provincias" name="provincias"  >
														<option>Provincia</option>
													</select >
												</div>
											</div>
										</div>
										<div class="row distritos" >
											<div class="col-md-12">
												<div class="position-relative form-group">
													<select class="form-control" id="distritos" name="distritos"  >
														<option>Distrito</option>
													</select >
												</div>
											</div>
										</div>
                            
									</form>
                                </li>
                                <?*/?>
                                <li class="app-sidebar__heading">
                                    
                                    <label>SELECCIONAR DISTRITO DE ENTREGA</label>
                            
                                    <form action="" id="frm-ubigeo" >
										<div class="row" >
											<div class="col-md-12">
												<div class="position-relative form-group">
													<select class="mb-2 form-control" id="departamentos" name="departamentos" >
														<option>Departamento</option>
														<? foreach($departamentos as $row){ ?>
															<option value="<?=$row['cod_dep']?>"><?=$row['departamento']?></option>
														<? } ?>
													</select >
												</div>
											</div>
										</div>
										<div class="row provincias" >
											<div class="col-md-12">
												<div class="position-relative form-group">
													<select class="form-control" id="provincias" name="provincias"  >
														<option>Provincia</option>
													</select >
												</div>
											</div>
										</div>
										<div class="row distritos" >
											<div class="col-md-12">
												<div class="position-relative form-group">
													<select class="form-control" id="distritos" name="distritos"  >
														<option>Distrito</option>
													</select >
												</div>
											</div>
										</div>
                            
									</form>
								</li>
                               
                            </ul>
                        </div>
                    </div>
                </div>   

 
      