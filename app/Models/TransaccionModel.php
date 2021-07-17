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


	public function transaccionCliente($id) 
	{
		// El builder nos permite realizar consultas más complejas hacia la base de datos
		$builder = $this->db->table($this->table);
		$builder->select('cliente.nombre, cliente.apellido, cuenta.id as NumeroCuenta, transaccion.monto, tipo_transaccion.descripcion as Tipo, transaccion.created_at as FechaTransaccion');
		$builder->join('cuenta', 'cuenta.id = transaccion.cuenta_id');
		$builder->join('cliente', 'cliente.id = cuenta.cliente_id');
		$builder->join('tipo_transaccion', 'tipo_transaccion.id = transaccion.tipo_transaccion_id');
		$builder->where('cliente.id', $id);

		// Ejecutar la consulta
		$query = $builder->get();
		// Retornar los resultados
		return $query->getResult();
	}

}
