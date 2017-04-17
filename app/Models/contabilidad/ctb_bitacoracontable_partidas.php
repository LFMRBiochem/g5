<?php
namespace App\Models\contabilidad;
use Illuminate\Database\Eloquent\Model;

class ctb_bitacoracontable_partidas extends Model{
	protected $table = 'ctb_bitacoracontable_partidas';
	protected $primaryKey = ['id_foliobitacora', 'num_partida'];
	public $incrementing = false;
	public $timestamps = false;
	public $fillable = [
		'id_foliobitacora',
		'num_partida',
		'id_contabilidad_asociacion',
		'debe_haber',
		'importe',
		'observaciones'
	];
}
