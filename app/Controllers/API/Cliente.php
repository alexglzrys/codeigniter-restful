<?php namespace App\Controllers\API;

use App\Models\ClienteModel;
use CodeIgniter\RESTful\ResourceController;

class Cliente extends ResourceController
{
    public function __construct()
    {
        // Establecer el modelo que usará el controlador RESTful CI4 para esta sección
        $this->model = $this->setModel(new ClienteModel());
    }

    public function index()
    {
        // Todas las consultas al modelo original, se hacen a través del intermediario (controlador RESTful CI4)
        $clientes = $this->model->findAll();
        // Decorar/Formatear la respuesta de salida (Estandar API RESTful)
        return $this->respond($clientes);
    }
}