<?php

namespace App\Controllers;

use App\Models\User;
use App\Helpers\Response;

class AuthController
{
    public function listUsers()
    {
        $user = new User();
        $users = $user->getAllUsers();

        return Response::json(200, "Lista de usuarios", $users);
    }

    public function register($request)
    {
        if (!isset($request['name'], $request['email'], $request['password'])) {
            return Response::json(400, "Datos incompletos para el registro de usuario.");
        }

        $user = new User();
        $result = $user->register($request['name'], $request['email'], $request['password']);

        if ($result === false) {
            return Response::json(400, "El correo electrónico ya está registrado.");
        }

        return Response::json(201, "Usuario registrado exitosamente.", $result);
    }

    public function login($request)
    {
        if (!isset($request['email'], $request['password'])) {
            return Response::json(400, "Datos incompletos para el inicio de sesión.");
        }

        $user = new User();
        $result = $user->login($request['email'], $request['password']);

        if (!$result) {
            return Response::json(401, "Credenciales incorrectas.");
        }

        return Response::json(200, "Autenticación exitosa.", ['user' => $result]);
    }
}
