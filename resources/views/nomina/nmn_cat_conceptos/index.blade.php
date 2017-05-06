@extends('layout.app')
@section('content')
<div class="form-group row add">

    <div class="page-header">
        <h1>Conceptos de n&oacute;mina</h1>
    </div>
    <div class="col-md-12">
        <div class="text-right">
            <button type="button" data-toggle="modal" data-target="#create-item" class="btn btn-primary" @click.prevent="cleanItem()" @keydown.enter.prevent="">
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
    .employee{
        font-weight: normal;
    }
    select option{
        font-size: 13pt;
    }
    select{
        font-size: 12pt;
    }
</style>

<div class="row">
    <div class="panel panel-default-transparente">
        <div class="panel-body">
            <div class="table-responsive">
                <table class="table table-borderless employee">
                    <tr style="background: rgba(245,245,245,0.5);border: 0px">
                        <!--<th>num_empleado</th>-->
                        <th class="text-center">Concepto</th><!-- Descripción del concepto -->
                        <th class="text-center">Estatus</th>
                    </tr>
                    <tr v-for="item in items">

                        <!--<th>@{{ item.num_empleado}}</th>-->
                        <th class="text-center">@{{ item.descripcion}}</th>
                        <th class="text-center">@{{ item.estatus}}</th>
                        <th class="text-center" style="display: none;">@{{ item.id_folio_concepto}}</th>

                        <td>

                            <button class="edit-modal btn btn-warning btn-sm btn-block" @click.prevent="editItem(item)">
                                <span class="glyphicon glyphicon-edit"></span> Editar
                            </button>
                        </td>
                        <td>
                            <button v-if="item.estatus == 'X'" class="edit-modal btn btn-default btn-sm btn-block" @click.prevent="deleteItem(item)" >
                                <i class="fa fa-toggle-on" aria-hidden="true"></i> Activar
                            </button>
                            <button v-if="item.estatus == 'A'" class="edit-modal btn btn-danger btn-sm btn-block" @click.prevent="deleteItem(item)" >
                                <i class="fa fa-toggle-off" aria-hidden="true"></i> Cancelar
                            </button>
                        </td>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="text-center">
    <nav>
        <ul class="pagination">
            <li v-if="pagination.current_page > 1">
                <a href="#" aria-label="Previous" @click.prevent="changePage(pagination.current_page - 1)">
                    <span aria-hidden="true">«</span>
                </a>
            </li>
            <li v-for="page in pagesNumber" v-bind:class="[ page == isActived ? 'active' : '']">
                <a href="#" @click.prevent="changePage(page)">
                    @{{ page }}
                </a>
            </li>
            <li v-if="pagination.current_page < pagination.last_page">
                <a href="#" aria-label="Next" @click.prevent="changePage(pagination.current_page + 1)">
                    <span aria-hidden="true">»</span>
                </a>
            </li>
        </ul>
    </nav>
</div>


<!-- Create Item Modal -->
<div class="modal fade" id="create-item" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Crear concepto de n&oacute;mina</h4>
            </div>
            <div class="modal-body">
                <form method="post" enctype="multipart/form-data" v-on:submit.prevent="createItem">
                    <style>
                        .v-select input[type=search]{
                            text-transform: uppercase;
                        }
                    </style>
                    <div class="text-right">
                        <button type="submit" class="btn btn-primary"    ><i class="fa fa-plus" aria-hidden="true"></i> Guardar</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-power-off" aria-hidden="true"></i> Salir</button>
                    </div>                  
                    <div class="form-group">
                        <input type="text" name="cve_compania" class="form-control" value="019" v-model="newItem.cve_compania" style="display: none;"/>
                    </div>
                    <div class="form-group">
                        <label for="descripcion">Descripci&oacute;n:</label>
                        <!--<input type="text" name="primer_apellido" id="primer_apellido" class="form-control" v-model="newItem.primer_apellido" />-->
                        <v-select :on-search="id_conceptofinanciero_search" :value.sync="selectedConcepto" :options="conceptos"  placeholder="Nombre del concepto..." id="nombre_empleado" 
                        v-model="newItem.descripcion">
                        </v-select>
                        <span v-if="formErrors['descripcion']" class="error text-danger">
                            @{{ formErrors['descripcion'] }}
                        </span>
                    </div>
                    <div class="form-group">
                        <label for="percepcion_deduccion">Percepci&oacute;n &oacute; Deducci&oacute;n:</label>
                        <!--<input type="text" name="segundo_apellido" id="segundo_apellido" class="form-control" v-model="newItem.segundo_apellido" />-->
                        <select class="form-control" v-model="newItem.percepcion_deduccion">
                            <option value="" selected="selected">SELECCIONE...</option>
                            <option value="P">Percepci&oacute;n</option>
                            <option value="D">Deducci&oacute;n</option>
                        </select>
                        <span v-if="formErrors['percepcion_deduccion']" class="error text-danger">
                            @{{ formErrors['percepcion_deduccion'] }}
                        </span>
                    </div>

                    <div class="form-group">
                        <label for="operacion">Operaci&oacute;n:</label>
                        <input type="text" name="operacion" class="form-control" v-model="newItem.operacion"  autocomplete="off"/>
                        <span v-if="formErrors['operacion']" class="error text-danger">
                            @{{ formErrors['operacion'] }}
                        </span>
                    </div>

                    <div class="form-group">
                        <label for="considerar_recibo">Incluir en recibo de n&oacute;mina?:</label>
                        <select class="form-control" v-model="newItem.considerar_recibo">
                            <option value="" selected="selected">SELECCIONE...</option>
                            <option value="1">S&Iacute;</option>
                            <option value="0">NO</option>
                        </select>
                        <span v-if="formErrors['considerar_recibo']" class="error text-danger">
                            @{{ formErrors['considerar_recibo'] }}
                        </span>
                    </div>

                    <div class="form-group">
                        <label for="considerar_reportes">Incluir en reportes de n&oacute;mina?:</label>
                        <select class="form-control" v-model="newItem.considerar_reportes">
                            <option value="" selected="selected">SELECCIONE...</option>
                            <option value="1">S&Iacute;</option>
                            <option value="0">NO</option>
                        </select>
                        <span v-if="formErrors['considerar_reportes']" class="error text-danger">
                            @{{ formErrors['considerar_reportes'] }}
                        </span>
                    </div>

                    <div class="form-group">
                        <label for="estatus">Estatus:</label>
                        <select class="form-control" v-model="newItem.estatus">
                            <option value="A" selected="selected">Activo</option>
                            <option value="X">Inactivo</option>
                        </select>
                        <span v-if="formErrors['estatus']" class="error text-danger">
                            @{{ formErrors['estatus'] }}
                        </span>
                    </div>                    
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary"    ><i class="fa fa-plus" aria-hidden="true"></i> Guardar</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-power-off" aria-hidden="true"></i> Salir</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit Item Modal -->
<div class="modal fade" id="edit-item" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Editar concepto de n&oacute;mina</h4>
            </div>
            <div class="modal-body">
                <form method="post" enctype="multipart/form-data" v-on:submit.prevent="updateItem(fillItem.id_folio_concepto)">
                    <style>
                        .v-select input[type=search]{
                            //text-transform: uppercase
                        }
                    </style>
                    <div class="text-right">
                        <button type="submit" class="btn btn-primary"    ><i class="fa fa-plus" aria-hidden="true"></i> Guardar</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-power-off" aria-hidden="true"></i> Salir</button>
                    </div>
                    <div class="form-group">
                        <input type="text" name="cve_compania" class="form-control" value="019" v-model="fillItem.cve_compania" style="display: none;"/>
                    </div>
                    <div class="form-group">
                        <label for="descripcion">Descripci&oacute;n:</label>
                        <input type="text" name="descripcion" id="descripcion" class="form-control" v-model="fillItem.descripcion" disabled/>
                        <!--<v-select :on-search="id_centrocosto_search" :value.sync="selectedId_centrocosto" :options="id_centrocosto"  placeholder="Nombre del concepto..." id="nombre_empleado" 
                        v-model="fillItem.descripcion">
                        </v-select>-->
                        <span v-if="formErrors['descripcion']" class="error text-danger">
                            @{{ formErrors['descripcion'] }}
                        </span>
                    </div>
                    <div class="form-group">
                        <label for="percepcion_deduccion">Percepci&oacute;n &oacute; Deducci&oacute;n:</label>
                        <!--<input type="text" name="percepcion_deduccion" id="percepcion_deduccion" class="form-control" v-model="fillItem.percepcion_deduccion" readonly />-->
                        <select class="form-control" v-model="fillItem.percepcion_deduccion">
                            <option value="" selected="selected">SELECCIONE...</option>
                            <option value="P">Percepci&oacute;n</option>
                            <option value="D">Deducci&oacute;n</option>
                        </select>
                        <span v-if="formErrors['percepcion_deduccion']" class="error text-danger">
                            @{{ formErrors['percepcion_deduccion'] }}
                        </span>
                    </div>

                    <div class="form-group">
                        <label for="operacion">Operaci&oacute;n:</label>
                        <input type="text" name="operacion" class="form-control" v-model="fillItem.operacion"  autocomplete="off"/>
                        <span v-if="formErrors['operacion']" class="error text-danger">
                            @{{ formErrors['operacion'] }}
                        </span>
                    </div>

                    <div class="form-group">
                        <label for="considerar_recibo">Incluir en recibo de n&oacute;mina?:</label>
                        <select class="form-control" v-model="fillItem.considerar_recibo">
                            <option value="" selected="selected">SELECCIONE...</option>
                            <option value="1">S&Iacute;</option>
                            <option value="0">NO</option>
                        </select>
                        <span v-if="formErrors['considerar_recibo']" class="error text-danger">
                            @{{ formErrors['considerar_recibo'] }}
                        </span>
                    </div>

                    <div class="form-group">
                        <label for="considerar_reportes">Incluir en reportes de n&oacute;mina?:</label>
                        <select class="form-control" v-model="fillItem.considerar_reportes">
                            <option value="" selected="selected">SELECCIONE...</option>
                            <option value="1">S&Iacute;</option>
                            <option value="0">NO</option>
                        </select>
                        <span v-if="formErrors['considerar_reportes']" class="error text-danger">
                            @{{ formErrors['considerar_reportes'] }}
                        </span>
                    </div>

                    <div class="form-group">
                        <label for="estatus">Estatus:</label>
                        <select class="form-control" v-model="fillItem.estatus">
                            <option value="A" selected>Activo</option>
                            <option value="X">Inactivo</option>
                        </select>
                        <span v-if="formErrors['estatus']" class="error text-danger">
                            @{{ formErrors['estatus'] }}
                        </span>
                    </div>                    
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary"    ><i class="fa fa-plus" aria-hidden="true"></i> Guardar</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-power-off" aria-hidden="true"></i> Salir</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@stop

@section('javascript')
<script type="text/javascript" src="{{ asset('js/nmn_cat_conceptos.js') }}"></script>
@stop