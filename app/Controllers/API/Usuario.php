<?php

namespace App\Controllers\API;

use App\Models\UsuarioModel;
use CodeIgniter\RESTful\ResourceController;

class Usuario extends ResourceController
{
	public function __construct()
	{
		helper('password');
		$this->model = $this->setModel(new UsuarioModel());
	}

	public function index()
	{
		$usuarios = $this->model->findAll();
		return $this->respond($usuarios);
	}

	public function create()
	{
		try {
			$usuario = $this->request->getJSON();
			$usuario->password = hashPassword($usuario->password);
			if ($this->model->insert($usuario)):
				$usuario->id = $this->model->insertID();
				return $this->respondCreated($usuario);
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
			$usuarioEncontrado = $this->model->find($id);
			if ($usuarioEncontrado === null)
				return $this->failNotFound('Lo sentimos, no se encontró el usuario solicitado: ' . $id);
			if ($this->model->delete($id))
				return $this->respondDeleted($usuarioEncontrado);
			return $this->failServerError('Error al tratar de eliminar el usuario');
		} catch (\Exception $e) {
			return $this->failServerError($e->getMessage());
		}
	}
}
