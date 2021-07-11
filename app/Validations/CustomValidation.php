<?php

namespace App\Validations;

use App\Models\ClienteModel;

class CustomValidation
{
    /**
     * Verificar que el id pasado como argumento al método, 
     * corresponda a un ID de cliente registrado previamente en la base de datos.
     * 
     * Nota: registrar esta clase en App/Config/Validation.php
     */
    public function valid_client($id = null): bool
    {
        $clienteModel = new ClienteModel();

        $cliente = $clienteModel->find($id);
        return ($cliente === null) ? false : true;
    }
}