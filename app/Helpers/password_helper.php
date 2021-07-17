<?php

if (!function_exists('hashPassword')) {
    function hashPassword($text) {
        return password_hash($text, PASSWORD_BCRYPT);
    }
}
