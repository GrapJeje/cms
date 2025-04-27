<?php

namespace App\Http\Controllers;

use App\Database\Database;

class AuthController
{
    public function handleRequest()
    {
        require_once __DIR__ . '/../../../vendor/autoload.php';
        require_once __DIR__ . '/../../Config/config.php';
        $action = $_POST['action'] ?? '';
        session_start();

        switch ($action) {
            case 'login':
                $this->login();
                break;
            case 'logout':
                $this->logout();
                break;
            case 'register':
                $this->register();
                break;
            default:
                header("Location:" . ROOT_PATH . "/?alert=Invalid auth action");
                exit();
        }
    }

    private function login()
    {
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        if (empty($email) || empty($password)) {
            header("Location:" . ROOT_PATH . "/login?msg=Vul alle velden in");
            exit();
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            header("Location:" . ROOT_PATH . "/login?msg=Ongeldig emailadres");
            exit();
        }

        $user = Database::get('users', ['email' => $email]);

        if (empty($user) || !password_verify($password, $user['password'])) {
            header("Location: " . ROOT_PATH . "/login?msg=Email of wachtwoord is onjuist");
            exit;
        }

        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        header("Location: " . ROOT_PATH . "/?alert=Succesvol ingelogd");
        exit();
    }

    private function logout()
    {
        session_start();
        session_unset();
        session_destroy();

        header("Location: " . ROOT_PATH . "/login?alert=U bent uitgelogd");
        exit();
    }

    private function register()
    {
        $name = $_POST['name'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $second_password = $_POST['second_password'] ?? '';

        if (empty($email) || empty($password) || empty($second_password) || empty($name)) {
            header("Location:" . ROOT_PATH . "/register?msg=Vul alle velden in");
            exit();
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            header("Location:" . ROOT_PATH . "/register?msg=Ongeldig emailadres");
            exit();
        }

        if ($password !== $second_password) {
            header("Location:" . ROOT_PATH . "/register?msg=Wachtwoorden komen niet overeen");
            exit();
        }

        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $_SESSION['user_id'] = Database::addUser([
            'name' => $name,
            'email' => $email,
            'password' => $hashedPassword
        ]);

        header("Location: " . ROOT_PATH . "/?alert=Registratie succesvol");
        $this->login();
        exit();
    }
}

$auth = new AuthController();
$auth->handleRequest();
