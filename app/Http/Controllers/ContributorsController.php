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
				$d .= ' NRO. '.$c->numero;
			} else if ($c->manzana != '-') {
				$d .= ' MZA. '.$c->manzana.' LOTE '.$c->lote;
			} else if ($c->lote != '-') {
				$d .= ' LOTE '.$c->lote;
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

	public function dni($dni)
	{
		// //dd("sds");
		// $endpoint = "http://intranet.cima.com.pe:3000/api/cimapersonal/consultas/dni/".$dni;
		// $ch = curl_init($endpoint);
		// curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		// $json = json_decode(curl_exec($ch));
		// $json = (isset($json->data->apaterno)) ? $json->data : null ;
		// //dd($json);
		// curl_close($ch);
		// return response()->json($json);
		$url = 'https://eldni.com/pe/buscar-por-dni?dni='.$dni;
		$content = file_get_contents($url);
		$steps = explode( '<td class="text-left">' , $content );
		if (isset($steps[3])) {
			$data['dni'] = $dni;
			$data['nombres'] = explode("</td>" , $steps[1] )[0];
			$data['apaterno'] = explode("</td>" , $steps[2] )[0];
			$data['amaterno'] = explode("</td>" , $steps[3] )[0];
			return response()->json($data);
		}
		return response()->json(null);
	}
}
