@extends('layout.app')
@section('content')

<style>
    .panel-default-transparente{
        background: rgba(255,254,240,0.3);
        border: 0px;

    }

    hr {
        display: block;
        height: 1px;
        border: 0;
        border-top: 1px solid rgba(255,254,240,0.3);
        margin: 1em 0;
        padding: 0; 
    }
    
    .well{
        background: rgba(34,34,34,0.2);
        border: 1px solid rgba(245,245,245,0.2);

    }

    li {
        list-style-type: none
    }
</style>
<div class="row">
    <div class="col-md-1"></div>
    <div class="col-md-4">

        <div class="panel-default-transparente">
            <div class="panel-heading" style="background: rgba(245,245,245,0.5);border: 0px"><a><strong><i class="fa fa-universal-access" aria-hidden="true"></i> Perfiles</strong></a></div>
            <!--<div class="panel-body">-->
            <ul class="list-group">
                <?php foreach ($data['syscat_roles'] as $fila) { ?>
                    <li class="list-group-item"><a href="#" class="text-capitalize" onClick="return checar({<?= implode(',', $fila->Cve_transaccion) ?>})"><i class="fa fa-tags"></i> <?= $fila->Nombre_roll ?></a></li>
                <?php } ?>

                <!--<li class="list-group-item"><a href="#" onClick="return checar({'A.2.1.1.00.00': '1', 'A.2.1.1.01.00': '0'})"><i class="fa fa-tags"></i> Alta de proveedor</a></li>-->

            </ul>
            <!--</div>-->
        </div>

    </div>

    <div class="col-md-1"></div>
    <div class="col-md-5">
        <form action="{{URL::to('/').'/administracion/syscat_usuariostransaccionesC' }}" method="POST">
            <div class="form-group">
                <div class="text-right">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                        <i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar
                    </button>
                    <a class="btn btn-default" href="{{URL::to('/').'/autentificacion/usuarios' }}"><i class="fa fa-power-off" aria-hidden="true"></i> Salir</a>

                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading" style="background: rgba(245,245,245,0.5);border: 0px">
                    <a><strong><i class="fa fa-exchange" aria-hidden="true"></i> Transacciones</strong> <small>{{ $data['syscat_usuarios']->Nombre }}</small></a>
                </div>

                <input type="hidden" name="Cve_usuario" value="<?= $data['syscat_usuarios']->Cve_usuario ?>">

                {{ csrf_field() }}

                <?php foreach ($data['syscat_transacciones'] as $fila) { ?>
                    <?php if (substr($fila->Cve_transaccion, -8) == '.0.00.00') { ?>
                        <div class="col-md-12">
                            <label>
                                <?= $fila->descripcion_corta ?>
                            </label>  
                        </div>

                    <?php } if (substr($fila->Cve_transaccion, -8) == '.00.00' && substr($fila->Cve_transaccion, -8) != '.0.00.00') { ?> 
                        <br><br>        
                        <label><small>
                                <?= $fila->descripcion_corta ?>
                            </small></label>  


                    <?php } if (substr($fila->Cve_transaccion, -8) != '.00.00' && substr($fila->Cve_transaccion, -8) != '.0.00.00') {
                        ?>

                        <label class="checkbox-inline">
                            <input type="checkbox" class="checkbox" name="Cve_transaccion[]" id="<?= str_replace(".", "_", $fila->Cve_transaccion) ?>" value="<?= str_replace(".", "_", $fila->Cve_transaccion) ?>"  <?= ( array_search($fila->Cve_transaccion, $data['syscat_usuariostransacciones']) ) ? 'checked' : '' ?> > <?= $fila->descripcion_corta ?>
                        </label> 


                        <?php
                    }
                }
                ?>

            </div>

            <div class="form-group">
                <div class="text-right">
                    <div class="form-group">
                        <div class="text-right">
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                                <i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar
                            </button>
                            <!--<button type="submit" class="btn btn-primary "><i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar</button>-->
                            <a class="btn btn-default" href="{{URL::to('/').'/autentificacion/usuarios' }}"><i class="fa fa-power-off" aria-hidden="true"></i> Salir</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" data-keyboard="false" data-backdrop="static" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">Guardar perfil</h4>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Guardar las transacciones como un perfil ?</label>
                                <input class="form-control" name="Nombre_roll" value="{{ old('Nombre_roll') }}">
                                <p class="help-block">* Campo requerido si desea guardar el perfil.</p>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-default" name="con_perfil" value="no"><i class="fa fa-power-off" aria-hidden="true"></i> No</button>
                            <button type="submit" class="btn btn-primary" name="con_perfil" value="si"><i class="fa fa-floppy-o" aria-hidden="true"></i> Si</button>
                        </div>
                    </div>
                </div>
            </div>

        </form>
    </div>
    <div class="col-md-1"></div>
</div>
@stop

