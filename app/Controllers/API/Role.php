<?php

namespace App\Controllers\API;

use App\Models\RoleModel;
use CodeIgniter\RESTful\ResourceController;

class Role extends ResourceController
{
	public function __construct()
	{
		$this->model = $this->setModel(new RoleModel());
		helper('role');
	}
	
	public function index()
	{
		$roles = $this->model->findAll();
		return $this->respond($roles);
	}

	public function create()
	{
		try {
			// Solo los usuarios con rol de administrador, tienen acceso a este recurso
			if (!allowedRoles(['administrador'], $this->request->getServer('HTTP_AUTHORIZATION')))
				return $this->failServerError('El rol asignado no tiene permisos de acceso a este recurso');

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

	public function delete($id = null)
	{
		try {
			$roleEncontrado = $this->model->find($id);
			if ($roleEncontrado === null)
				return $this->failNotFound('Lo sentimos, el rol solicitado no existe: ' . $id);

			if ($this->model->delete($id)):
				return $this->respondDeleted($roleEncontrado);
			else:
				return $this->failServerError('Error al tratar de eliminar el rol del sitema');
			endif;
		} catch (\Exception $e) {
			return $this->failServerError($e->getMessage());
		}
	}

	public function edit($id = null)
	{
		try {
			$roleEncontrado = $this->model->find($id);
			if ($roleEncontrado === null)
				return $this->failNotFound('Lo sentimos, el rol solicitado no existe: ' . $id);
			else
				return $this->respond($roleEncontrado);
		} catch (\Exception $e) {
			return $this->failServerError($e->getMessage());
		}
	}

	public function update($id = null)
	{
		try {
			if ($this->model->find($id) === null)
				return $this->failNotFound('Lo sentimos, el rol solicitado no existe: ' . $id);

			$role = $this->request->getJSON();
			if ($this->model->update($id, $role)):
				$role->id = $id;
				return $this->respondUpdated($role);
			else:
				return $this->failValidationError($this->model->validation->listErrors());
			endif;
		} catch (\Exception $e) {
			return $this->failServerError($e->getMessage());
		}
	}
}
