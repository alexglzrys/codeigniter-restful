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

    public function edit($id = null) 
    {
        try {
            /*if ($id === null)
                return $this->failValidationError('No se ha pasado un id válido');*/
            
            $cliente = $this->model->find($id);

            if ($cliente === null)
                return $this->failNotFound('No se ha encontrado un cliente con el id solicitado: ' . $id);
            
            // Enviar el cliente localizado al cliente API 
            return $this->respond($cliente);
        } catch (\Exception $e) {
            return $this->failServerError('Lo sentimos, se ha presentado un error interno en el servidor');
        }
    }

    public function update($id = null) 
    {
        try {
            // Si el cliente no es localizado, se detiene el proceso de actualización
            if ($this->model->find($id) === null)
                return $this->failNotFound('No se ha encontrado un cliente con el id: ' . $id);

            $cliente = $this->request->getJSON();

            // Actualizar el cliente con la nueva información
            if ($this->model->update($id, $cliente)):
                $cliente->id = $id;
                // Enviar una respuesta formateada con las cabeceras y códigos de estado asociados con la actualización
                return $this->respondUpdated($cliente);
            else:
                return $this->failValidationError($this->model->validation->listErrors());
            endif;
        } catch (\Exception $e) {
            return $this->failServerError('Lo sentimos, se ha presentado un error interno en el servdor');
        }
    }

    public function delete($id = null)
    {
        try {
            $clienteEncontrado = $this->model->find($id);
            if ($clienteEncontrado === null)
                return $this->failNotFound('No se ha encontrado el cliente con el id solicitado: ' . $id);
            
            if ($this->model->delete($id)):
                return $this->respondDeleted($clienteEncontrado);
            else:
                return $this->failServerError('No se pudo eliminar el registro seleccionado');
            endif;
        } catch (\Exception $e) {
            return $this->failServerError('Lo sentimos, ha ocurrido un error interno en el servidor');
        }
    }
}