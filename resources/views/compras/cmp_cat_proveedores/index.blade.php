@extends('layout.app')
@section('content')
<div class="form-group row add">
    <div class="page-header">
        <h1>Listar proveedores</h1>
    </div>
    <div class="col-md-12">
        <div class="text-right">
            <button type="button"  data-toggle="modal" data-target="#create-item" class="btn btn-primary" @click.prevent="cleanItem()" @keydown.enter.prevent="">
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

<div class="row">
    <div class="panel panel-default-transparente">
        <div class="panel-body">
            <div class="table-responsive">
                <table class="table table-borderless">
                    <tr style="background: rgba(245,245,245,0.5);border: 0px">
                        <th class="text-center">Razón social</th>
                        <th class="text-center">RFC</th>
                        <th class="text-center">Entidad</th>
                        <th class="text-center">Telefonos</th>
                        <th class="text-center">Email</th>
                        <th class="text-center">Atención de pagos</th>
                        <th class="text-center">Atención de ventas</th>
                        <th class="text-center">Estatus</th>
                        <th  class="text-center" colspan="2">Actions</th>
                    </tr>
                    <tr v-for="item in items">
                        <td  class="text-center">@{{ item.razon_social.split("|").join(" ") }}</td>
                        <td  class="text-center">@{{ item.rfc }}</td>
                        <td  class="text-center">@{{ item.Cve_entidad }}</td>
                        <td  class="text-center">@{{ item.telefonos }}</td>
                        <td  class="text-center">@{{ item.email }}</td>
                        <td  class="text-center">@{{ item.atencion_pagos }}</td>
                        <td  class="text-center">@{{ item.atencion_ventas }}</td>
                        <td  class="text-center">@{{ item.estatus }}</td>
                        <td>
                            <button class="edit-modal btn btn-warning btn-sm btn-block" @click.prevent="editItem(item)" @keydown.enter.prevent="">
                                <span class="glyphicon glyphicon-edit"></span> Ediar
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
<div class="modal fade" id="create-item" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Crear proveedor</h4>
            </div>
            <div class="modal-body">
                <form method="post" enctype="multipart/form-data" v-on:submit.prevent="createItem" @keydown.enter.prevent=""/>
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
                    <label for="razon_social">Razón social:</label>
                    <!--<input type="text" name="razon_social" class="form-control" v-model="newItem.razon_social"    autocomplete="off" />-->
                    <v-select :on-search="razon_social_search" :value.sync="selectedRazon_social" :options="razon_social"  placeholder="Seleccione..."   >
                    </v-select>
                    <span v-if="formErrors['razon_social']" class="error text-danger">
                        @{{ formErrors['razon_social'] }}
                    </span>
                </div>

                <div class="form-group">
                    <label for="rfc">RFC:</label>
                    <input type="text" name="rfc" class="form-control" v-model="newItem.rfc"   autocomplete="off" />
                    <span v-if="formErrors['rfc']" class="error text-danger">
                        @{{ formErrors['rfc'] }}

                    </span>
                </div>

                <div class="form-group">
                    <input type="hidden" name="Codigo_pais"  value="223" v-model="newItem.Codigo_pais"  autocomplete="off"/>
                    <span v-if="formErrors['Codigo_pais']" class="error text-danger">
                        @{{ formErrors['Codigo_pais'] }}
                    </span>
                </div>

                <div class="form-group">
                    <label for="tipo_persona">Tipo de persona:</label>
                    <select name="tipo_persona" class="form-control" v-model="newItem.tipo_persona">
                        <option disabled value="">Seleccione...</option>
                        <option value="F">Física</option>
                        <option value="M">Moral</option>
                    </select>

                    <span v-if="formErrors['tipo_persona']" class="error text-danger">
                        @{{ formErrors['tipo_persona'] }}
                    </span>
                </div>


                <div class="form-group">
                    <label for="Cve_entidad">Entidad:</label>
                    <v-select :value.sync="selectedEntidad" :options="entidad"  placeholder="Seleccione..."   >
                    </v-select>

                    <span v-if="formErrors['Cve_entidad']" class="error text-danger">
                        @{{ formErrors['Cve_entidad'] }}
                    </span>
                </div>

                <div class="form-group">
                    <label for="Cve_municipio">Municipio:</label>
                    <v-select :value.sync="selectedMunicipio" :options="municipio"  placeholder="Seleccione..."   >
                    </v-select>
                    <span v-if="formErrors['Cve_municipio']" class="error text-danger">
                        @{{ formErrors['Cve_municipio'] }}
                    </span>
                </div>

                <div class="form-group">
                    <label for="Cve_localidad">Localidad:</label>
                    <v-select :value.sync="selectedLocalidad" :options="localidad"  placeholder="Seleccione..."   >
                    </v-select>

                    <span v-if="formErrors['Cve_localidad']" class="error text-danger">
                        @{{ formErrors['Cve_localidad'] }}
                    </span>
                </div>
                <div class="form-group">
                    <label for="Codigo_postal">Código postal:</label>
                    <v-select :value.sync="selectedCodigo_postal" :options="codigo_postal"  placeholder="Seleccione..."   >
                    </v-select>
                    <span v-if="formErrors['Codigo_postal']" class="error text-danger">
                        @{{ formErrors['Codigo_postal'] }}
                    </span>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="telefonos">Telefonos:</label>
                            <input type="text" name="telefonos" class="form-control" v-model="newItem.telefonos"   autocomplete="off" />
                            <span v-if="formErrors['telefonos']" class="error text-danger">
                                @{{ formErrors['telefonos'] }}
                            </span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="email" name="email" class="form-control" v-model="newItem.email"  autocomplete="off" />
                            <span v-if="formErrors['email']" class="error text-danger">
                                @{{ formErrors['email'] }}
                            </span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="origen_bienes">Origen de bienes:</label>
                            <select name="origen_bienes" class="form-control" v-model="newItem.origen_bienes">
                                <option disabled value="">Seleccione...</option>
                                <option value="nac">Nacionales</option>
                                <option value="int">Internacionales</option>
                            </select>

                            <span v-if="formErrors['origen_bienes']" class="error text-danger">
                                @{{ formErrors['origen_bienes'] }}
                            </span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="limite_credito">Limite de crédito:</label>
                            <input type="number"  min="0" name="limite_credito" class="form-control" v-model="newItem.limite_credito" autocomplete="off" />
                            <span v-if="formErrors['limite_credito']" class="error text-danger">
                                @{{ formErrors['limite_credito'] }}
                            </span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="dias_credito">Dias de crédito:</label>
                            <input type="number"  min="0" name="dias_credito" class="form-control" v-model="newItem.dias_credito" autocomplete="off"  />
                            <span v-if="formErrors['dias_credito']" class="error text-danger">
                                @{{ formErrors['dias_credito'] }}
                            </span>
                        </div>
                    </div>

                </div>

                <div class="form-group">
                    <label for="atencion_pagos">Atención de pagos:</label>
                    <input type="text" name="atencion_pagos" class="form-control" v-model="newItem.atencion_pagos" autocomplete="off" />
                    <span v-if="formErrors['atencion_pagos']" class="error text-danger">
                        @{{ formErrors['atencion_pagos'] }}
                    </span>
                </div>

                <div class="form-group">
                    <label for="atencion_ventas">Atención de ventas:</label>
                    <input type="text" name="atencion_ventas" class="form-control" v-model="newItem.atencion_ventas" autocomplete="off"/>
                    <span v-if="formErrors['atencion_ventas']" class="error text-danger">
                        @{{ formErrors['atencion_ventas'] }}
                    </span>
                </div>

                <div class="form-group">
                    <label for="id_banco">Banco:</label>
                    <v-select :value.sync="selectedBanco" :options="banco"  placeholder="Seleccione..."   >
                    </v-select>
                    <span v-if="formErrors['id_banco']" class="error text-danger">
                        @{{ formErrors['id_banco'] }}
                    </span>
                </div>

                <div class="form-group">
                    <label for="CLABE">CLABE:</label>
                    <input type="text" name="CLABE" class="form-control" v-model="newItem.CLABE" autocomplete="off"/>
                    <span v-if="formErrors['CLABE']" class="error text-danger">
                        @{{ formErrors['CLABE'] }}
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
                <h4 class="modal-title" id="myModalLabel">Editar proveedor</h4>
            </div>
            <div class="modal-body">
                <form method="post" enctype="multipart/form-data" v-on:submit.prevent="updateItem(fillItem.id_proveedor)" @keydown.enter.prevent="">
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
                        <label for="razon_social">Razón social:</label>
                        <!--<input type="text" name="razon_social" class="form-control" v-model="newItem.razon_social"    autocomplete="off" />-->
                        <v-select :on-search="razon_social_searchEdit" :value.sync="selectedRazon_socialEdit" :options="razon_social"  >
                        </v-select>
                        <span v-if="formErrors['razon_social']" class="error text-danger">
                            @{{ formErrors['razon_social'] }}
                        </span>
                    </div>

                    <div class="form-group">
                        <label for="rfc">RFC:</label>
                        <input type="text" name="rfc" class="form-control" v-model="fillItem.rfc"   autocomplete="off" />
                        <span v-if="formErrors['rfc']" class="error text-danger">
                            @{{ formErrors['rfc'] }}
                        </span>
                    </div>

                    <div class="form-group">
                        <label for="origen_bienes">Tipo de persona:</label>
                        <select name="tipo_perstipo_personaona" class="form-control" v-model="fillItem.tipo_persona">
                            <option disabled value="">Seleccione...</option>
                            <option value="F">Física</option>
                            <option value="M">Moral</option>
                        </select>
                        <span v-if="formErrors['tipo_persona']" class="error text-danger">
                            @{{ formErrors['tipo_persona'] }}
                        </span>
                    </div>

                    <div class="form-group">
                        <input type="hidden" name="Codigo_pais"  value="223" v-model="fillItem.Codigo_pais"  autocomplete="off"/>
                        <span v-if="formErrors['Codigo_pais']" class="error text-danger">
                            @{{ formErrors['Codigo_pais'] }}
                        </span>
                    </div>

                    <div class="form-group">
                        <label for="Cve_entidad">Entidad:</label>
                        <v-select :value.sync="selectedEntidadEdit" :options="entidad"   >
                        </v-select>

                        <span v-if="formErrors['Cve_entidad']" class="error text-danger">
                            @{{ formErrors['Cve_entidad'] }}
                        </span>
                    </div>

                    <div class="form-group">
                        <label for="Cve_municipio">Municipio:</label>
                        <v-select :value.sync="selectedMunicipioEdit" :options="municipio"   >
                        </v-select>
                        <span v-if="formErrors['Cve_municipio']" class="error text-danger">
                            @{{ formErrors['Cve_municipio'] }}
                        </span>
                    </div>

                    <div class="form-group">
                        <label for="Cve_localidad">Localidad:</label>
                        <v-select :value.sync="selectedLocalidadEdit" :options="localidad" >
                        </v-select>

                        <span v-if="formErrors['Cve_localidad']" class="error text-danger">
                            @{{ formErrors['Cve_localidad'] }}
                        </span>
                    </div>
                    <div class="form-group">
                        <label for="Codigo_postal">Código postal:</label>
                        <v-select :value.sync="selectedCodigo_postalEdit" :options="codigo_postal"  >
                        </v-select>
                        <span v-if="formErrors['Codigo_postal']" class="error text-danger">
                            @{{ formErrors['Codigo_postal'] }}
                        </span>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="telefonos">Telefonos:</label>
                                <input type="text" name="telefonos" class="form-control" v-model="fillItem.telefonos"   autocomplete="off" />
                                <span v-if="formErrors['telefonos']" class="error text-danger">
                                    @{{ formErrors['telefonos'] }}
                                </span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email">Email:</label>
                                <input type="email" name="email" class="form-control" v-model="fillItem.email"  autocomplete="off" />
                                <span v-if="formErrors['email']" class="error text-danger">
                                    @{{ formErrors['email'] }}
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="origen_bienes">Origen de bienes:</label>
                                <select name="origen_bienes" class="form-control" v-model="fillItem.origen_bienes">
                                    <option disabled value="">Seleccione...</option>
                                    <option value="nac">Nacionales</option>
                                    <option value="int">Internacionales</option>
                                </select>

                                <span v-if="formErrors['origen_bienes']" class="error text-danger">
                                    @{{ formErrors['origen_bienes'] }}
                                </span>
                            </div>

                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="limite_credito">Limite de crédito:</label>
                                <input type="number"  min="0" name="limite_credito" class="form-control" v-model="fillItem.limite_credito" autocomplete="off" />
                                <span v-if="formErrors['limite_credito']" class="error text-danger">
                                    @{{ formErrors['limite_credito'] }}
                                </span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="dias_credito">Dias de crédito:</label>
                                <input type="number"  min="0" name="dias_credito" class="form-control" v-model="fillItem.dias_credito" autocomplete="off"  />
                                <span v-if="formErrors['dias_credito']" class="error text-danger">
                                    @{{ formErrors['dias_credito'] }}
                                </span>
                            </div>
                        </div>

                    </div>

                    <div class="form-group">
                        <label for="atencion_pagos">Atención de pagos:</label>
                        <input type="text" name="atencion_pagos" class="form-control" v-model="fillItem.atencion_pagos" autocomplete="off" />
                        <span v-if="formErrors['atencion_pagos']" class="error text-danger">
                            @{{ formErrors['atencion_pagos'] }}
                        </span>
                    </div>

                    <div class="form-group">
                        <label for="atencion_ventas">Atención de ventas:</label>
                        <input type="text" name="atencion_ventas" class="form-control" v-model="fillItem.atencion_ventas" autocomplete="off"/>
                        <span v-if="formErrors['atencion_ventas']" class="error text-danger">
                            @{{ formErrors['atencion_ventas'] }}
                        </span>
                    </div>

                    <div class="form-group">
                        <label for="id_banco">Banco:</label>
                        <v-select :value.sync="selectedBancoEdit" :options="banco">
                        </v-select>
                        <span v-if="formErrors['id_banco']" class="error text-danger">
                            @{{ formErrors['id_banco'] }}
                        </span>
                    </div>

                    <div class="form-group">
                        <label for="CLABE">CLABE:</label>
                        <input type="text" name="CLABE" class="form-control" v-model="fillItem.CLABE" autocomplete="off"/>
                        <span v-if="formErrors['CLABE']" class="error text-danger">
                            @{{ formErrors['CLABE'] }}
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
<script type="text/javascript" src="{{ asset('js/cmp_cat_proveedores.js') }}"></script>


<!--<script type="text/javascript">

$("#entidad").change(function () {
    var entidad = $("#entidad").val();
    $('#municipio').empty();
    $('#municipio').append('<option> Seleccione</option>');

    $('#Codigo_postal').empty();
    $('#Codigo_postal').append('<option> Seleccione</option>');

    $('#localidad').empty();

    $.get('cmp_cat_proveedoresC/entidad/' + entidad, function (data) {
        $.each(data, function (i, value) {
            $('#municipio').append('<option value="' + value.Cve_municipio + '" >' + value.Nom_municipio + '</option>');
        });
    });

});

$("#municipio").change(function () {
    var municipio = $("#municipio").val();
    var entidad = $("#entidad").val();
    $('#localidad').empty();
    $('#localidad').append('<option> Seleccione</option>');
    $('#codigo_postal').empty();
    $('#codigo_postal').append('<option> Seleccione</option>');
    $.get('cmp_cat_proveedoresC/municipio/' + municipio + '/' + entidad, function (data) {
        $.each(data, function (i, value) {
            $('#localidad').append('<option value="' + value.Cve_localidad + '" >' + value.Nom_localidad + '</option>');
        });
    });

    $.get('cmp_cat_proveedoresC/municipio_entidad/' + municipio + '/' + entidad, function (data) {
        $.each(data, function (i, value) {
            $('#codigo_postal').append('<option value="' + value.Codigo_postal + '" >' + '['+ value.Codigo_postal+']' +' '+ value.Tipo_asentamiento+' '+value.Asentamiento+ '</option>');
        });
    });
});

</script>-->
@stop