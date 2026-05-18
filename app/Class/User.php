<?php

namespace App\Class;

class User {

    protected $username;
    protected $password;

    public function login() {
        return "Login berhasil";
    }

    public function logout() {
        return "Logout berhasil";
    }
}