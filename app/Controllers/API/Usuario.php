<?php

namespace App\Controllers\API;

use App\Models\UsuarioModel;
use CodeIgniter\RESTful\ResourceController;

class Usuario extends ResourceController
{
	public function __construct()
	{
		$this->model = $this->setModel(new UsuarioModel());
	}

	public function index()
	{
		$usuarios = $this->model->findAll();
		return $this->respond($usuarios);
	}
}
