@extends('layout.app')

@section('stilous')
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
    textarea{
        resize: none;
    }
</style>
@stop

@section('content')

<div class="form-group row">

    <div class="page-header">
        <h1>Crear orden de compra</h1>
    </div>
    <div class="col-md-12">
        <div class="text-right">
            <button type="button" data-toggle="modal" data-target="#create-item" class="btn btn-primary" v-on:click="guardaOrden">
                <i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar
            </button>
        </div>
    </div>
</div>
<!--modal al guardar-->
<div class="modal fade" id="modalillo2" tabindex="-1"  aria-labelledby="myModalLabel" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Mensaje del sistema</h4>
            </div>
            <div class="modal-body">
                <div class="container-fluid" id="modalillo_content2"></div>
            </div>
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
                        <div class="row">
                            <div class="col-xs-3">
                                <label for="provIder">
                                    Proveedor:
                                </label>
                                <v-select id="provIder" :options="providers"  placeholder="Proveedor..." v-model="selectedProvider" class="our_loops">        
                                </v-select>
                            </div>
                            <div class="col-xs-5">
                                <label for="comentarios">Comentarios de la orden de compra</label><br/>
                                <textarea id="comentarios" rows="2" class="form-control"
                                          placeholder="Ejemplo: Mantenimiento correctivo automóvil Placas ABC-12345. Ajuste de motor" v-model="OrdenEncabezado.comentarios"></textarea>
                            </div>
                            <div class="col-xs-4">
                                <label for="lugar_entrega">Lugar de entrega</label><br/>
                                <textarea id="lugar_entrega" cols="15" rows="2" class="form-control" 
                                          placeholder="Ejemplo: Calle Jesús Romero Flores #3, colonia Constituyentes del parque." v-model="OrdenEncabezado.lugar_entrega"></textarea>
                            </div>
                        </div>   
                        <div class="row">
                            <div class="col-xs-6">
                                <label for="condiciones_entrega">Condiciones de entrega</label><br/>
                                <textarea id="condiciones_entrega" cols="15" rows="2" class="form-control" 
                                          placeholder="Ejemplo: 50% Anticipo del servicio y 50% contra entrega." v-model="OrdenEncabezado.condiciones_entrega"></textarea>
                            </div>
                            <div class="col-xs-6">
                                <label for="condiciones_pago">Condiciones de pago</label><br/>
                                <textarea id="condiciones_pago" cols="15" rows="2" class="form-control" 
                                          placeholder="Ejemplo: 50% Anticipo del servicio y 50% contra entrega." v-model="OrdenEncabezado.condiciones_pago"></textarea>
                            </div>
                        </div>  
                </div><br/>
                <div class="row">
                    <div class="col-md-4">
                        <label for="">
                            <i class='fa fa-plus-circle' aria-hidden='true' style='font-size: 18pt; color:blue;'></i> Conceptos
                        </label>
                        <v-select :options="products" placeholder="Agregar..." v-model="selectedProduct" class="our_loops"></v-select>
                    </div>
                </div><br/>
                <div class="row" id="partidas_solicitud">
                    <div class="col-md-12">
                        <table class="table table-holder table-hover table-striped table-bordered" id="tableConceptos">
                            <thead>
                                <tr id="lu" align='center' class="row">
                                    <th><label class=""><strong>Folio GTIN</strong></label></th>
                                    <th class="col-xs-3"><label class=""><strong>Descripcion Complementaria</strong></label></th>
                                    <th><label class=""><strong>Cantidad</strong></label></th>
                                    <th><label class=""><strong>Precio unitario</strong></label></th>
                                    <th><label class=""><strong>Porcentaje impuesto</strong></label></th>
                                    <th><label class=""><strong>Unidad de medida</strong></label></th>
                                    <th><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</strong></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(rown, index) in rows" class="row">
                                    <td><input name="" id="concep" disabled="disabled" class="form-control" v-model="rown.folio_GTIN_label" /></td>
                                    <td class="col-xs-3"><textarea name="" rows="2" cols="4" id="desc" v-model="rown.descripcion_complementaria" class="form-control" placeholder="Descripci&oacute;n adicional"></textarea></td>
                                    <td class="col-xs-1"><input id="cant" type="text" v-model="rown.cantidad" class="form-control col-xs-1" style="text-align: center; width: auto;" v-on:keypress="isNumber(evt)"></td>
                                    <td><input id="cant" type="text" v-model="rown.precio_unitario" class="form-control" style="text-align: center; width: auto;" v-on:keypress="isNumber(evt)"></td>
                                    <td><input id="cant" type="text" v-model="rown.porcentaje_impuesto" class="form-control" style="text-align: center; width: auto;" v-on:keypress="isNumber(evt)"></td>
                                    <td><input id="cant" type="text" v-model="rown.cve_unidad_medida_label" class="form-control" style="text-align: center; width: auto;" disabled="disabled"></td>
                                    <!--<td><input id="mont" type="text" v-model="row.monto" class="form-control montillo" style="text-align: center; width: auto;" v-on:keypress="isNumber(event)"></td>-->
                                    <td><a v-on:click="removeRow(index)" class="btn btn-danger">Quitar</a></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>                        
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('javascript')
<script type="text/javascript">
    $(document).ready(function(){
        $("#manage-vue").removeClass("container");
        $("#manage-vue").addClass("container-fluid");

        $("#manage-vue").addClass("col-md-10 col-md-offset-1");
     });
</script>
<script type="text/javascript" src="{{ asset('js/cmp_ordenescompra.js') }}"></script>
@stop