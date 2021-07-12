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

}
