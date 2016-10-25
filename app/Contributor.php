<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Contributor extends Model {

	protected $fillable = [
        'ruc', 'razon_social', 'estado',
    ];

    public function direccion()
    {
    	return $this->razon_social . " " . $this->razon_social;
    }
}
