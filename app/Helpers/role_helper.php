<?php

use App\Models\RoleModel;

if (!function_exists('allowedRoles')) {
    function allowedRoles($roles, $authHeader) {
        // Un recurso puede estar accesible para varios roles
        if (!is_array($roles))
            return false;
        
        helper('jwt');
        
        // Recuperar el JWT enviado en la cabecera de la petición
        $jwt = explode(' ', $authHeader)[1];
        $jwt = decodeJWT($jwt);
        
        // Recuperar la información completa del rol de usuario, con base al rol_id que viaja en el body del JWT
        $roleModel = new RoleModel();
        $rol = $roleModel->find($jwt->data->rol);

        if ($rol === null)
            return false;
        
        // Negar acceso si el rol de usuario no figura en el listado de roles permitidos
        if (!in_array($rol['nombre'], $roles))
            return false;
        
        return true;
    }
}