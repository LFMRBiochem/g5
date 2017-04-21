@extends('layout.app')
@section('content')
<div class="form-group row add">

    <div class="page-header">
        <h1>Listar proveedores</h1>
    </div>
    <div class="col-md-12">
        <div class="text-right">
            <button type="button" data-toggle="modal" data-target="#create-item" class="btn btn-primary">
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
                        <th>id_proveedor</th>
                        <th>Compañía</th>
                        <th>Centro de costo</th>
                        <th>RFC</th>
                        <th>Razón social</th>
                        <th>Código de pais</th>
                        <th>Entidad</th>
                        <th>Minicipio</th>
                        <th>Localidad</th>
                        <th>Código postal</th>
                        <th>Asentamiento</th>
                        <th>Tipo de Asentamiento</th>
                        <th>Telefonos</th>
                        <th>Email</th>
                        <th>Origen de bienes</th>
                        <th>Limite de crédito</th>
                        <th>Dias de crédito</th>
                        <th>Atención de pagos</th>
                        <th>Atención de ventas</th>
                        <th>Banco</th>
                        <th>CLABE</th>
                        <th>Estatus</th>
                    </tr>
                    <tr v-for="item in items">

                        <td>@{{ id_proveedor}}</td>
                        <td>@{{ cve_compania}}</td>
                        <td>@{{ id_centrocosto}}</td>
                        <td>@{{ rfc}}</td>
                        <td>@{{ razon_social}}</td>
                        <td>@{{ Codigo_pais}}</td>
                        <td>@{{ Cve_entidad}}</td>
                        <td>@{{ Cve_municipio}}</td>
                        <td>@{{ Cve_localidad}}</td>
                        <td>@{{ Codigo_postal}}</td>
                        <td>@{{ Asentamiento}}</td>
                        <td>@{{ Tipo_asentamiento}}</td>
                        <td>@{{ telefonos}}</td>
                        <td>@{{ email}}</td>
                        <td>@{{ origen_bienes}}</td>
                        <td>@{{ limite_credito}}</td>
                        <td>@{{ dias_credito}}</td>
                        <td>@{{ atencion_pagos}}</td>
                        <td>@{{ atencion_ventas}}</td>
                        <td>@{{ id_banco}}</td>
                        <td>@{{ CLABE}}</td>
                        <td>@{{ estatus}}</td>



                        <td>
                            <button class="edit-modal btn btn-warning btn-sm" @click.prevent="editItem(item)">
                                <span class="glyphicon glyphicon-edit"></span> Edit
                            </button>
                            <button class="edit-modal btn btn-danger btn-sm" @click.prevent="deleteItem(item)">
                                <span class="glyphicon glyphicon-trash"></span> Delete
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
<div class="modal fade" id="create-item" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Crear proveedor</h4>
            </div>
            <div class="modal-body">
                <form method="post" enctype="multipart/form-data" v-on:submit.prevent="createItem">
                    <div class="form-group">
                        <label for="id_proveedor">id_proveedor:</label>
                        <input type="text" name="id_proveedor" class="form-control" v-model="newItem.id_proveedor" />
                        <span v-if="formErrors['id_proveedor']" class="error text-danger">
                            @{{ formErrors['id_proveedor'] }}
                        </span>
                    </div>

                    <div class="form-group">
                        <label for="cve_compania">Compañía:</label>
                        <input type="text" name="cve_compania" class="form-control" v-model="newItem.cve_compania" />
                        <span v-if="formErrors['cve_compania']" class="error text-danger">
                            @{{ formErrors['cve_compania'] }}
                        </span>
                    </div>

                    <div class="form-group">
                        <label for="id_centrocosto">Centro de costo:</label>
                        <input type="text" name="id_centrocosto" class="form-control" v-model="newItem.id_centrocosto" />
                        <span v-if="formErrors['id_centrocosto']" class="error text-danger">
                            @{{ formErrors['id_centrocosto'] }}
                        </span>
                    </div>

                    <div class="form-group">
                        <label for="rfc">RFC:</label>
                        <input type="text" name="rfc" class="form-control" v-model="newItem.rfc" />
                        <span v-if="formErrors['rfc']" class="error text-danger">
                            @{{ formErrors['rfc'] }}
                        </span>
                    </div>

                    <div class="form-group">
                        <label for="razon_social">Razón social:</label>
                        <input type="text" name="razon_social" class="form-control" v-model="newItem.razon_social" />
                        <span v-if="formErrors['razon_social']" class="error text-danger">
                            @{{ formErrors['razon_social'] }}
                        </span>
                    </div>

                    <div class="form-group">
                        <!--<label for="Codigo_pais">Codigo_pais:</label>-->
                        <input type="hidden" name="Codigo_pais"  value="223" v-model="newItem.Codigo_pais" />
                        <!--<select class="form-control" name="Codigo_pais" v-model="newItem.Codigo_pais">-->
                        <!--<option selected> Selecciona</option>-->
                        <?php // foreach ($data['dgis_CAT_NACIONALIDAD'] as $fila) { ?>
                            <!--<option value="<?php //  $fila->Codigo_pais                 ?>"> <?php // $fila->Pais.' - '.$fila->Cve_nacionalidad                 ?></option>-->
                        <?php // } ?>
                        <!--</select>--> 


                        <span v-if="formErrors['Codigo_pais']" class="error text-danger">
                            @{{ formErrors['Codigo_pais'] }}
                        </span>
                    </div>

                    <div class="form-group">
                        <label for="Cve_entidad">Entidad:</label>
                        <!--<input type="text" name="Cve_entidad" class="form-control" v-model="newItem.Cve_entidad" />-->
                        <v-select :options="entidades"  :on-search="getEntidad" placeholder="Search Mexican states..." >
                        </v-select>

                        <span v-if="formErrors['Cve_entidad']" class="error text-danger">
                            @{{ formErrors['Cve_entidad'] }}
                        </span>
                    </div>

                    <div class="form-group">
                        <label for="Cve_municipio">Municipio:</label>
                        <!--<input type="text" name="Cve_municipio" class="form-control" v-model="newItem.Cve_municipio" />-->
                        <select class="form-control" id="municipio" name="Cve_municipio" v-model="newItem.Cve_municipio">

                            <option v-for="municipio in municipios">@{{Nom_municipio}}</option>

                        </select> 
                        <span v-if="formErrors['Cve_municipio']" class="error text-danger">
                            @{{ formErrors['Cve_municipio'] }}
                        </span>
                    </div>

                    <div class="form-group">
                        <label for="Cve_localidad">Localidad:</label>
                        <!--<input type="text" name="Cve_localidad" class="form-control" v-model="newItem.Cve_localidad" />-->
                        <select class="form-control" id="localidad" name="Cve_localidad" v-model="newItem.Cve_localidad">
                        </select> 

                        <span v-if="formErrors['Cve_localidad']" class="error text-danger">
                            @{{ formErrors['Cve_localidad'] }}
                        </span>
                    </div>
                    <div class="form-group">
                        <label for="Codigo_postal">Código postal:</label>
                        <!--<input type="text" name="Codigo_postal" class="form-control" v-model="newItem.Codigo_postal" />-->
                        <select class="form-control" id="codigo_postal" name="Codigo_postal" v-model="newItem.Codigo_postal">
                        </select>
                        <span v-if="formErrors['Codigo_postal']" class="error text-danger">
                            @{{ formErrors['Codigo_postal'] }}
                        </span>
                    </div>
                    <!--                    <div class="form-group">
                                            <label for="Asentamiento">Asentamiento:</label>
                                            <input type="text" name="Asentamiento" class="form-control" v-model="newItem.Asentamiento" />
                                            <select class="form-control" id="asentamiento" name="Asentamiento" v-model="newItem.Asentamiento">
                                            </select>
                                            <span v-if="formErrors['Asentamiento']" class="error text-danger">
                                                @{{ formErrors['Asentamiento'] }}
                                            </span>
                                        </div>
                    
                                        <div class="form-group">
                                            <label for="Tipo_asentamiento">Tipo de asentamineto:</label>
                                            <input type="text" name="Tipo_asentamiento" class="form-control" v-model="newItem.Tipo_asentamiento" />
                                            <span v-if="formErrors['Tipo_asentamiento']" class="error text-danger">
                                                @{{ formErrors['Tipo_asentamiento'] }}
                                            </span>
                                        </div>-->

                    <div class="form-group">
                        <label for="telefonos">Telefonos:</label>
                        <input type="text" name="telefonos" class="form-control" v-model="newItem.telefonos" />
                        <span v-if="formErrors['telefonos']" class="error text-danger">
                            @{{ formErrors['telefonos'] }}
                        </span>
                    </div>

                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="text" name="email" class="form-control" v-model="newItem.email" />
                        <span v-if="formErrors['email']" class="error text-danger">
                            @{{ formErrors['email'] }}
                        </span>
                    </div>

                    <div class="form-group">
                        <label for="origen_bienes">Origen de biens:</label>
                        <input type="text" name="origen_bienes" class="form-control" v-model="newItem.origen_bienes" />
                        <span v-if="formErrors['origen_bienes']" class="error text-danger">
                            @{{ formErrors['origen_bienes'] }}
                        </span>
                    </div>

                    <div class="form-group">
                        <label for="limite_credito">Limite de crédito:</label>
                        <input type="text" name="limite_credito" class="form-control" v-model="newItem.limite_credito" />
                        <span v-if="formErrors['limite_credito']" class="error text-danger">
                            @{{ formErrors['limite_credito'] }}
                        </span>
                    </div>

                    <div class="form-group">
                        <label for="dias_credito">Dias de crédito:</label>
                        <input type="text" name="dias_credito" class="form-control" v-model="newItem.dias_credito" />
                        <span v-if="formErrors['dias_credito']" class="error text-danger">
                            @{{ formErrors['dias_credito'] }}
                        </span>
                    </div>

                    <div class="form-group">
                        <label for="atencion_pagos">Atención de pagos:</label>
                        <input type="text" name="atencion_pagos" class="form-control" v-model="newItem.atencion_pagos" />
                        <span v-if="formErrors['atencion_pagos']" class="error text-danger">
                            @{{ formErrors['atencion_pagos'] }}
                        </span>
                    </div>

                    <div class="form-group">
                        <label for="atencion_ventas">Atención de ventas:</label>
                        <input type="text" name="atencion_ventas" class="form-control" v-model="newItem.atencion_ventas" />
                        <span v-if="formErrors['atencion_ventas']" class="error text-danger">
                            @{{ formErrors['atencion_ventas'] }}
                        </span>
                    </div>

                    <div class="form-group">
                        <label for="id_banco">Banco:</label>
                        <input type="text" name="id_banco" class="form-control" v-model="newItem.id_banco" />
                        <span v-if="formErrors['id_banco']" class="error text-danger">
                            @{{ formErrors['id_banco'] }}
                        </span>
                    </div>

                    <div class="form-group">
                        <label for="CLABE">CLABE:</label>
                        <input type="text" name="CLABE" class="form-control" v-model="newItem.CLABE" />
                        <span v-if="formErrors['CLABE']" class="error text-danger">
                            @{{ formErrors['CLABE'] }}
                        </span>
                    </div>



                    <div class="form-group">
                        <button type="submit" class="btn btn-success"><i class="fa fa-plus" aria-hidden="true"></i> Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Edit Item Modal -->
<div class="modal fade" id="edit-item" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Editar proveedor</h4>
            </div>
            <div class="modal-body">
                <form method="post" enctype="multipart/form-data" v-on:submit.prevent="updateItem(fillItem.cve_moneda)">
                    <!--                    <div class="form-group">
                                            <label for="id_proveedor">id_proveedor:</label>
                                            <input type="text" name="id_proveedor" class="form-control" v-model="fillItem.id_proveedor" />
                                            <span v-if="formErrors['id_proveedor']" class="error text-danger">
                                                @{{ formErrors['id_proveedor'] }}
                                            </span>
                                        </div>-->

                    <div class="form-group">
                        <label for="cve_compania">Compañía:</label>
                        <input type="text" name="cve_compania" class="form-control" v-model="fillItem.cve_compania" />
                        <span v-if="formErrors['cve_compania']" class="error text-danger">
                            @{{ formErrors['cve_compania'] }}
                        </span>
                    </div>

                    <div class="form-group">
                        <label for="id_centrocosto">Centro de costo:</label>
                        <input type="text" name="id_centrocosto" class="form-control" v-model="fillItem.id_centrocosto" />
                        <span v-if="formErrors['id_centrocosto']" class="error text-danger">
                            @{{ formErrors['id_centrocosto'] }}
                        </span>
                    </div>

                    <div class="form-group">
                        <label for="rfc">RFC:</label>
                        <input type="text" name="rfc" class="form-control" v-model="fillItem.rfc" />
                        <span v-if="formErrors['rfc']" class="error text-danger">
                            @{{ formErrors['rfc'] }}
                        </span>
                    </div>

                    <div class="form-group">
                        <label for="razon_social">Razón social:</label>
                        <input type="text" name="razon_social" class="form-control" v-model="fillItem.razon_social" />
                        <span v-if="formErrors['razon_social']" class="error text-danger">
                            @{{ formErrors['razon_social'] }}
                        </span>
                    </div>

                    <div class="form-group">
                        <label for="Codigo_pais">Código de pais:</label>
                        <input type="text" name="Codigo_pais" class="form-control" v-model="fillItem.Codigo_pais" />
                        <span v-if="formErrors['Codigo_pais']" class="error text-danger">
                            @{{ formErrors['Codigo_pais'] }}
                        </span>
                    </div>

                    <div class="form-group">
                        <label for="Cve_entidad">Entidad:</label>
                        <input type="text" name="Cve_entidad" class="form-control" v-model="fillItem.Cve_entidad" />
                        <span v-if="formErrors['Cve_entidad']" class="error text-danger">
                            @{{ formErrors['Cve_entidad'] }}
                        </span>
                    </div>

                    <div class="form-group">
                        <label for="Cve_municipio">Municipio:</label>
                        <input type="text" name="Cve_municipio" class="form-control" v-model="fillItem.Cve_municipio" />
                        <span v-if="formErrors['Cve_municipio']" class="error text-danger">
                            @{{ formErrors['Cve_municipio'] }}
                        </span>
                    </div>

                    <div class="form-group">
                        <label for="Cve_localidad">Localidad:</label>
                        <input type="text" name="Cve_localidad" class="form-control" v-model="fillItem.Cve_localidad" />
                        <span v-if="formErrors['Cve_localidad']" class="error text-danger">
                            @{{ formErrors['Cve_localidad'] }}
                        </span>
                    </div>
                    <div class="form-group">
                        <label for="Codigo_postal">Código postal:</label>
                        <input type="text" name="Codigo_postal" class="form-control" v-model="fillItem.Codigo_postal" />
                        <span v-if="formErrors['Codigo_postal']" class="error text-danger">
                            @{{ formErrors['Codigo_postal'] }}
                        </span>
                    </div>
                    <div class="form-group">
                        <label for="Asentamiento">Asentamiento:</label>
                        <input type="text" name="Asentamiento" class="form-control" v-model="fillItem.Asentamiento" />
                        <span v-if="formErrors['Asentamiento']" class="error text-danger">
                            @{{ formErrors['Asentamiento'] }}
                        </span>
                    </div>

                    <div class="form-group">
                        <label for="Tipo_asentamiento">Tipo de asentamiento:</label>
                        <input type="text" name="Tipo_asentamiento" class="form-control" v-model="fillItem.Tipo_asentamiento" />
                        <span v-if="formErrors['Tipo_asentamiento']" class="error text-danger">
                            @{{ formErrors['Tipo_asentamiento'] }}
                        </span>
                    </div>

                    <div class="form-group">
                        <label for="telefonos">Telefono:</label>
                        <input type="text" name="telefonos" class="form-control" v-model="fillItem.telefonos" />
                        <span v-if="formErrors['telefonos']" class="error text-danger">
                            @{{ formErrors['telefonos'] }}
                        </span>
                    </div>

                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="text" name="email" class="form-control" v-model="fillItem.email" />
                        <span v-if="formErrors['email']" class="error text-danger">
                            @{{ formErrors['email'] }}
                        </span>
                    </div>


                    <div class="form-group">
                        <label for="origen_bienes">Origen de bienes:</label>
                        <input type="text" name="origen_bienes" class="form-control" v-model="fillItem.origen_bienes" />
                        <span v-if="formErrors['origen_bienes']" class="error text-danger">
                            @{{ formErrors['origen_bienes'] }}
                        </span>
                    </div>

                    <div class="form-group">
                        <label for="limite_credito">Limite de credito:</label>
                        <input type="text" name="limite_credito" class="form-control" v-model="fillItem.limite_credito" />
                        <span v-if="formErrors['limite_credito']" class="error text-danger">
                            @{{ formErrors['limite_credito'] }}
                        </span>
                    </div>

                    <div class="form-group">
                        <label for="dias_credito">Dias de crédito:</label>
                        <input type="text" name="dias_credito" class="form-control" v-model="fillItem.dias_credito" />
                        <span v-if="formErrors['dias_credito']" class="error text-danger">
                            @{{ formErrors['dias_credito'] }}
                        </span>
                    </div>

                    <div class="form-group">
                        <label for="atencion_pagos">Atención de pagos:</label>
                        <input type="text" name="atencion_pagos" class="form-control" v-model="fillItem.atencion_pagos" />
                        <span v-if="formErrors['atencion_pagos']" class="error text-danger">
                            @{{ formErrors['atencion_pagos'] }}
                        </span>
                    </div>

                    <div class="form-group">
                        <label for="atencion_ventas">Atención de ventas:</label>
                        <input type="text" name="atencion_ventas" class="form-control" v-model="fillItem.atencion_ventas" />
                        <span v-if="formErrors['atencion_ventas']" class="error text-danger">
                            @{{ formErrors['atencion_ventas'] }}
                        </span>
                    </div>

                    <div class="form-group">
                        <label for="id_banco">Banco:</label>
                        <input type="text" name="id_banco" class="form-control" v-model="fillItem.id_banco" />
                        <span v-if="formErrors['id_banco']" class="error text-danger">
                            @{{ formErrors['id_banco'] }}
                        </span>
                    </div>

                    <div class="form-group">
                        <label for="CLABE">CLABE:</label>
                        <input type="text" name="CLABE" class="form-control" v-model="fillItem.CLABE" />
                        <span v-if="formErrors['CLABE']" class="error text-danger">
                            @{{ formErrors['CLABE'] }}
                        </span>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-success"><i class="fa fa-plus" aria-hidden="true"></i> Guardar</button>
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