<?php

use Firebase\JWT\JWT;

/**
 * Instalar el siguiente paquete: https://github.com/firebase/php-jwt
 * 
 * 
 *  */

if(!function_exists('generateJWT')) {
    function generateJWT($payload) {
        return JWT::encode($payload, env('jwt.secret'));
    }
}