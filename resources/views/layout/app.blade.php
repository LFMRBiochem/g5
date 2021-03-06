<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title id="tit">Simple Laravel Vue.Js CRUD</title>
        <meta id="token" name="token" value="{{ csrf_token() }}">
        <!-- Bootstrap -->
        <link href="{{ asset('bootstrap/dist/css/bootstrap-edit.css') }}" rel="stylesheet">
        <link href="{{ asset('font-awesome-4.7.0/css/font-awesome.css') }}" rel="stylesheet">
        <link href="{{ asset('toastr/toastr.min.css') }}" rel="stylesheet">
        <!--<link href="{{ asset('fullCalendar/fullcalendar/dist/fullcalendar.css') }}" rel="stylesheet">-->
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.2/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>
        <style>
            #calendar {
                max-width: 600px;
                margin: 0 auto;
            }
            body { 


                background: url("{{ asset('Reachcore-Facturacion.jpg') }}") no-repeat center center fixed; 
                /*background: url(https://trafpartner.ru/2016.jpg) no-repeat center center fixed;*/ 
                -webkit-background-size: cover;
                -moz-background-size: cover;
                -o-background-size: cover;
                background-size: cover;
            }

        </style>


        <div id="top-nav" class="navbar navbar-inverse navbar-static-top" >
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="{{URL::to('/').'/inicio'}}">Biochem</a>
                </div>
                <div class="navbar-collapse collapse" >
                    <!-- Right nav -->
                    <ul class="nav navbar-nav">
                        <!--<li class="active"><a href="bootstrap-navbar.html">Default</a></li>-->

                        <!--<li><a href="#">administracion <span class="caret"></span></a>-->
                        <!--                            <ul class="dropdown-menu">
                                                        <li><a href="{{URL::to('/').'/autentificacion/usuarios' }}"> Usuarios</a></li>
                                                        <li><a href="{{URL::to('/').'/administracion/glx_companias' }}"> Compañias</a></li>
                        
                                                        <li><a href="{{URL::to('/').'/nomina/nmn_sat_catbanco' }}"> nmn_sat_catbanco</a></li>
                                                        <li><a href="{{URL::to('/').'/nomina/nmn_cat_empleados' }}"> nmn_cat_empleados</a></li>
                                                        <li><a href="{{URL::to('/').'/contabilidad/ctb_reservacfdi' }}"> ctb_reservacfdi_impuestos</a></li>
                                                        <li><a href="{{URL::to('/').'/contabilidad/ctb_reserva_cfdi' }}"> ctb_reserva_cfdi</a></li>
                        
                                                        <li><a href="{{URL::to('/').'/administracion/glx_companias' }}"> glx_companias</a></li>
                        
                        
                        
                        
                                                    </ul>-->
                        <!--</li>-->

                        <li><a href="#">Compras <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="#"><i class="fa fa-book" aria-hidden="true"></i> Catálogos<span class="caret"></span></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="{{URL::to('/').'/cmp_cat_proveedores'}}">Proveedores</a></li>
                                        <!--<li><a href="#">Vehículos</a></li>-->
                                    </ul>
                                </li>
                                <li><a href="#"><i class="fa fa-cog fa-spin fa-fw"></i> Operaciones<span class="caret"></span></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="{{URL::to('/').'/solicitud_pagos'}}"><i class="fa fa-file-text-o" aria-hidden="true"></i> Solicitud de pago</a></li>
                                        <li><a href="{{URL::to('/').'/orden_compra'}}"><i class="fa fa-file-text-o" aria-hidden="true"></i> Orden de compra</a></li>
                                    </ul>
                                </li>
<!--                                <li><a href="#"><i class="fa fa-cogs" aria-hidden="true"></i> Procesos<span class="caret"></span></a>
                                    <ul class="dropdown-menu">
                                                                                <li><a href="#">Editor orden de compra</a></li>
                                                                                <li><a href="#">Entrada a almacen</a></li>
                                                                                <li><a href="#">Ajustes de precios de ME</a></li>
                                    </ul>
                                </li>-->
<!--                                <li><a href="#"><i class="fa fa-print" aria-hidden="true"></i> Reportes<span class="caret"></span></a>
                                    <ul class="dropdown-menu">
                                                                                <li><a href="#">Ordenes de compra</a></li>
                                                                                <li><a href="#">Seguimiento de OC</a></li>
                                                                                <li><a href="#">Histórico de compras por producto</a></li>
                                    </ul>
                                </li>-->
                            </ul>
                        </li>
                        <li><a href="#">Contabilidad <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="#"><i class="fa fa-book" aria-hidden="true"></i> Catálogos<span class="caret"></span></a>
                                    <ul class="dropdown-menu">
                                        <!--                                        <li><a href="#">Arbol de cuentas</a></li>-->
                                        <li><a href="{{URL::to('/').'/ctb_cat_cuentas'}}">Cuentas contables</a></li>
                                        <li><a href="{{URL::to('/').'/ctb_cat_concepto_financiero'}}">Concepto financiero</a></li>
                                        <li><a href="{{URL::to('/').'/ctb_tipos_cambio'}}">Tipos de cambio</a></li>

                                        <li><a href="{{URL::to('/').'/ctb_cat_centros_costo'}}">Centros costo</a></li>
                                        <li><a href="{{URL::to('/').'/ctb_tipos_centros'}}">Tipos centros costo</a></li>
                                        <li><a href="{{URL::to('/').'/ctb_documentos_partidas'}}">Documentos partidas</a></li>
                                    
                                    </ul>
                                </li>
<!--                                <li><a href="#"><i class="fa fa-cogs" aria-hidden="true"></i> Procesos<span class="caret"></span></a>
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
                                </li>-->
<!--                                <li><a href="#"><i class="fa fa-tachometer" aria-hidden="true"></i> Administración<span class="caret"></span></a>
                                    <ul class="dropdown-menu">
                                                                                <li><a href="#">Ordenes de compra</a></li>
                                                                                <li><a href="#">Seguimiento de OC</a></li>
                                                                                <li><a href="#">Histórico de compras por producto</a></li>
                                    </ul>
                                </li>-->
<!--                                <li><a href="#"><i class="fa fa-print" aria-hidden="true"></i> Reportes<span class="caret"></span></a>
                                    <ul class="dropdown-menu">
                                                                                <li><a href="#">Ordenes de compra</a></li>
                                                                                <li><a href="#">Seguimiento de OC</a></li>
                                                                                <li><a href="#">Histórico de compras por producto</a></li>
                                    </ul>
                                </li>-->
                            </ul>
                        </li>
                        <li><a href="#">Inventarios <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="#"><i class="fa fa-book" aria-hidden="true"></i> Catálogos<span class="caret"></span></a>
                                    <ul class="dropdown-menu">

                                        <li><a href="{{URL::to('/').'/inv_cat_productos'}}">Productos</a></li>
                                        <!--                                        <li><a href="#">Proveedores</a></li>
                                                                                <li><a href="#">Vehículos</a></li>-->
                                    </ul>
                                </li>
<!--                                <li><a href="#"><i class="fa fa-cogs" aria-hidden="true"></i> Procesos<span class="caret"></span></a>
                                    <ul class="dropdown-menu">
                                                                                <li><a href="#">Editor orden de compra</a></li>
                                                                                <li><a href="#">Entrada a almacen</a></li>
                                                                                <li><a href="#">Ajustes de precios de ME</a></li>
                                    </ul>
                                </li>-->
<!--                                <li><a href="#"><i class="fa fa-print" aria-hidden="true"></i> Reportes<span class="caret"></span></a>
                                    <ul class="dropdown-menu">
                                                                                <li><a href="#">Ordenes de compra</a></li>
                                                                                <li><a href="#">Seguimiento de OC</a></li>
                                                                                <li><a href="#">Histórico de compras por producto</a></li>
                                    </ul>
                                </li>-->
                            </ul>
                        </li>
                        <li><a href="#">Nómina <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="#"><i class="fa fa-book" aria-hidden="true"></i> Catálogos<span class="caret"></span></a>
                                    <ul class="dropdown-menu">

                                        <li><a href="{{URL::to('/').'/nmn_sat_catbanco'}}">Bancos</a></li>
                                        <li><a href="{{URL::to('/').'/nmn_cat_empleados'}}">Empleados</a></li>
                                        <li><a href="{{URL::to('/').'/nmn_cat_conceptos'}}">Conceptos de nómina</a></li>
                                        <li><a href="{{URL::to('/').'/nmn_cat_departamentos'}}">Catalogo de departamentos y áreas</a></li>

                                        <!--                                        <li><a href="#">Proveedores</a></li>
                                                                                <li><a href="#">Vehículos</a></li>-->
                                    </ul>
                                </li>
<!--                                <li><a href="#"><i class="fa fa-cogs" aria-hidden="true"></i> Procesos<span class="caret"></span></a>
                                    <ul class="dropdown-menu">
                                                                                <li><a href="#">Editor orden de compra</a></li>
                                                                                <li><a href="#">Entrada a almacen</a></li>
                                                                                <li><a href="#">Ajustes de precios de ME</a></li>
                                    </ul>
                                </li>-->
<!--                                <li><a href="#"><i class="fa fa-print" aria-hidden="true"></i> Reportes<span class="caret"></span></a>
                                    <ul class="dropdown-menu">
                                                                                <li><a href="#">Ordenes de compra</a></li>
                                                                                <li><a href="#">Seguimiento de OC</a></li>
                                                                                <li><a href="#">Histórico de compras por producto</a></li>
                                    </ul>
                                </li>-->
                            </ul>
                        </li>
<!--                        <li><a href="#">Producción <span class="caret"></span></a>
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
                        </li>-->
                        
                        <li><a href="#">Tesorería <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="#"><i class="fa fa-book" aria-hidden="true"></i> Catálogos<span class="caret"></span></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="{{URL::to('/').'/catalogo-de-bancos'}}">Catalogo de bancos</a></li>

                                    </ul>
                                </li>
<!--                                <li><a href="#"><i class="fa fa-cogs" aria-hidden="true"></i> Procesos<span class="caret"></span></a>
                                    <ul class="dropdown-menu">
                                                                                <li><a href="#">Editor orden de compra</a></li>
                                                                                <li><a href="#">Entrada a almacen</a></li>
                                                                                <li><a href="#">Ajustes de precios de ME</a></li>
                                    </ul>
                                </li>-->
<!--                                <li><a href="#"><i class="fa fa-print" aria-hidden="true"></i> Reportes<span class="caret"></span></a>
                                    <ul class="dropdown-menu">
                                                                                <li><a href="#">Ordenes de compra</a></li>
                                                                                <li><a href="#">Seguimiento de OC</a></li>
                                                                                <li><a href="#">Histórico de compras por producto</a></li>
                                    </ul>
                                </li>-->
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
            <!-- /container -->
        </div>

        <script type="text/javascript"  src="{{ asset('jquery/jquery-2.2.4.min.js') }}"></script>
        <script type="text/javascript"  src="{{ asset('bootstrap/dist/js/bootstrap.min.js') }}" ></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.3.3/vue.js"></script>
        <script src="https://unpkg.com/vue-select@latest"></script>
        <script type="text/javascript" src="{{ asset('vue-1.0.28/vue-resource.js') }}"></script>
        <div class="stilos">
            @yield('stilous')
        </div>
        <div class="container" id="manage-vue">
            @yield('content')
        </div>

        <script type="text/javascript"  src="{{ asset('smartmenus/jquery.smartmenus.min.js') }}"></script>
        <script type="text/javascript"  src="{{ asset('smartmenus/addons/bootstrap/jquery.smartmenus.bootstrap.min.js') }}"></script>

        <script type="text/javascript" src="{{ asset('toastr/toastr.min.js') }}"></script>


        @yield('javascript')

<!--<script type="text/javascript" src="{{ asset('js/autentificacion.js') }}"></script>-->

<!--<script type="text/javascript" src="{{ asset('js/cm_cat_proveedores.js')}}"></script>-->

<!--        <script>
$(document).ready(function () {

$('#calendar').fullCalendar({
header: {
left: 'prev,next today',
        center: 'title',
        right: 'month,agendaWeek,agendaDay'
},
        eventClick: function (event, element) {

        $('#calendar').fullCalendar('removeEvents', event._id)


        },
        events: [
        {
        title: 'Event1',
                start: '2017-04-12',
                resourceEditable: true // resource not editable for this event
        },
        {
        title: 'Event2',
                start: '2017-04-12',
                end: '2017-04-12',
                resourceEditable: false // resource not editable for this event
        }
        // etc...
        ],
//        defaultDate: '2017-04-12',
//        navLinks: true, // can click day/week names to navigate views
        selectable: true,
        select: function (start, end) {
        var title = prompt('Event Title:');
        var eventData;
        if (title) {
        eventData = {
        title: title,
                start: start,
                end: end
        };
        $('#calendar').fullCalendar('renderEvent', eventData, true); // stick? = true
        }
        $('#calendar').fullCalendar('unselect');
        },
        locale: 'es',
        eventColor: 'rgb(255,107,107)',
        editable: true,
        eventLimit: true, // allow "more" link when too many events


});
});
        </script>-->

        <script>
$(function () {
    $('[data-toggle="popover"]').popover()
});
        </script>

        <script>

        </script>


        <script>
            function checar(t) {
                for (var y in t) {
                    $("#" + y.replace(/\./gi, '_')).prop("checked", true);
                }
            }
        </script>


    </body>
</html>
