@extends('layout.app')
@section('content')
<div class="form-group row add">

    <div class="page-header">
        <h1>Listar empleados</h1>
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
</style>

<div class="row">
    <div class="panel panel-default-transparente">
        <div class="panel-body">
            <div class="table-responsive">
                <table class="table table-borderless">
                    <tr style="background: rgba(245,245,245,0.5);border: 0px">
                        <!--<th>num_empleado</th>-->
                        <th class="text-center">Nombre empleado</th>
                        <th class="text-center">Primer apellido</th>
                        <th class="text-center">Segundo apellido</th>

                        <th class="text-center">Código pais</th>
                        <th class="text-center">Entidad</th>
                        <th class="text-center">Municipio</th>
                        <th class="text-center">Localidad</th>
                        <th class="text-center">Asentamiento</th>

                        <th class="text-center">Calle domicilio</th>
                        <th class="text-center">Número Exterior</th>
                        <th class="text-center">Número Interior</th>
                        <th class="text-center">Teléfono casa</th>
                        <th class="text-center">Teléfono celular</th>

                        <th class="text-center">Teléfono otro</th>
                        <th class="text-center">Correo electrónico</th>
                        <th class="text-center">RFC</th>
                        <th class="text-center">CURP</th>
                        <th class="text-center">Número seguro social</th>

                        <th class="text-center">Centro costo</th>
                        <th class="text-center">Banco</th>
                        <th class="text-center">Cuenta bancaria</th>
                        <th  class="text-center" colspan="2">Acción</th>
                    </tr>
                    <tr v-for="item in items">

                        <!--<th>@{{ item.num_empleado}}</th>-->
                        <th class="text-center">@{{ item.nombre_empleado}}</th>
                        <th class="text-center">@{{ item.primer_apellido}}</th>
                        <th class="text-center">@{{ item.segundo_apellido}}</th>

                        <th class="text-center">@{{ item.codigo_pais}}</th>
                        <th class="text-center">@{{ item.cve_entidad}}</th>
                        <th class="text-center">@{{ item.cve_municipio}}</th>
                        <th class="text-center">@{{ item.cve_localidad}}</th>
                        <th class="text-center">@{{ item.asentamiento}}</th>

                        <th class="text-center">@{{ item.calle_domicilio}}</th>
                        <th class="text-center">@{{ item.num_exterior}}</th>
                        <th class="text-center">@{{ item.num_interior}}</th>
                        <th class="text-center">@{{ item.telefono_casa}}</th>
                        <th class="text-center">@{{ item.telefono_celular}}</th>

                        <th class="text-center">@{{ item.telefono_otro}}</th>
                        <th class="text-center">@{{ item.correo_electronico}}</th>
                        <th class="text-center">@{{ item.rfc}}</th>
                        <th class="text-center">@{{ item.curp}}</th>
                        <th class="text-center">@{{ item.numero_seguro_social}}</th>

                        <th class="text-center">@{{ item.id_centrocosto}}</th>
                        <th class="text-center">@{{ item.cve_banco}}</th>
                        <th class="text-center">@{{ item.cuenta_bancaria}}</th>

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
<div class="modal fade" id="create-item" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Crear empleado</h4>
            </div>
            <div class="modal-body">
                <form method="post" enctype="multipart/form-data" v-on:submit.prevent="createItem">

                    <!--                    <div class="form-group">
                                            <label for="num_empleado">num_empleado:</label>
                                            <input type="text" name="num_empleado" class="form-control" v-model="newItem.num_empleado" />
                                            <span v-if="formErrors['num_empleado']" class="error text-danger">
                                                @{{ formErrors['num_empleado'] }}
                                            </span>
                                        </div>-->

                    <div class="form-group">
                        <label for="nombre_empleado">nombre_empleado:</label>
                        <input type="text" name="nombre_empleado" class="form-control" v-model="newItem.nombre_empleado" />
                        <span v-if="formErrors['nombre_empleado']" class="error text-danger">
                            @{{ formErrors['nombre_empleado'] }}
                        </span>
                    </div>
                    <div class="form-group">
                        <label for="primer_apellido">primer_apellido:</label>
                        <input type="text" name="primer_apellido" class="form-control" v-model="newItem.primer_apellido" />
                        <span v-if="formErrors['primer_apellido']" class="error text-danger">
                            @{{ formErrors['primer_apellido'] }}
                        </span>
                    </div>
                    <div class="form-group">
                        <label for="segundo_apellido">segundo_apellido:</label>
                        <input type="text" name="segundo_apellido" class="form-control" v-model="newItem.segundo_apellido" />
                        <span v-if="formErrors['segundo_apellido']" class="error text-danger">
                            @{{ formErrors['segundo_apellido'] }}
                        </span>
                    </div>


                    <div class="form-group">
                        <input type="hidden" name="codigo_pais"  value="223" v-model="newItem.codigo_pais"  autocomplete="off"/>
                        <span v-if="formErrors['codigo_pais']" class="error text-danger">
                            @{{ formErrors['codigo_pais'] }}
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

                    <div class="form-group">
                        <label for="calle_domicilio">calle_domicilio:</label>
                        <input type="text" name="calle_domicilio" class="form-control" v-model="newItem.calle_domicilio" />
                        <span v-if="formErrors['calle_domicilio']" class="error text-danger">
                            @{{ formErrors['calle_domicilio'] }}
                        </span>
                    </div>
                    <div class="form-group">
                        <label for="num_exterior">num_exterior:</label>
                        <input type="text" name="num_exterior" class="form-control" v-model="newItem.num_exterior" />
                        <span v-if="formErrors['num_exterior']" class="error text-danger">
                            @{{ formErrors['num_exterior'] }}
                        </span>
                    </div>
                    <div class="form-group">
                        <label for="num_interior">num_interior:</label>
                        <input type="text" name="num_interior" class="form-control" v-model="newItem.num_interior" />
                        <span v-if="formErrors['num_interior']" class="error text-danger">
                            @{{ formErrors['num_interior'] }}
                        </span>
                    </div>
                    <div class="form-group">
                        <label for="telefono_casa">telefono_casa:</label>
                        <input type="text" name="telefono_casa" class="form-control" v-model="newItem.telefono_casa" />
                        <span v-if="formErrors['telefono_casa']" class="error text-danger">
                            @{{ formErrors['telefono_casa'] }}
                        </span>
                    </div>
                    <div class="form-group">
                        <label for="telefono_celular">telefono_celular:</label>
                        <input type="text" name="telefono_celular" class="form-control" v-model="newItem.telefono_celular" />
                        <span v-if="formErrors['telefono_celular']" class="error text-danger">
                            @{{ formErrors['telefono_celular'] }}
                        </span>
                    </div>

                    <div class="form-group">
                        <label for="telefono_otro">telefono_otro:</label>
                        <input type="text" name="telefono_otro" class="form-control" v-model="newItem.telefono_otro" />
                        <span v-if="formErrors['telefono_otro']" class="error text-danger">
                            @{{ formErrors['telefono_otro'] }}
                        </span>
                    </div>
                    <div class="form-group">
                        <label for="correo_electronico">correo_electronico:</label>
                        <input type="text" name="correo_electronico" class="form-control" v-model="newItem.correo_electronico" />
                        <span v-if="formErrors['correo_electronico']" class="error text-danger">
                            @{{ formErrors['correo_electronico'] }}
                        </span>
                    </div>
                    <div class="form-group">
                        <label for="rfc">rfc:</label>
                        <input type="text" name="rfc" class="form-control" v-model="newItem.rfc" />
                        <span v-if="formErrors['rfc']" class="error text-danger">
                            @{{ formErrors['rfc'] }}
                        </span>
                    </div>
                    <div class="form-group">
                        <label for="curp">curp:</label>
                        <input type="text" name="curp" class="form-control" v-model="newItem.curp" />
                        <span v-if="formErrors['curp']" class="error text-danger">
                            @{{ formErrors['curp'] }}
                        </span>
                    </div>
                    <div class="form-group">
                        <label for="numero_seguro_social">numero_seguro_social:</label>
                        <input type="text" name="numero_seguro_social" class="form-control" v-model="newItem.numero_seguro_social" />
                        <span v-if="formErrors['numero_seguro_social']" class="error text-danger">
                            @{{ formErrors['numero_seguro_social'] }}
                        </span>
                    </div>
                    <div class="form-group">
                        <label for="id_centrocosto">id_centrocosto:</label>
                        <v-select :on-search="id_centrocosto_search" :value.sync="selectedId_centrocosto" :options="id_centrocosto"  placeholder="Seleccione..."   >
                        </v-select>
                        <span v-if="formErrors['id_centrocosto']" class="error text-danger">
                            @{{ formErrors['id_centrocosto'] }}
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
                        <label for="cuenta_bancaria">cuenta_bancaria:</label>
                        <input type="text" name="cuenta_bancaria" class="form-control" v-model="newItem.cuenta_bancaria" />
                        <span v-if="formErrors['cuenta_bancaria']" class="error text-danger">
                            @{{ formErrors['cuenta_bancaria'] }}
                        </span>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-success">Submit</button>
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
                <h4 class="modal-title" id="myModalLabel">Editar empleado</h4>
            </div>
            <div class="modal-body">
                <form method="post" enctype="multipart/form-data" v-on:submit.prevent="updateItem(fillItem.id_empleado)">

                    <!--                    <div class="form-group">
                                            <label for="num_empleado">num_empleado:</label>
                                            <input type="text" name="num_empleado" class="form-control" v-model="fillItem.num_empleado" />
                                            <span v-if="formErrors['num_empleado']" class="error text-danger">
                                                @{{ formErrors['num_empleado'] }}
                                            </span>
                                        </div>-->

                    <div class="form-group">
                        <label for="nombre_empleado">nombre_empleado:</label>
                        <input type="text" name="nombre_empleado" class="form-control" v-model="fillItem.nombre_empleado" />
                        <span v-if="formErrors['nombre_empleado']" class="error text-danger">
                            @{{ formErrors['nombre_empleado'] }}
                        </span>
                    </div>
                    <div class="form-group">
                        <label for="primer_apellido">primer_apellido:</label>
                        <input type="text" name="primer_apellido" class="form-control" v-model="fillItem.primer_apellido" />
                        <span v-if="formErrors['primer_apellido']" class="error text-danger">
                            @{{ formErrors['primer_apellido'] }}
                        </span>
                    </div>
                    <div class="form-group">
                        <label for="segundo_apellido">segundo_apellido:</label>
                        <input type="text" name="segundo_apellido" class="form-control" v-model="fillItem.segundo_apellido" />
                        <span v-if="formErrors['segundo_apellido']" class="error text-danger">
                            @{{ formErrors['segundo_apellido'] }}
                        </span>
                    </div>

                    <div class="form-group">
                        <input type="hidden" name="codigo_pais"  value="223" v-model="fillItem.codigo_pais"  autocomplete="off"/>
                        <span v-if="formErrors['codigo_pais']" class="error text-danger">
                            @{{ formErrors['codigo_pais'] }}
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

                    <div class="form-group">
                        <label for="calle_domicilio">calle_domicilio:</label>
                        <input type="text" name="calle_domicilio" class="form-control" v-model="fillItem.calle_domicilio" />
                        <span v-if="formErrors['calle_domicilio']" class="error text-danger">
                            @{{ formErrors['calle_domicilio'] }}
                        </span>
                    </div>
                    <div class="form-group">
                        <label for="num_exterior">num_exterior:</label>
                        <input type="text" name="num_exterior" class="form-control" v-model="fillItem.num_exterior" />
                        <span v-if="formErrors['num_exterior']" class="error text-danger">
                            @{{ formErrors['num_exterior'] }}
                        </span>
                    </div>
                    <div class="form-group">
                        <label for="num_interior">num_interior:</label>
                        <input type="text" name="num_interior" class="form-control" v-model="fillItem.num_interior" />
                        <span v-if="formErrors['num_interior']" class="error text-danger">
                            @{{ formErrors['num_interior'] }}
                        </span>
                    </div>
                    <div class="form-group">
                        <label for="telefono_casa">telefono_casa:</label>
                        <input type="text" name="telefono_casa" class="form-control" v-model="fillItem.telefono_casa" />
                        <span v-if="formErrors['telefono_casa']" class="error text-danger">
                            @{{ formErrors['telefono_casa'] }}
                        </span>
                    </div>
                    <div class="form-group">
                        <label for="telefono_celular">telefono_celular:</label>
                        <input type="text" name="telefono_celular" class="form-control" v-model="fillItem.telefono_celular" />
                        <span v-if="formErrors['telefono_celular']" class="error text-danger">
                            @{{ formErrors['telefono_celular'] }}
                        </span>
                    </div>

                    <div class="form-group">
                        <label for="telefono_otro">telefono_otro:</label>
                        <input type="text" name="telefono_otro" class="form-control" v-model="fillItem.telefono_otro" />
                        <span v-if="formErrors['telefono_otro']" class="error text-danger">
                            @{{ formErrors['telefono_otro'] }}
                        </span>
                    </div>
                    <div class="form-group">
                        <label for="correo_electronico">correo_electronico:</label>
                        <input type="text" name="correo_electronico" class="form-control" v-model="fillItem.correo_electronico" />
                        <span v-if="formErrors['correo_electronico']" class="error text-danger">
                            @{{ formErrors['correo_electronico'] }}
                        </span>
                    </div>
                    <div class="form-group">
                        <label for="rfc">rfc:</label>
                        <input type="text" name="rfc" class="form-control" v-model="fillItem.rfc" />
                        <span v-if="formErrors['rfc']" class="error text-danger">
                            @{{ formErrors['rfc'] }}
                        </span>
                    </div>
                    <div class="form-group">
                        <label for="curp">curp:</label>
                        <input type="text" name="curp" class="form-control" v-model="fillItem.curp" />
                        <span v-if="formErrors['curp']" class="error text-danger">
                            @{{ formErrors['curp'] }}
                        </span>
                    </div>
                    <div class="form-group">
                        <label for="numero_seguro_social">numero_seguro_social:</label>
                        <input type="text" name="numero_seguro_social" class="form-control" v-model="fillItem.numero_seguro_social" />
                        <span v-if="formErrors['numero_seguro_social']" class="error text-danger">
                            @{{ formErrors['numero_seguro_social'] }}
                        </span>
                    </div>
                    <div class="form-group">
                        <label for="id_centrocosto">id_centrocosto:</label>
                        <!--<input type="text" name="id_centrocosto" class="form-control" v-model="fillItem.id_centrocosto" />-->
                        <v-select :on-search="id_centrocosto_searchEdit" :value.sync="selectedId_centrocostoEdit" :options="id_centrocosto"  >
                        </v-select>
                        <span v-if="formErrors['id_centrocosto']" class="error text-danger">
                            @{{ formErrors['id_centrocosto'] }}
                        </span>
                    </div>

                    <div class="form-group">
                        <label for="id_banco">Banco:</label>
                        <v-select :value.sync="selectedBancoEdit" :options="banco"  >
                        </v-select>
                        <span v-if="formErrors['id_banco']" class="error text-danger">
                            @{{ formErrors['id_banco'] }}
                        </span>
                    </div>

                    <div class="form-group">
                        <label for="cuenta_bancaria">cuenta_bancaria:</label>
                        <input type="text" name="cuenta_bancaria" class="form-control" v-model="fillItem.cuenta_bancaria" />
                        <span v-if="formErrors['cuenta_bancaria']" class="error text-danger">
                            @{{ formErrors['cuenta_bancaria'] }}
                        </span>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-success">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@stop

@section('javascript')
<script type="text/javascript" src="{{ asset('js/nmn_cat_empleados.js') }}"></script>
@stop