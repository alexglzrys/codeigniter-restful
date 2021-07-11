<?php

namespace App\Models;

use CodeIgniter\Model;

class CuentaModel extends Model
{
	protected $table                = 'cuenta';
	protected $primaryKey           = 'id';
	protected $returnType           = 'array';
	protected $allowedFields        = ['moneda', 'fondo', 'cliente_id'];

	// Dates
	protected $useTimestamps        = true;
	protected $dateFormat           = 'datetime';
	protected $createdField         = 'created_at';
	protected $updatedField         = 'updated_at';

	// Validation
	protected $validationRules      = [
		'moneda' 	 => 'required|alpha|min_length[3]|max_length[3]',
		'fondo'  	 => 'required|numeric',
		'cliente_id' => 'required|numeric|valid_client'
	];
	protected $validationMessages   = [
		'moneda' 		=> [
			'required' 		=> 'El formato de moneda es requerido',
			'alpha_space'	=> 'El formato de moneda solo acepta textos',
			'min_length'	=> 'El formato de moneda debe tener al menos 3 caracteres',
			'max_length'	=> 'El formato de moneda debe tener como máximo 3 caracteres'
		],
		'fondo'	 		=> [
			'required' 		=> 'El fondo es un dato requerido',
			'numeric'		=> 'El fondo solo acepta valores numéricos'
		],
		'client_id'		=> [
			'required'		=> 'El cliente asociado es un dato requerido',
			'numeric'		=> 'EL cliente asociado debe ser un valor numérico',
			'valid_client'	=> 'El cliente asociado debe ser válido'
		]
	];
	protected $skipValidation       = false;
}
