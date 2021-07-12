<?php

namespace App\Models;

use CodeIgniter\Model;

class TipoTransaccionModel extends Model
{
	protected $table                = 'tipo_transaccion';
	protected $primaryKey           = 'id';
	protected $returnType           = 'array';
	protected $allowedFields        = ['descripcion'];

	// Dates
	protected $useTimestamps        = true;
	protected $dateFormat           = 'datetime';
	protected $createdField         = 'created_at';
	protected $updatedField         = 'updated_at';

	// Validation
	protected $validationRules      = [
		'descripcion' => 'required|alpha'
	];
	protected $skipValidation       = false;

}
