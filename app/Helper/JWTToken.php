<?php

namespace App\Helper;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JWTToken
{
    public static function createToken($userEmail, $userID)
    {
        $key = env('JWT_KEY');

        $payload = [
            'iss' => 'laravel-token',
            'iat' => time(),
            'exp' => time() + 60 * 60,
            'userEmail' => $userEmail,
            'userID' => $userID,
        ];

        return JWT::encode($payload, $key, 'HS256');
    }

    public static function readToken($token)
    {
        try {
            if ($token == null) {
                return 'unauthorized';
            } else {
                $key = env('JWT_KEY');
                JWT::decode($token, new Key($key, 'HS256'));
            }
        } catch (\Exception $e) {
            return 'unauthorized';
        }
    }
}