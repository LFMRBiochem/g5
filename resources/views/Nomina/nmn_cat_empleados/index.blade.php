@extends('layout.app')
@section('content')
<div class="form-group row add">

    <div class="page-header">
        <h1>Listar nmn_cat_empleados</h1>
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
                        <th>cve_compania</th>
                        <th>num_empleado</th>
                        <th>nombre_empleado</th>
                        <th>primer_apellido</th>
                        <th>segundo_apellido</th>

                        <th>codigo_pais</th>
                        <th>cve_entidad</th>
                        <th>cve_municipio</th>
                        <th>cve_localidad</th>
                        <th>asentamiento</th>

                        <th>calle_domicilio</th>
                        <th>num_exterior</th>
                        <th>num_interior</th>
                        <th>telefono_casa</th>
                        <th>telefono_celular</th>

                        <th>telefono_otro</th>
                        <th>correo_electronico</th>
                        <th>rfc</th>
                        <th>curp</th>
                        <th>numero_seguro_social</th>

                        <th>id_centrocosto</th>
                        <th>cve_banco</th>
                        <th>cuenta_bancaria</th>
                          <th>Actions</th>
                    </tr>
                    <tr v-for="item in items">

                        <th>@{{ item.cve_compania}}</th>
                        <th>@{{ item.num_empleado}}</th>
                        <th>@{{ item.nombre_empleado}}</th>
                        <th>@{{ item.primer_apellido}}</th>
                        <th>@{{ item.segundo_apellido}}</th>

                        <th>@{{ item.codigo_pais}}</th>
                        <th>@{{ item.cve_entidad}}</th>
                        <th>@{{ item.cve_municipio}}</th>
                        <th>@{{ item.cve_localidad}}</th>
                        <th>@{{ item.asentamiento}}</th>

                        <th>@{{ item.calle_domicilio}}</th>
                        <th>@{{ item.num_exterior}}</th>
                        <th>@{{ item.num_interior}}</th>
                        <th>@{{ item.telefono_casa}}</th>
                        <th>@{{ item.telefono_celular}}</th>

                        <th>@{{ item.telefono_otro}}</th>
                        <th>@{{ item.correo_electronico}}</th>
                        <th>@{{ item.rfc}}</th>
                        <th>@{{ item.curp}}</th>
                        <th>@{{ item.numero_seguro_social}}</th>

                        <th>@{{ item.id_centrocosto}}</th>
                        <th>@{{ item.cve_banco}}</th>
                        <th>@{{ item.cuenta_bancaria}}</th>

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
<div class="modal fade" id="create-item" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Create New Post</h4>
            </div>
            <div class="modal-body">
                <form method="post" enctype="multipart/form-data" v-on:submit.prevent="createItem">
                    <div class="form-group">
                        <label for="cve_compania">cve_compania:</label>
                        <input type="text" name="cve_compania" class="form-control" v-model="newItem.cve_compania" />
                        <span v-if="formErrors['cve_compania']" class="error text-danger">
                            @{{ formErrors['cve_compania'] }}
                        </span>
                    </div>
                    <div class="form-group">
                        <label for="num_empleado">num_empleado:</label>
                        <input type="text" name="num_empleado" class="form-control" v-model="newItem.num_empleado" />
                        <span v-if="formErrors['num_empleado']" class="error text-danger">
                            @{{ formErrors['num_empleado'] }}
                        </span>
                    </div>

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
                        <label for="codigo_pais">codigo_pais:</label>
                        <input type="text" name="codigo_pais" class="form-control" v-model="newItem.codigo_pais" />
                        <span v-if="formErrors['codigo_pais']" class="error text-danger">
                            @{{ formErrors['codigo_pais'] }}
                        </span>
                    </div>
                    <div class="form-group">
                        <label for="cve_entidad">cve_entidad:</label>
                        <input type="text" name="cve_entidad" class="form-control" v-model="newItem.cve_entidad" />
                        <span v-if="formErrors['cve_entidad']" class="error text-danger">
                            @{{ formErrors['cve_entidad'] }}
                        </span>
                    </div>
                    <div class="form-group">
                        <label for="cve_municipio">cve_municipio:</label>
                        <input type="text" name="cve_municipio" class="form-control" v-model="newItem.cve_municipio" />
                        <span v-if="formErrors['cve_municipio']" class="error text-danger">
                            @{{ formErrors['cve_municipio'] }}
                        </span>
                    </div>
                    <div class="form-group">
                        <label for="cve_localidad">cve_localidad:</label>
                        <input type="text" name="cve_localidad" class="form-control" v-model="newItem.cve_localidad" />
                        <span v-if="formErrors['cve_localidad']" class="error text-danger">
                            @{{ formErrors['cve_localidad'] }}
                        </span>
                    </div>
                    <div class="form-group">
                        <label for="asentamiento">asentamiento:</label>
                        <input type="text" name="asentamiento" class="form-control" v-model="newItem.asentamiento" />
                        <span v-if="formErrors['asentamiento']" class="error text-danger">
                            @{{ formErrors['asentamiento'] }}
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
                        <input type="text" name="id_centrocosto" class="form-control" v-model="newItem.id_centrocosto" />
                        <span v-if="formErrors['id_centrocosto']" class="error text-danger">
                            @{{ formErrors['id_centrocosto'] }}
                        </span>
                    </div>
                    
                     <div class="form-group">
                        <label for="cve_banco">cve_banco:</label>
                        <input type="text" name="cve_banco" class="form-control" v-model="newItem.cve_banco" />
                        <span v-if="formErrors['cve_banco']" class="error text-danger">
                            @{{ formErrors['cve_banco'] }}
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
                <h4 class="modal-title" id="myModalLabel">Editar usuario</h4>
            </div>
            <div class="modal-body">
                <form method="post" enctype="multipart/form-data" v-on:submit.prevent="updateItem(fillItem.id_empleado)">

                     <div class="form-group">
                        <label for="cve_compania">cve_compania:</label>
                        <input type="text" name="cve_compania" class="form-control" v-model="fillItem.cve_compania" />
                        <span v-if="formErrors['cve_compania']" class="error text-danger">
                            @{{ formErrors['cve_compania'] }}
                        </span>
                    </div>
                    <div class="form-group">
                        <label for="num_empleado">num_empleado:</label>
                        <input type="text" name="num_empleado" class="form-control" v-model="fillItem.num_empleado" />
                        <span v-if="formErrors['num_empleado']" class="error text-danger">
                            @{{ formErrors['num_empleado'] }}
                        </span>
                    </div>

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
                        <label for="codigo_pais">codigo_pais:</label>
                        <input type="text" name="codigo_pais" class="form-control" v-model="fillItem.codigo_pais" />
                        <span v-if="formErrors['codigo_pais']" class="error text-danger">
                            @{{ formErrors['codigo_pais'] }}
                        </span>
                    </div>
                    <div class="form-group">
                        <label for="cve_entidad">cve_entidad:</label>
                        <input type="text" name="cve_entidad" class="form-control" v-model="fillItem.cve_entidad" />
                        <span v-if="formErrors['cve_entidad']" class="error text-danger">
                            @{{ formErrors['cve_entidad'] }}
                        </span>
                    </div>
                    <div class="form-group">
                        <label for="cve_municipio">cve_municipio:</label>
                        <input type="text" name="cve_municipio" class="form-control" v-model="fillItem.cve_municipio" />
                        <span v-if="formErrors['cve_municipio']" class="error text-danger">
                            @{{ formErrors['cve_municipio'] }}
                        </span>
                    </div>
                    <div class="form-group">
                        <label for="cve_localidad">cve_localidad:</label>
                        <input type="text" name="cve_localidad" class="form-control" v-model="fillItem.cve_localidad" />
                        <span v-if="formErrors['cve_localidad']" class="error text-danger">
                            @{{ formErrors['cve_localidad'] }}
                        </span>
                    </div>
                    <div class="form-group">
                        <label for="asentamiento">asentamiento:</label>
                        <input type="text" name="asentamiento" class="form-control" v-model="fillItem.asentamiento" />
                        <span v-if="formErrors['asentamiento']" class="error text-danger">
                            @{{ formErrors['asentamiento'] }}
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
                        <input type="text" name="id_centrocosto" class="form-control" v-model="fillItem.id_centrocosto" />
                        <span v-if="formErrors['id_centrocosto']" class="error text-danger">
                            @{{ formErrors['id_centrocosto'] }}
                        </span>
                    </div>
                    
                     <div class="form-group">
                        <label for="cve_banco">cve_banco:</label>
                        <input type="text" name="cve_banco" class="form-control" v-model="fillItem.cve_banco" />
                        <span v-if="formErrors['cve_banco']" class="error text-danger">
                            @{{ formErrors['cve_banco'] }}
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