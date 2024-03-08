<?php

declare(strict_types=1);
namespace Source\Controllers;
use League\Plates\Engine;
use CoffeeCode\DataLayer\Connect;

class AuthController
{
	private $view;

	public function __construct()
    {   
        $this->view = new Engine(__DIR__."/../../views", "php");
    }

	public function login(): void
    {
        $conn = Connect::getInstance();
   
        if ((!isset($_POST['email']) || $_POST['email'] == '') || (!isset($_POST['password']) || $_POST['password'] == '')) {
            header('HTTP/1.1 401 Authentication Error');
            header('Content-Type: application/json; charset=UTF-8');
            die(json_encode(array('error' => 'Please enter your username and password.', 'code' => 401)));
        }

        if ($stmt = $conn->prepare('SELECT id, name, role, active, password FROM users WHERE email = :email AND active = 1')) {
            $stmt->bindParam(':email', $_POST['email']);
            $stmt->execute();
            $user = $stmt->fetch();
           
            if ($stmt->rowCount() > 0) {
                $password = $user->password;
                if (password_verify($_POST['password'], $password)) {
                    if (!isset($_SESSION)) {
                        session_start();
                    }

                    session_regenerate_id();
                    $_SESSION['is_logged'] = TRUE;
                    // $_SESSION['id'] = $user->id;
                    $_SESSION['name'] = $user->name;
                    $_SESSION['role'] = $user->role;
                    // $_SESSION['active'] = $user->active;
                    // $_SESSION['email'] = $_POST['email'];

                    // checks if the user is admin
                    if ($user->role == 1) {
                        header('HTTP/1.1 200 Authentication OK');
                        die(json_encode(array('result' => BASE_URL.'/posts', 'code' => 200, 'user_name' => $_SESSION['name'])));
                    }
                }else {
                    header('Location: ' . BASE_URL.'/');
                    header('HTTP/1.1 401 Authentication Error');
                    header('Content-Type: application/json; charset=UTF-8');
                    die(json_encode(array('error' => 'Your account and/or password is incorrect, please try again.', 'code' => 401)));
                }
            }else {
                header('Location: ' . BASE_URL.'/');
                header('HTTP/1.1 401 Authentication Error');
                header('Content-Type: application/json; charset=UTF-8');
                die(json_encode(array('error' => 'Your account and/or password is incorrect, please try again.', 'code' => 401)));
            }
        }

        $stmt->close();
    }

    public function logout(): void 
    {
        session_destroy();
        header('Location: ' . BASE_URL.'/');
    }
}