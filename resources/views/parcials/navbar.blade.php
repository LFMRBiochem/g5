		<div class = 'navbar navbar-inverse navbar-fixed-top' role = 'navigation'>
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="#">Biochem</a>
                </div>
                <div class="navbar-collapse collapse" >
                    <!-- Right nav -->
                    <ul class="nav navbar-nav">
                        <!--<li class="active"><a href="bootstrap-navbar.html">Default</a></li>-->

                        <li><a href="#">Administracion <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="{{URL::to('/').'/autentificacion/usuarios' }}"> Usuarios</a></li>
                                <li><a href="{{URL::to('/').'/administracion/glx_companias' }}"> Compañias</a></li>

                                <li><a href="{{URL::to('/').'/nomina/nmn_sat_catbanco' }}"> nmn_sat_catbanco</a></li>
                                <li><a href="{{URL::to('/').'/nomina/nmn_cat_empleados' }}"> nmn_cat_empleados</a></li>
                                <li><a href="{{URL::to('/').'/contabilidad/ctb_reservacfdi' }}"> ctb_reservacfdi_impuestos</a></li>
                                <li><a href="{{URL::to('/').'/contabilidad/ctb_reserva_cfdi' }}"> ctb_reserva_cfdi</a></li>

                                <li><a href="{{URL::to('/').'/administracion/glx_companias' }}"> glx_companias</a></li>




                            </ul>
                        </li>

                        <li><a href="#">Compras <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="#"><i class="fa fa-book" aria-hidden="true"></i> Catálogos<span class="caret"></span></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="#">Proveedores</a></li>
                                        <li><a href="#">Vehículos</a></li>
                                    </ul>
                                </li>
                                <li><a href="#"><i class="fa fa-cogs" aria-hidden="true"></i> Procesos<span class="caret"></span></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="#">Editor orden de compra</a></li>
                                        <li><a href="#">Entrada a almacen</a></li>
                                        <li><a href="#">Ajustes de precios de ME</a></li>
                                    </ul>
                                </li>
                                <li><a href="#"><i class="fa fa-print" aria-hidden="true"></i> Reportes<span class="caret"></span></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="#">Ordenes de compra</a></li>
                                        <li><a href="#">Seguimiento de OC</a></li>
                                        <li><a href="#">Histórico de compras por producto</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li><a href="#">Contabilidad <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="#"><i class="fa fa-book" aria-hidden="true"></i> Catálogos<span class="caret"></span></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="#">Arbol de cuentas</a></li>
                                    </ul>
                                </li>
                                <li><a href="#"><i class="fa fa-cogs" aria-hidden="true"></i> Procesos<span class="caret"></span></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="#">Facturas descargadas</a></li>
                                        <li><a href="#">Facturas canceladas</a></li>
                                        <li><a href="#">Asociación póliza factura</a></li>
                                        <li><a href="#">Cargar facturas al servidor</a></li>
                                        <li><a href="#">Actualizar descarga de facturas</a></li>
                                        <li role="separator" class="divider"></li>
                                        <li><a href="#">Editor de pólizas</a></li>
                                        <li><a href="#">Masica de facturas</a></li>
                                        <li role="separator" class="divider"></li>
                                        <li><a href="#">Pre-póliza</a></li>
                                    </ul>
                                </li>
                                <li><a href="#"><i class="fa fa-tachometer" aria-hidden="true"></i> Administración<span class="caret"></span></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="#">Ordenes de compra</a></li>
                                        <li><a href="#">Seguimiento de OC</a></li>
                                        <li><a href="#">Histórico de compras por producto</a></li>
                                    </ul>
                                </li>
                                <li><a href="#"><i class="fa fa-print" aria-hidden="true"></i> Reportes<span class="caret"></span></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="#">Ordenes de compra</a></li>
                                        <li><a href="#">Seguimiento de OC</a></li>
                                        <li><a href="#">Histórico de compras por producto</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li><a href="#">Inventarios <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="#"><i class="fa fa-book" aria-hidden="true"></i> Catálogos<span class="caret"></span></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="#">Proveedores</a></li>
                                        <li><a href="#">Vehículos</a></li>
                                    </ul>
                                </li>
                                <li><a href="#"><i class="fa fa-cogs" aria-hidden="true"></i> Procesos<span class="caret"></span></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="#">Editor orden de compra</a></li>
                                        <li><a href="#">Entrada a almacen</a></li>
                                        <li><a href="#">Ajustes de precios de ME</a></li>
                                    </ul>
                                </li>
                                <li><a href="#"><i class="fa fa-print" aria-hidden="true"></i> Reportes<span class="caret"></span></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="#">Ordenes de compra</a></li>
                                        <li><a href="#">Seguimiento de OC</a></li>
                                        <li><a href="#">Histórico de compras por producto</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li><a href="#">Nómina <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="#"><i class="fa fa-book" aria-hidden="true"></i> Catálogos<span class="caret"></span></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="#">Proveedores</a></li>
                                        <li><a href="#">Vehículos</a></li>
                                    </ul>
                                </li>
                                <li><a href="#"><i class="fa fa-cogs" aria-hidden="true"></i> Procesos<span class="caret"></span></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="#">Editor orden de compra</a></li>
                                        <li><a href="#">Entrada a almacen</a></li>
                                        <li><a href="#">Ajustes de precios de ME</a></li>
                                    </ul>
                                </li>
                                <li><a href="#"><i class="fa fa-print" aria-hidden="true"></i> Reportes<span class="caret"></span></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="#">Ordenes de compra</a></li>
                                        <li><a href="#">Seguimiento de OC</a></li>
                                        <li><a href="#">Histórico de compras por producto</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li><a href="#">Producción <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="#"><i class="fa fa-book" aria-hidden="true"></i> Catálogos<span class="caret"></span></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="#">Proveedores</a></li>
                                        <li><a href="#">Vehículos</a></li>
                                    </ul>
                                </li>
                                <li><a href="#"><i class="fa fa-cogs" aria-hidden="true"></i> Procesos<span class="caret"></span></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="#">Editor orden de compra</a></li>
                                        <li><a href="#">Entrada a almacen</a></li>
                                        <li><a href="#">Ajustes de precios de ME</a></li>
                                    </ul>
                                </li>
                                <li><a href="#"><i class="fa fa-print" aria-hidden="true"></i> Reportes<span class="caret"></span></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="#">Ordenes de compra</a></li>
                                        <li><a href="#">Seguimiento de OC</a></li>
                                        <li><a href="#">Histórico de compras por producto</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li><a href="#">Ventas <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="#"><i class="fa fa-book" aria-hidden="true"></i> Catálogos<span class="caret"></span></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="#">Proveedores</a></li>
                                        <li><a href="#">Vehículos</a></li>
                                    </ul>
                                </li>
                                <li><a href="#"><i class="fa fa-cogs" aria-hidden="true"></i> Procesos<span class="caret"></span></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="#">Editor orden de compra</a></li>
                                        <li><a href="#">Entrada a almacen</a></li>
                                        <li><a href="#">Ajustes de precios de ME</a></li>
                                    </ul>
                                </li>
                                <li><a href="#"><i class="fa fa-print" aria-hidden="true"></i> Reportes<span class="caret"></span></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="#">Ordenes de compra</a></li>
                                        <li><a href="#">Seguimiento de OC</a></li>
                                        <li><a href="#">Histórico de compras por producto</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">

                        <li>
                            <a type="button" data-container="body" data-html="true" data-trigger="hover" data-toggle="popover" data-placement="bottom" data-content="<strong>Transacción:</strong> A.2.0.0.00.00">
                                <i class="fa fa-question" aria-hidden="true"></i>
                            </a> 
                        </li>
                        @if (session()->exists('key')) 
                        <li><a href="#"><i class="fa fa-user" aria-hidden="true"></i> {{ session()->get('key')->Nombre }} <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="{{URL::to('/').'/autentificacion/logincontroller/logout' }}"><i class="glyphicon glyphicon-lock"></i> Logout</a></li>
                            </ul>
                        </li>
                        @endif
                    </ul>
                </div>
		</div>