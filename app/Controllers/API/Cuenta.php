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

	public function delete($id = null) 
	{
		try {
			$cuentaEncontrada = $this->model->find($id);
			if ($cuentaEncontrada === null) 
				return $this->failNotFound('La cuenta con id ' . $id . ' no fue localizada en el sistema');
			if ($this->model->delete($id)):
				return $this->respondDeleted($cuentaEncontrada);
			else:
				return $this->failServerError('Error al tratar de eliminar la cuenta solicitada');
			endif;
		} catch (\Exception $e) {
			return $this->failServerError($e->getMessage());
		}
	}

	public function edit($id = null)
	{
		try {
			$cuenta = $this->model->find($id);
			if ($cuenta === null)
				return $this->failNotFound('La cuenta con id '.$id. ' no fue localizada en el sistema');
			return $this->respond($cuenta);
		} catch (\Exception $e) {
			return $this->failServerError($e->getMessage());
		}
	}

	public function update($id = null) 
	{
		try {
			
			if ($this->model->find($id) === null)
				return $this->failNotFound('La cuenta con id '.$id.' no fue localizada en el sistema');
			
			$cuenta = $this->request->getJSON();
			if ($this->model->update($id, $cuenta)):
				$cuenta->id = $id;
				return $this->respondUpdated($cuenta);
			else:
				return $this->failValidationError($this->model->validation->listErrors());
			endif;
		} catch (\Exception $e) {
			return $this->failServerError($e->getMessage());
		}
	}
}
