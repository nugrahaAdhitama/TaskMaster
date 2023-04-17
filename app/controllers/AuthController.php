<?php

class AuthController {

    public function __construct(private $app) {}

    public function index() {
        $data["title"] = APP_NAME." - Welcome";
        return $this->app->view('auth/index', $data);
    }

    public function register() {
        if ( isset($_POST["submit"]) ) {
            $fields = ['nama', 'email', 'password'];
            foreach ($fields as $field) {
                if ( !array_key_exists($field, $_POST) || !$_POST[$field] ) {
                    echo "ERROR: Invalid field submitted!";
                    return header("Refresh: 2; URL=".BASE_URI."auth/register");
                }
                $$field = $_POST[$field];
            }

            $user = $this->app->model('Auth');
            if ( $user->isEmailRegistered($email) ) {
                echo "WARNING: User `$email` is already registered!";
                header("Refresh: 2; URL=".BASE_URI."auth/register");
                return false;
            }

            $isRegistered = $user->register($nama, $email, $password);

            echo ( $isRegistered ? "SUCCESS: New user `$email` is registered!" : "ERROR: Failed to register a new user!" );
            header("Refresh: 2; URL=".BASE_URI."auth/login");
        }

        return $this->app->view('auth/register');
    }

    public function login() {
        $email      = @$_POST['email'];
        $password   = @$_POST['password'];
        $isSubmitted= isset($_POST['submit']);
        $isPosted   = $_SERVER['REQUEST_METHOD'] === 'POST';

        if ( $isSubmitted && $isPosted && isset($email) && isset($password) ) {
            $user = $this->app->model('Auth')->login($email, $password);
        
            if ( $user ) {
                // Login berhasil, simpan user dalam session dan alihkan ke halaman utama
                session_start();
                $_SESSION["user"] = $user;
                $_SESSION["KEY"] = $user["id"];
                header("Location: ".BASE_URI."dashboard");
            } else {
                // Login gagal, tampilkan pesan kesalahan
                echo "ERROR: Invalid email or password! Please try again.";
                header("Refresh: 2; URL=".BASE_URI."auth/login");
            }
        }

        return $this->app->view('auth/login');
    }

    public function logout() {
        session_destroy();
        return header("Location: ".BASE_URI."auth/login");
    }
    
}
