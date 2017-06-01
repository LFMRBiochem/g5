@extends('layout.app')

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

    #lu{
        background: rgba(245,245,245,0.5);border: 0px;
    }
</style>
@section('content')

<!--<script src="vue-2.2.0/vue.js"></script>-->
<!--<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-theme/0.1.0-beta.10/select2-bootstrap.css">-->

<div class="form-group row add">

    <div class="page-header">
        <h1>Crear Solicitud de Pago</h1>
    </div>
    <div class="col-md-12">
        <div class="text-right">
            <button type="button" data-toggle="modal" data-target="#create-item" class="btn btn-primary" v-on:click="guardaSolicitudPago">
                <i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar
            </button>
        </div>
    </div>
</div>
<div class="modal fade" id="modalillo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Mensaje del sistema</h4>
            </div>
            <div class="modal-body">
                <div class="container-fluid" id="modalillo_content"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-power-off" aria-hidden="true"></i> Aceptar</button>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="panel panel-default-transparente col-md-12">
        <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table">
                                <tr>
                                    <td>
                                        <label for="lblTipo">
                                            Tipo Solicitud:
                                        </label>
                                        <select class="form-control" v-model="newItem.tipo_orden">
                                            <option value="Seleccione" selected="selected">Seleccione..</option>
                                            <?php foreach ($data['ctb_tipos_centros_costo'] as $fila) { ?>
                                            <option value="<?= $fila->cve_tipoCentroCosto ?>"> <?= $fila->tipo_cc ?>
                                            </option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                    <td>
                                        <label for="lblBeneficiario">
                                            Beneficiario:
                                        </label>
                                        <v-select :options="id_centroscostos"  placeholder="Beneficiario..." v-model="selectedId_centrocosto">                 
                                        </v-select>
                                    </td>
                                    <td>
                                        <label for="comments_solicitud">Comentarios de la solicitud</label><br/>
                                        <textarea id="comments_solicitud" cols="30" rows="3" class="form-control" v-model="newItem.comentarios"></textarea>
                                    </td>
                                    <td></td>
                                    <td></td>
                                </tr>                         
                            </table>    
                        </div>
                    <div class="row" id="partidas_solicitud" style="/*display: none;">
                        <div class="col-md-12">                            
                            <!--<table id="tableConceptos" name="tableConceptos" class="table table-holder" v-model="newItem.tableConceptos">-->
                            <table class="table table-holder table-hover table-striped sortable" id="tableConceptos">
                                <thead>
                                <tr id="lu" align='center'>
                                    <td><strong>Concepto</strong></td>
                                    <td><strong>Descripcion<br/>Complementaria</strong></td>
                                    <td><strong>Cantidad</strong></td>
                                    <td><strong>Monto</strong></td>
                                    <td><strong>&nbsp;</strong></td>
                                </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(row, index) in rows">
                                        <td><input type="text" v-model="row.concepto" class="form-control" style="text-align: center; width: auto;" disabled="disabled"></td>
                                        <td><input type="text" v-model="row.descrip" class="form-control" style="text-align: center; width: auto;"></td>
                                        <td><input type="text" v-model="row.cantidad" class="form-control" style="text-align: center; width: auto;" v-on:keypress="isNumber(event)"></td>
                                        <td><input type="text" v-model="row.monto" class="form-control montillo" style="text-align: center; width: auto;" v-on:keypress="isNumber(event)"></td>
                                        <td><a v-on:click="removeRow(index)" class="btn btn-danger">Quitar</a></td>
                                    </tr>
                                    <tr><td colspan="3">
                                        <label for="lblConceptos">
                                            <i class='fa fa-plus-circle' aria-hidden='true' style='font-size: 18pt; color:blue;'></i>Agregar Conceptos
                                        </label>
                                        <v-select :options="conceptos_financieros"  placeholder="Concepto..." v-model="selectedConcepto">     
                                        <i class='fa fa-plus-circle' aria-hidden='true' style='font-size: 18pt;'></i>            
                                        </v-select></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>                        
                    </div>
        </div>
    </div>
</div>
@stop

@section('javascript')
<script type="text/javascript" src="{{ asset('js/cmp_solicitudpago.js') }}"></script>
    <script type="text/javascript">
     
        //Inicio para la parte de beneficiarios
        /*$("#beneficiario").select2({
            theme: "bootstrap",
            width: '100%'
        });
        
            $.get('cmp_solicitud_pagoController/beneficiario', function (data) {
                $.each(data, function (i, value) {
                $('#beneficiario').append('<option value="' + value.id_centrocosto + '" >' + value.nombre_centrocosto + '</option>');
                });
            });

        $("#beneficiario").change(function(){
            var rt=$(this).val();
            $("#benefit").val(rt);
        });

        //Inicio para la parte de conceptos
        $("#conceptos").select2({
            theme: "bootstrap",
            width: '100%'
        });

            $.get('cmp_solicitud_pagoController/conceptos', function (data) {
                $.each(data, function (i, value) {
                  $('#conceptos').append('<option value="' + value.id_conceptofinanciero + '" >' + value.nombre_concepto + '</option>');  
                });
            });

        $("#conceptos").change(function(){
            var concepto=$("#conceptos").val();
            $('#tableConceptos').append("<tr><td align='center'>"+concepto+"</td><td align='center'><div contenteditable>Descripci&oacute;n</div></td><td align='center'><div contenteditable>1</div></td><td align='center'><div contenteditable>100</div></td></tr>");
        });
        */
    </script>
@stop