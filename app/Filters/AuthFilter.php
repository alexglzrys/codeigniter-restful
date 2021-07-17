<?php

namespace App\Filters;

use Config\Services;
use CodeIgniter\API\ResponseTrait;
use Firebase\JWT\ExpiredException;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use Firebase\JWT\SignatureInvalidException;

class AuthFilter implements FilterInterface
{
	use ResponseTrait;

	public function __construct()
	{
		helper('jwt');
	}

	/**
	 * Do whatever processing this filter needs to do.
	 * By default it should not return anything during
	 * normal execution. However, when an abnormal state
	 * is found, it should return an instance of
	 * CodeIgniter\HTTP\Response. If it does, script
	 * execution will end and that Response will be
	 * sent back to the client, allowing for error pages,
	 * redirects, etc.
	 *
	 * @param RequestInterface $request
	 * @param array|null       $arguments
	 *
	 * @return mixed
	 */
	public function before(RequestInterface $request, $arguments = null)
	{
		// Se ejecuta antes que el controlador
		try {
			// Obtener la cabecera de autorización enviada al servidor
			$authHeader = $request->getServer('HTTP_AUTHORIZATION');
			if ($authHeader === null) 
				return Services::response()->setStatusCode(ResponseInterface::HTTP_UNAUTHORIZED, 'No se ha enviado un token');
			
			// El token JWT se envia como: Bearer jskajkajskajskajskajskajskas. Por tanto para recuperarlo necesitamos convertirlo en un array
			$jwt = explode(' ', $authHeader)[1];

			// Verificar que el token sea válido. Caso contrario la librería lanza una excepción, misma que se debe atrapar para personalizar el error
			$decoded = decodeJWT($jwt);

		} catch (ExpiredException $e) {
			return Services::response()->setStatusCode(ResponseInterface::HTTP_UNAUTHORIZED, 'El token enviado ha expirado');
		} catch (SignatureInvalidException $e) {
			return Services::response()->setStatusCode(ResponseInterface::HTTP_UNAUTHORIZED, 'El token no es válido');
		} catch (\Exception $e) {
			// Llamar al servicio de respuesta, y enviar el código de estado con un mensaje de lo que pasó
			return Services::response()->setStatusCode(ResponseInterface::HTTP_INTERNAL_SERVER_ERROR, 'Ocurrió un errorn interno en el servidor');
		}
	}

	/**
	 * Allows After filters to inspect and modify the response
	 * object as needed. This method does not allow any way
	 * to stop execution of other after filters, short of
	 * throwing an Exception or Error.
	 *
	 * @param RequestInterface  $request
	 * @param ResponseInterface $response
	 * @param array|null        $arguments
	 *
	 * @return mixed
	 */
	public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
	{
		// Se ejecuta después del controlador
	}
}
