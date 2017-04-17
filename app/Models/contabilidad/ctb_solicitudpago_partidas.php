<?php
namespace App\Models\contabilidad;
use Illuminate\Database\Eloquent\Model;

class ctb_solicitudpago_partidas extends Model{
	protected $table = 'ctb_solicitudpago_partidas';
	protected $primaryKey = ['id_solicitudpago', 'num_partida'];
	public $incrementing = false;
	public $timestamps = false;
	public $fillable = [
		'id_solicitudpago',
		'num_partida',
		'id_conceptofinanciero',
		'descripcion_adicional',
		'importe_concepto',
	];
}
