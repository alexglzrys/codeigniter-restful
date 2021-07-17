<?php

if (!function_exists('hashPassword')) {
    function hashPassword($text) {
        return password_hash($text, PASSWORD_BCRYPT);
    }
}

if (!function_exists('checkPassword')) {
    function checkPassword($password, $hash) {
        return password_verify($password, $hash);
    }
}
