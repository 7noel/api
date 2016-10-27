<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\User;
use App\SunatExchange;


class SunatExchangesController extends Controller {

	public function index($fecha)
	{
		if (!$this->validateDate($fecha)) {
			return response()->json(null);
		}
		return response()->json(SunatExchange::where('fecha','<=',$fecha)->orderBy('fecha','desc')->first());

	}

	public function validateDate($date)
	{
		$d = \DateTime::createFromFormat('Y-m-d', $date);
		return $d && $d->format('Y-m-d') === $date;
	}
}
