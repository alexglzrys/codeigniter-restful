<?php

namespace App\Models;

use CodeIgniter\Model;

class TransaccionModel extends Model
{
	protected $table                = 'transaccion';
	protected $primaryKey           = 'id';
	protected $returnType           = 'array';
	protected $allowedFields        = ['cuenta_id', 'tipo_transaccion_id', 'monto'];

	// Dates
	protected $useTimestamps        = true;
	protected $dateFormat           = 'datetime';
	protected $createdField         = 'created_at';
	protected $updatedField         = 'updated_at';

	// Validation
	protected $validationRules      = [
		'cuenta_id' => 'required|numeric|valid_cuenta',
		'tipo_transaccion_id' => 'required|numeric|valid_tipo_transaccion',
		'monto' => 'required|numeric'
	];
	protected $validationMessages   = [
		'cuenta_id' => [
			'valid_cuenta' => 'La cuenta asociada debe ser válida'
		],
		'tipo_transaccion_id' => [
			'valid_tipo_transaccion' => 'El tipo de transacción asociado debe ser válido'
		]
	];
	protected $skipValidation       = false;
}
