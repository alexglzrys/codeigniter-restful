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

if (!function_exists('decodeJWT')) {
    function decodeJWT($jwt) {
        return JWT::decode($jwt, env('jwt.secret'), ['HS256']);
    }
}