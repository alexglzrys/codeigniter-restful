<?php

namespace App\Models;

use CodeIgniter\Model;

class UsuarioModel extends Model
{
	
	protected $table                = 'usuario';
	protected $primaryKey           = 'id';
	protected $useAutoIncrement     = true;
	protected $returnType           = 'array';
	protected $allowedFields        = ['nombre', 'username', 'password', 'rol_id'];

	// Dates
	protected $useTimestamps        = true;
	protected $dateFormat           = 'datetime';
	protected $createdField         = 'created_at';
	protected $updatedField         = 'updated_at';

	// Validation
	protected $validationRules      = [
		'nombre' => 'required|alpha_space',
		'username' => 'required|alpha',
		'password' => 'required|min_length[6]',
		'rol_id' => 'required|numeric|valid_role'
	];
	protected $validationMessages   = [
		'rol_id' => [
			'valid_role' => 'El rol asociado debe ser válido'
		]
	];
	protected $skipValidation       = false;

}
