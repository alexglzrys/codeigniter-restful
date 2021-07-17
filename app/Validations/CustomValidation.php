<?php

namespace App\Validations;

use App\Models\CuentaModel;
use App\Models\ClienteModel;
use App\Models\TipoTransaccionModel;

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

    public function valid_cuenta($id = null): bool 
    {
        $cuentaModel = new CuentaModel();

        $cuenta = $cuentaModel->find($id);
        return ($cuenta === null) ? false : true;
    }

    public function valid_tipo_transaccion($id = null): bool
    {
        $tipoTransaccionModel = new TipoTransaccionModel();

        $tipoTransaccion = $tipoTransaccionModel->find($id);
        return ($tipoTransaccion === null) ? false : true;
    }
}