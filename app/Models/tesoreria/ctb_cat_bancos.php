<?php
namespace App\Models\tesoreria;
use Illuminate\Database\Eloquent\Model;

class ctb_cat_bancos extends Model{
	protected $table = 'ctb_cat_bancos';
	protected $primaryKey = 'id_banco';
	public $incrementing = true;
	public $timestamps = false;
	public $fillable = [
		'cve_banco',
		'nom_banco',
		'nom_corto_banco'
	];
}
