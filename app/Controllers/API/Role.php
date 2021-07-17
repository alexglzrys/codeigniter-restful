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

	public function create()
	{
		try {
			$role = $this->request->getJSON();
			if ($this->model->insert($role)):
				$role->id = $this->model->insertID();
				return $this->respondCreated($role);
			else:
				return $this->failValidationError($this->model->validation->listErrors());
			endif;
		} catch (\Exception $e) {
			return $this->failServerError($e->getMessage());
		}
	}
}
