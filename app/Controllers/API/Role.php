<?php

namespace App\Controllers\API;

use App\Models\RoleModel;
use CodeIgniter\RESTful\ResourceController;

class Role extends ResourceController
{
	public function __construct()
	{
		$this->model = $this->setModel(new RoleModel());
	}
	public function index()
	{
		$roles = $this->model->findAll();
		return $this->respond($roles);
	}
}
