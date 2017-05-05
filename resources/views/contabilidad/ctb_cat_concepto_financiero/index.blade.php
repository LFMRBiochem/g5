@extends('layout.app')
@section('content')
<div class="form-group row add">

    <div class="page-header">
        <h1>Listar concepto financiero</h1>
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
                        <th>cve_concepto_financiero</th>
                        <th>catalogo_sat</th>
                        <th>nombre_concepto</th>
                        <th>Actions</th>

                    </tr>
                    <tr v-for="item in items">
                        <td>@{{ item.cve_concepto_financiero }}</td>
                        <td>@{{ item.catalogo_sat }}</td>
                        <td>@{{ item.nombre_concepto }}</td>
                        <td>
                            <button class="edit-modal btn btn-warning btn-sm" @click.prevent="editItem(item)">
                                <span class="glyphicon glyphicon-edit"></span> Editar
                            </button>
                            <button class="edit-modal btn btn-danger btn-sm" @click.prevent="deleteItem(item)">
                                <span class="glyphicon glyphicon-trash"></span> Cancelar
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
                        <label for="cve_concepto_financiero">cve_concepto_financiero:</label>
                        <input type="text" name="cve_concepto_financiero" class="form-control" v-model="newItem.cve_concepto_financiero" />
                        <span v-if="formErrors['cve_concepto_financiero']" class="error text-danger">
                            @{{ formErrors['cve_concepto_financiero'] }}
                        </span>
                    </div>

                    <div class="form-group">
                        <label for="catalogo_sat">catalogo_sat:</label>
                        <input type="text" name="catalogo_sat" class="form-control" v-model="newItem.catalogo_sat" />
                        <span v-if="formErrors['catalogo_sat']" class="error text-danger">
                            @{{ formErrors['catalogo_sat'] }}
                        </span>
                    </div>

                    <div class="form-group">
                        <label for="nombre_concepto">nombre_concepto:</label>
                        <input type="text" name="nombre_concepto" class="form-control" v-model="newItem.nombre_concepto" />
                        <span v-if="formErrors['nombre_concepto']" class="error text-danger">
                            @{{ formErrors['nombre_concepto'] }}
                        </span>
                    </div>

                    <div class="form-group">
                        <label for="naturaleza">naturaleza:</label>
                        <input type="text" name="naturaleza" class="form-control" v-model="newItem.naturaleza" />
                        <span v-if="formErrors['naturaleza']" class="error text-danger">
                            @{{ formErrors['naturaleza'] }}
                        </span>
                    </div>

                    <div class="form-group">
                        <label for="estatus">estatus:</label>
                        <input type="text" name="estatus" class="form-control" v-model="newItem.estatus" value="A" readonly/>
                        <span v-if="formErrors['estatus']" class="error text-danger">
                            @{{ formErrors['estatus'] }}
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
                <form method="post" enctype="multipart/form-data" v-on:submit.prevent="updateItem(fillItem.cve_moneda)">
                    <div class="form-group">
                        <label for="cve_compania">cve_compania:</label>
                        <input type="text" name="cve_compania" class="form-control" v-model="fillItem.cve_compania" />
                        <span v-if="formErrors['cve_compania']" class="error text-danger">
                            @{{ formErrors['cve_compania'] }}
                        </span>
                    </div>

                    <div class="form-group">
                        <label for="cve_concepto_financiero">cve_concepto_financiero:</label>
                        <input type="text" name="cve_concepto_financiero" class="form-control" v-model="fillItem.cve_concepto_financiero" />
                        <span v-if="formErrors['cve_concepto_financiero']" class="error text-danger">
                            @{{ formErrors['cve_concepto_financiero'] }}
                        </span>
                    </div>

                    <div class="form-group">
                        <label for="catalogo_sat">catalogo_sat:</label>
                        <input type="text" name="catalogo_sat" class="form-control" v-model="fillItem.catalogo_sat" />
                        <span v-if="formErrors['catalogo_sat']" class="error text-danger">
                            @{{ formErrors['catalogo_sat'] }}
                        </span>
                    </div>

                    <div class="form-group">
                        <label for="nombre_concepto">nombre_concepto:</label>
                        <input type="text" name="nombre_concepto" class="form-control" v-model="fillItem.nombre_concepto" />
                        <span v-if="formErrors['nombre_concepto']" class="error text-danger">
                            @{{ formErrors['nombre_concepto'] }}
                        </span>
                    </div>

                    <div class="form-group">
                        <label for="naturaleza">naturaleza:</label>
                        <input type="text" name="naturaleza" class="form-control" v-model="fillItem.naturaleza" />
                        <span v-if="formErrors['naturaleza']" class="error text-danger">
                            @{{ formErrors['naturaleza'] }}
                        </span>
                    </div>

                    <div class="form-group">
                        <label for="estatus">estatus:</label>
                        <input type="text" name="estatus" class="form-control" v-model="fillItem.estatus" value="1" readonly/>
                        <span v-if="formErrors['estatus']" class="error text-danger">
                            @{{ formErrors['estatus'] }}
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
<script type="text/javascript" src="{{ asset('js/ctb_cat_concepto_financiero.js') }}"></script>
@stop