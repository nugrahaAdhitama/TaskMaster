<?php

use App\Core\Notification;

class AuthController {

    public function __construct(private $app) {}

    public function index() {
        $data["title"] = APP_NAME." - Welcome";
        return $this->app->view('auth/index', $data);
    }

    public function register() {
        if ( isset($_POST["submit"]) ) {
            $fields = ['nama', 'email', 'password'];
            if ( array_filter(array_map(fn($f) => !array_key_exists($f, $_POST) || !$_POST[$f], $fields)) )
                Notification::alert("ERROR: Invalid field submitted!", "auth/register");
            foreach ($fields as $field) $$field = $_POST[$field];

            $user = $this->app->model('Auth');
            !$user->isEmailRegistered($email)?
                :Notification::alert("WARNING: User `$email` is already registered!", "auth/register");

            $isRegistered = $user->register($nama, $email, $password);

            Notification::alert($isRegistered?
                "SUCCESS: New user `$email` is registered!" : "ERROR: Failed to register a new user!",
                "auth/login"
            );
        }

        return $this->app->view('auth/register');
    }

    public function login() {
        $email       = @$_POST['email'];
        $password    = @$_POST['password'];
        $isAccepted  = $_SERVER['REQUEST_METHOD'] === 'POST';

        if ( $isAccepted && isset($_POST["submit"], $email, $password) ) {
            $user = $this->app->model('Auth')->login($email, $password);
            $user ?: Notification::alert("ERROR: Invalid email or password! Please try again.", "auth/login");

            // Login berhasil, simpan user dalam session dan alihkan ke halaman utama
            session_start();
            $_SESSION["user"] = $user;
            $_SESSION["KEY"]  = $user["id"];
            header("Location: ".BASE_URI."dashboard");   
        }

        return $this->app->view('auth/login');
    }

    public function logout() {
        session_destroy();
        return header("Location: ".BASE_URI."auth/login");
    }
    
}
