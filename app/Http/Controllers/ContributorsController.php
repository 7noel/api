<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\User;
use App\Contributor;
use App\Ubigeo;


class ContributorsController extends Controller {

	public function index($ruc)
	{
		if ($c=Contributor::where('ruc',$ruc)->first()) {
			return response()->json([
					'ruc' => $c->ruc,
					'razon_social' => $c->razon_social,
					'estado' => $c->estado,
					'condicion_domicilio' => $c->condicion_domicilio,
					'direccion' => $this->direccion($c),
					'ubigeo' => Ubigeo::where('code', $c->ubigeo)->first()->toArray(),
				]);
		}
		
		return response()->json(null);

	}

	protected function direccion($c){
		$d = '';
		if ($c->nombre_via != '-') {
			$d = $c->tipo_via.' '.$c->nombre_via;
			if ($c->numero != '-') {
				$d .= ' NRO.'.$c->numero;
			} else {
				$d .= ' KM.'.$c->kilometro;
			}
			
		} else {
			$d='MZA. '.$c->manzana.' LOTE '.$c->lote;
		}
		if ($c->departamento != '-') {
			$d .= ' DPTO. '.$c->departamento;
		}
		if ($c->interior != '-') {
			$d .= ' INT. '.$c->interior;
		}
		if ($c->tipo_zona != '-') {
			if ($c->codigo_zona == '----') {
				$d .= ' '.$c->tipo_zona;
			} else {
				$d .= ' '.$c->codigo_zona.' '.$c->tipo_zona;
			}
		}
		return $d;
	}

}
