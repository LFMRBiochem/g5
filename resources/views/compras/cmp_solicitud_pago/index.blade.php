@extends('layout.app')
@section('content')

<script src="vue-2.2.0/vue.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-theme/0.1.0-beta.10/select2-bootstrap.css">

<div class="form-group row add">

    <div class="page-header">
        <h1>Crear Solicitud de Pago</h1>
    </div>
    <div class="col-md-12">
        <div class="text-right">
            <button type="button" data-toggle="modal" data-target="#create-item" class="btn btn-primary">
                <i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar
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
                    <div class="row">
                        <div class="col-md-3" align="center">
                            <label for="lblTipo">
                                Tipo Solicitud:
                            </label>
                                <select name="sltipo" id="sltipo" class="form-control" v-model="newItem.slTipo">
                                    <?php foreach ($data['ctb_tipos_centros_costo'] as $fila) { ?>
                                    <option value="<?= $fila->cve_tipoCentroCosto ?>"> <?= $fila->tipo_cc ?>
                                    </option>
                                    <?php } ?>
                                </select>
                            <br>
                            <label for="lblBeneficiario">
                                Beneficiario:
                            </label>
                            
                             <!--<input type="text" name="beneficiario" class="form-control" placeholder="Beneficiario..." id="search_text" /> -->

                            <select class="form-control" id="beneficiario" name="beneficiario" v-model="newItem.beneficiario">
                            </select>

                        </div>
                        <div class="col-md-9">
                            <label for="lblConceptos">
                                Conceptos:
                            </label>
                            <!-- <input type="text" name="conceptos" class="form-control" placeholder="Conceptos..." />
                            -->
                            <select class="form-control" id="conceptos" name="conceptos" v-model="newItem.conceptos">
                            </select>

                            <br>

                            <table id="tableConceptos" name="tableConceptos" class="table table-holder" v-model="newItem.tableConceptos">
                                <thead>
                                <tr align='center'>
                                    <td class='warning'><strong>Concepto</strong></td>
                                    <td class='warning'><strong>Descripcion Complementaria</strong></td>
                                    <td class='warning'><strong>Cantidad</strong></td>
                                    <td class='warning'><strong>Monto</strong></td>
                                </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>

                        </div>
                    </div>
                </table>
            </div>
        </div>
    </div>
</div>
@stop

@section('javascript')

<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
    <script type="text/javascript">

        //Inicio para la parte de beneficiarios
        $("#beneficiario").select2({
            theme: "bootstrap",
            width: '100%'
        });
        
            $.get('cmp_solicitud_pagoController/beneficiario', function (data) {
                $.each(data, function (i, value) {
                $('#beneficiario').append('<option value="' + value.id_centro_costo + '" >' + value.nombre_centrocosto + '</option>');
                });
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
            var concepto=$("#concepto").val();
            $('#tableConceptos').append("<tr><td align='center'>"+concepto+"</td><td align='center'><div contenteditable>Descripcion</div></td><td align='center'><div contenteditable>1</div></td><td align='center'><div contenteditable>100</div></td></tr>");
        });
        
    </script>
@stop