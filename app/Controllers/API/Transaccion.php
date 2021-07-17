<?php

namespace App\Controllers\API;

use App\Models\CuentaModel;
use App\Models\ClienteModel;
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

	public function create() 
	{
		try {
			$transaccion = $this->request->getJSON();
			if ($this->model->insert($transaccion)):
				$transaccion->id = $this->model->insertID();
				$transaccion->resultado = $this->actualizarFondoCuenta($transaccion->tipo_transaccion_id, $transaccion->monto, $transaccion->cuenta_id);
				return $this->respondCreated($transaccion);
			else:
				return $this->failValidationError($this->model->validation->listErrors());
			endif; 
		} catch (\Exception $e) {
			return $this->failServerError($e->getMessage());
		}
	}

	public function getTransaccionesPorCliente($id = null)
	{
		try {
			$clienteModel = new ClienteModel();
			if ($clienteModel->find($id) === null)
				return $this->failNotFound('Lo sentimos, no se localizó el cliente con el id solicitado: ' . $id);

			$transaccionesModel = new TransaccionModel();
			$transaccionesCliente = $transaccionesModel->transaccionCliente($id);
			return $this->respond($transaccionesCliente);
		} catch (\Exception $e) {
			return $this->failServerError($e->getMessage());
		}
	}

	private function actualizarFondoCuenta($tipoTransaccion, $monto, $cuentaID) 
	{
		$cuentaModel = new CuentaModel();
		$cuenta = $cuentaModel->find($cuentaID);
		// Hasta este punto, el id de la cuenta ya esta validado y sabemos que existe
		switch ($tipoTransaccion) {
			case 1:
				$cuenta['fondo'] += $monto;
				break;
			case 2:
				$cuenta['fondo'] -= $monto;
				break;
		}
		if ($cuentaModel->update($cuentaID, $cuenta)):
			return ['TransaccionExitosa' => true, 'NuevoFondo' => $cuenta['fondo']];
		else:
			return ['TransaccionExitosa' => false, 'NuevoFondo' => $cuenta['fondo']];
		endif;
	}
}
