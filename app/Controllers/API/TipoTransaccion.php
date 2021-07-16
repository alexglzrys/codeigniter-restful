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

	public function delete($id = null)
	{
		try {
			$tipoTransaccionEncontrado = $this->model->find($id);
			if ($tipoTransaccionEncontrado === null)
				return $this->failNotFound('No se localizó el tipo de transacción asociado con el id '.$id);
			if ($this->model->delete($id)):
				return $this->respondDeleted($tipoTransaccionEncontrado);
			else:
				return $this->failServerError('Lo sentimos, ha ocurrido un error interno en el servidor');
			endif;
		} catch (\Exception $e) {
			return $this->failServerError($e->getMessage());
		}
	}

	public function edit($id = null)
	{
		try {
			$tipoTransaccion = $this->model->find($id);
			if ($tipoTransaccion === null)
				return $this->failNotFound('Lo sentimos, no se localizó el tipo de transacción con id '.$id.' solicitado');
			
			return $this->respond($tipoTransaccion);
		} catch (\Exception $e) {
			return $this->failServerError($e->getMessage());
		}
	}

	public function update($id = null)
	{
		try {
			if ($this->model->find($id) === null)
				return $this->failNotFound('Lo sentimosm no se localizó el tipo de transacción solicitado: ' . $id);
			
			$tipoTransaccion = $this->request->getJSON();
			if ($this->model->update($id, $tipoTransaccion)):
				$tipoTransaccion->id = $id;
				return $this->respondUpdated($tipoTransaccion);
			else:
				return $this->failValidationError($this->model->validation->listErrors());
			endif;
		} catch (\Exception $e) {
			return $this->failServerError($e->getMessage());
		}
	}
}
