<?php

namespace App\Controllers\API;

use App\Models\CuentaModel;
use CodeIgniter\RESTful\ResourceController;

class Cuenta extends ResourceController
{
	public function __construct()
	{
		$this->model = $this->setModel(new CuentaModel());
	}

	public function index()
	{
		$cuentas = $this->model->findAll();
		return $this->respond($cuentas);
	}

	public function create()
	{
		try {
			$cuenta = $this->request->getJSON();
			if ($this->model->insert($cuenta)):
				$cuenta->id = $this->model->insertID();
				return $this->respondCreated($cuenta);
			else:
				return $this->failValidationError($this->model->validation->listErrors());
			endif;
		} catch (\Exception $e) {
			return $this->failServerError($e->getMessage());
		}
	}
}
