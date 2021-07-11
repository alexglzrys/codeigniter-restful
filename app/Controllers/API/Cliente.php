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

    public function create() 
    {
        try {
            // Recuperar la data enviada al servidor mediante JSON (esto CI4 lo recupera como un objeto)
            $cliente = $this->request->getJSON();
            //dd($cliente);
            if ($this->model->insert($cliente)):
                // Inyectar el id asociado para este registro en la base de datos
                $cliente->id = $this->model->insertID();
                // Responder con el cliente recientemente registrado.
               return $this->respondCreated($cliente);
            else:
                // Enviar el listado de errores de validación en caso de que no se guarde la info en la base de datos
                return $this->failValidationError($this->model->validation->listErrors());
            endif;
        } catch (\Exception $e) {
            // Respuesta decorada/formateada para errores en API RESTful
            return $this->failServerError('Lo sentimos, se ha presentado un erro interno en el servidor');
        }
    }
}