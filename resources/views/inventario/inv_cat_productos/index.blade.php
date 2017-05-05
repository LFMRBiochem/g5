@extends('layout.app')
@section('content')
<div class="form-group row add">
    <div class="page-header">
        <h1>Inventario productos</h1>
    </div>
    <div class="col-md-12">
        <div class="text-right">
            <button type="button"  data-toggle="modal" data-target="#create-item" class="btn btn-primary" @keydown.enter.prevent="">
                <i class="fa fa-plus" aria-hidden="true"></i> Crear
            </button>
        </div>
    </div>
</div>

<style>
    .panel-default-transparente{
        background: rgba(255,254,240,0.3);
        border: 0px;

    }

    .well{
        background: rgba(34,34,34,0.2);
        border: 1px solid rgba(245,245,245,0.2);

    }

    li {
        list-style-type: none
    }

    .table-borderless > tbody > tr > td,
    .table-borderless > tbody > tr > th,
    .table-borderless > tfoot > tr > td,
    .table-borderless > tfoot > tr > th,
    .table-borderless > thead > tr > td,
    .table-borderless > thead > tr > th {
        border: none;
    }
</style>


<!--Create Item Modal--> 
<div class="modal fade" id="create-item" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Crear producto</h4>
            </div>
            <div class="modal-body">
                <form method="post" enctype="multipart/form-data" @keydown.enter.prevent="">
                    <style>
                        .v-select input[type=search]{
                            text-transform: uppercase
                        }
                    </style>
                    <div class="text-right">
                        <button type="submit" class="btn btn-primary"    ><i class="fa fa-plus" aria-hidden="true"></i> Guardar</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-power-off" aria-hidden="true"></i> Salir</button>
                    </div>

                    <div class="form-group">
                        <label for="nombre_producto">Nombre producto:</label>
                        <input type="text" name="nombre_producto" class="form-control" v-model="newItem.nombre_producto"   autocomplete="off" />
                        <span v-if="formErrors['nombre_producto']" class="error text-danger">
                            @{{ formErrors['nombre_producto'] }}
                        </span>
                    </div>
                    <div class="form-group">
                        <label for="usos">Usos:</label>
                        <input type="text" name="usos" class="form-control" v-model="newItem.usos"   autocomplete="off" />
                        <span v-if="formErrors['usos']" class="error text-danger">
                            @{{ formErrors['usos'] }}
                        </span>
                    </div>
                    <div class="form-group">
                        <label for="dosis">Dosis:</label>
                        <textarea name="dosis" class="form-control"  v-model="newItem.dosis"></textarea>
                        <span v-if="formErrors['dosis']" class="error text-danger">
                            @{{ formErrors['dosis'] }}
                        </span>
                    </div>
                    <div class="form-group">
                        <label for="ventajas">Ventajas:</label>
                        <textarea name="ventajas" class="form-control"  v-model="newItem.ventajas"></textarea>
                        <span v-if="formErrors['ventajas']" class="error text-danger">
                            @{{ formErrors['ventajas'] }}
                        </span>
                    </div>
                    <div class="form-group">
                        <label for="formula">Formula:</label>
                        <textarea name="formula" class="form-control"  v-model="newItem.formula"></textarea>
                        <span v-if="formErrors['formula']" class="error text-danger">
                            @{{ formErrors['formula'] }}
                        </span>
                    </div>

                    <hr>

                    <h4 class="text-center">Agregar identificador comercial</h4>

                    <div class="form-group">
                        <div class="input-group">
                            <input type="text"  class="form-control" value="@{{ full }}" readonly>
                            <span class="input-group-btn">
                                <button class="btn btn-default" type="button"  data-toggle="collapse" data-target="#formulario" aria-expanded="false" aria-controls="formulario"><i class="fa fa-chevron-circle-down" aria-hidden="true"></i></button>
                            </span>
                        </div>
                    </div>

                    <div class="collapse" id="formulario">
                        <div class="col-md-1"></div>
                        <div class="col-md-10">
                            <div class="list-group">
                                <li v-if="selectedSegmento" class="list-group-item active">
                                    <i class="fa fa-bars" aria-hidden="true"></i> @{{ selectedSegmento }} 
                                    <small>(segmento) </small><span class="badge"><a v-on:click="getSegmento()">Cambiar</a></span>
                                </li>
                                <li v-if="selectedFamilia" class="list-group-item active">
                                    <i class="fa fa-bars" aria-hidden="true"></i> @{{ selectedFamilia }} 
                                    <small>(familia) </small><span class="badge"><a v-on:click="getFamilia(cve_segmento,selectedSegmento)">Cambiar</a></span>
                                </li>
                                <li v-if="selectedClase" class="list-group-item active">
                                    <i class="fa fa-bars" aria-hidden="true"></i> @{{ selectedClase }} 
                                    <small>(clase) </small><span class="badge"><a v-on:click="getClase(cve_familia,selectedFamilia)">Cambiar</a></span>
                                </li>
                                <li v-if="selectedBloque" class="list-group-item active">
                                    <i class="fa fa-bars" aria-hidden="true"></i> @{{ selectedBloque }} 
                                    <small>(Bloque) </small><span class="badge"><a v-on:click="getBloque(cve_clase,selectedClase)">Cambiar</a></span>
                                </li>
                                <div  v-if="activo_ps == true">
                                    <a v-for="segmento in productos_segmento" v-on:click="getFamilia(segmento.cve_segmento,segmento.nombre_segmento)" class="list-group-item">
                                        @{{ segmento.nombre_segmento }}
                                    </a>
                                </div>
                                <div  v-if="activo_pf == true" >
                                    <a v-for="familia in productos_familia" v-on:click="getClase(familia.cve_familia,familia.nombre_familia)" class="list-group-item">
                                        @{{ familia.nombre_familia }}
                                    </a>
                                </div>
                                <div  v-if="activo_pc == true" >
                                    <a v-for="clase in productos_clase" v-on:click="getBloque(clase.cve_clase,clase.nombre_clase)" class="list-group-item">
                                        @{{ clase.nombre_clase }}
                                    </a>
                                </div>
                                <div  v-if="activo_pb == true" >
                                    <a v-for="bloque in productos_bloque" v-on:click="getAll(bloque.cve_clase,bloque.nombre_bloque)"  class="list-group-item">
                                        @{{ bloque.nombre_bloque }}
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-1"></div>


                        <div class="form-group">
                            <label for="precio_unitario">precio_unitario:</label>
                            <input type="text" name="precio_unitario" class="form-control"  v-model="newItem.precio_unitario">
                            <span v-if="formErrors['precio_unitario']" class="error text-danger">
                                @{{ formErrors['precio_unitario'] }}
                            </span>
                        </div>
                        <div class="form-group">
                            <label for="piezas_por_paquete">piezas_por_paquete:</label>
                            <input type="text" name="piezas_por_paquete" class="form-control"  v-model="newItem.piezas_por_paquete">
                            <span v-if="formErrors['piezas_por_paquete']" class="error text-danger">
                                @{{ formErrors['piezas_por_paquete'] }}
                            </span>
                        </div>
                        <div class="form-group">
                            <label for="venta_minima">venta_minima:</label>
                            <input type="text" name="venta_minima" class="form-control"  v-model="newItem.venta_minima">
                            <span v-if="formErrors['venta_minima']" class="error text-danger">
                                @{{ formErrors['venta_minima'] }}
                            </span>
                        </div>
                        <div class="form-group">
                            <label for="peso_unitario">peso_unitario:</label>
                            <input type="text" name="peso_unitario" class="form-control"  v-model="newItem.peso_unitario">
                            <span v-if="formErrors['peso_unitario']" class="error text-danger">
                                @{{ formErrors['peso_unitario'] }}
                            </span>
                        </div>
                        <div class="form-group">
                            <label for="es_venta">es_venta:</label>
                            <input type="text" name="es_venta" class="form-control"  v-model="newItem.es_venta">
                            <span v-if="formErrors['es_venta']" class="error text-danger">
                                @{{ formErrors['es_venta'] }}
                            </span>
                        </div>

                        <div class="form-group">
                            <label for="considerar_margen">considerar_margen:</label>
                            <input type="text" name="considerar_margen" class="form-control"  v-model="newItem.considerar_margen">
                            <span v-if="formErrors['considerar_margen']" class="error text-danger">
                                @{{ formErrors['considerar_margen'] }}
                            </span>
                        </div>
                        <div class="form-group">
                            <label for="cve_unidad_medida">cve_unidad_medida:</label>
                            <v-select :value.sync="selectedUnidad_medida" :options="unidad_medida"  placeholder="Seleccione..."   >
                            </v-select>
                            <span v-if="formErrors['cve_unidad_medida']" class="error text-danger">
                                @{{ formErrors['cve_unidad_medida'] }}
                            </span>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary"    ><i class="fa fa-plus" aria-hidden="true"></i> Guardar</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-power-off" aria-hidden="true"></i> Salir</button>
                    </div>

                </form>
            </div>
        </div>
    </div>

    @stop

    @section('javascript')
    <script type="text/javascript" src="{{ asset('js/inv_cat_productos.js') }}"></script>

    @stop