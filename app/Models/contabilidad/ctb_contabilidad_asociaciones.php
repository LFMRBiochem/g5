<?php
namespace App\Models\contabilidad;
use Illuminate\Database\Eloquent\Model;

class ctb_contabilidad_asociaciones extends Model{
	protected $table = 'ctb_contabilidad_asociaciones';
	protected $primaryKey = 'id_contabilidad_asociacion';
	public $incrementing = true;
	public $timestamps = false;
	public $fillable = [
		'id_cuenta',
		'id_centrocosto',
		'id_conceptofinanciero'
	];
}
