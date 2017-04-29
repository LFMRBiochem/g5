<?php

namespace App\Models\nomina;

use Illuminate\Database\Eloquent\Model;

class nmn_cat_empleados extends Model {

    //

    protected $table = 'nmn_cat_empleados';
    public $fillable = [ 'cve_compania', 'num_empleado', 'nombre_empleado', 'primer_apellido',
                    'segundo_apellido', 'codigo_pais', 'cve_entidad', 'cve_municipio',
                    'cve_localidad', 'asentamiento', 'calle_domicilio', 'num_exterior',
                    'num_interior', 'telefono_casa', 'telefono_celular', 'telefono_otro',
                    'correo_electronico', 'rfc', 'curp', 'numero_seguro_social', 'id_centrocosto',
                    'cve_banco', 'cuenta_bancaria', 'id_empleado'];
//    protected $guarded = ['cve_compania'];
    public $incrementing = false;
    public $timestamps = false;
    public $primaryKey = 'id_empleado';

}
