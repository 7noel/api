<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\User;
use App\SunatExchange;


class SunatExchangesController extends Controller {

	public function getByDay($fecha)
	{
		if (!$this->validateDate($fecha, 'Y-m-d')) {
			return response()->json(null);
		}
		return response()->json(SunatExchange::where('fecha', '<=', $fecha)->orderBy('fecha','desc')->first());

	}

	public function getByMonth($month)
	{
		if (!$this->validateDate($month, 'Y-m')) {
			return response()->json(null);
		}
		return response()->json(SunatExchange::where('fecha', '<=', $month.'-31')->orderBy('fecha')->get());
	}

	public function validateDate($date, $format)
	{
		$d = \DateTime::createFromFormat($format, $date);
		return $d && $d->format('Y-m-d') === $date;
	}
}
