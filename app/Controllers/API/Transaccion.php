<?php

namespace App\Controllers\API;

use App\Models\TransaccionModel;
use CodeIgniter\RESTful\ResourceController;

class Transaccion extends ResourceController
{
	public function __construct() 
	{
		$this->model = $this->setModel(new TransaccionModel());
	}

	public function index()
	{
		$transacciones = $this->model->findAll();
		return $this->respond($transacciones);
	}

	public function create() 
	{
		try {
			$transaccion = $this->request->getJSON();
			if ($this->model->insert($transaccion)):
				$transaccion->id = $this->model->insertID();
				return $this->respondCreated($transaccion);
			else:
				return $this->failValidationError($this->model->validation->listErrors());
			endif; 
		} catch (\Exception $e) {
			return $this->failServerError($e->getMessage());
		}
	}
}
