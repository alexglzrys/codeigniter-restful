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
}
