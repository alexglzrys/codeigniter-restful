<?php

namespace App\Controllers\API;

use App\Models\TipoTransaccionModel;
use CodeIgniter\RESTful\ResourceController;

class TipoTransaccion extends ResourceController
{
	public function __construct()
	{
		$this->model = $this->setModel(new TipoTransaccionModel());
	}

	public function index()
	{
		$tiposTransaccion = $this->model->findAll();
		return $this->respond($tiposTransaccion);
	}


	public function create()
	{
		try {
			$tipoTransaccion = $this->request->getJSON();
			if ($this->model->insert($tipoTransaccion)):
				$tipoTransaccion->id = $this->model->insertID();
				return $this->respondCreated($tipoTransaccion);
			else:
				return $this->failValidationError($this->model->validation->listErrors());
			endif;
		} catch (\Exception $e) {
			return $this->failServerError($e->getMessage());
		}
	}
}
