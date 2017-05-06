<?php
namespace App\Models\contabilidad;
use Illuminate\Database\Eloquent\Model;

class ctb_cat_concepto_financiero extends Model{
	protected $table = 'ctb_cat_concepto_financiero';
	protected $primaryKey = 'id_conceptofinanciero';
	public $incrementing = true;
	public $timestamps = false;
	public $fillable = [
		'cve_compania',
		'cve_concepto_financiero',
		'catalogo_sat',
		'nombre_concepto',
		'naturaleza',
		'estatus'
	];
	public static function getConceptos($catalogo_sat){
		$cuentas = DB::table('ctb_cat_concepto_financiero')
			->select('id_conceptofinanciero as id_cuenta', 'cve_concepto_financiero as cuenta_contable', 'naturaleza', 'nombre_concepto as descripcion', "'MXN' as cve_moneda", 'estatus')
			->where([
					['cve_compania', '019'],
					['catalogo_sat', 'like', $catalogo_sat.'.%']
				])
			->get();
		return $cuentas;
	}

	public static function getConceptoFinanciero(){
		$conceptoF=DB::table('ctb_cat_concepto_financiero')
		->select(DB::raw('MAX(cve_concepto_financiero) as maximo'))
		->where([
					['cve_compania', '019'],
					['cve_concepto_financiero', '>=', '601'],
					['cve_concepto_financiero', '<', '602']
				])
		->first();
		return $conceptoF;
	}

	public static function insert_concepto_financiero($data){
		return DB::table('ctb_cat_concepto_financiero')
                        ->insertGetId($data);
	}
}
