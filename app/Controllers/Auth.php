<?php

namespace App\Controllers;

use App\Models\UsuarioModel;
use CodeIgniter\RESTful\ResourceController;

class Auth extends ResourceController
{
	public function __construct()
	{
		helper(['password', 'jwt']);
	}

	public function login()
	{
		try {
			$usuarioModel = new UsuarioModel();
			
			$username = $this->request->getPost('username');
			$password = $this->request->getPost('password');

			$usuario = $usuarioModel->where('username', $username)->first();
			if ($usuario === null) 
				return $this->failNotFound('Usuario no localizado en el sistema');
			if (!checkPassword($password, $usuario['password']))
				return $this->failNotFound('Contraseña no localizada');
			
			// Generar JWT
			$payload = [
				'aud' => base_url(),	// Que servidor de recursos debe aceptar este token
				'iat' => time(),		// En que momento se emitió este JWT
				'exp' => time() + 180,	// Expira en 60 segundos
				'data' => [
					'nombre' => $usuario['nombre'],
					'username' => $usuario['username'],
					'rol' => $usuario['rol_id']
				]
			];
			$response = ['token' => generateJWT($payload)];
			return $this->respond($response);
		} catch (\Exception $e) {
			return $this->failServerError($e->getMessage());
		}
	}
}
