<?php

class AuthController {

    private $app;
    private $page;
    private $model = 'Auth';

    public function __construct($app) {
        $this->app = $app;
        $this->page = $app->uri;
    }

    public function index() {
        return $this->app->view($this->page);
    }

    public function register() {
        $nama = @$_POST['nama'];
        $email = @$_POST['email'];
        $password = @$_POST['password'];

        if ( isset($nama) && isset($email) && isset($password) ) {
            $user = $this->app->model($this->model);
            if ( $user->isEmailRegistered($email) ) {
                echo "WARNING: User `$email` is already registered!";
                header("Refresh: 2; URL=".BASE_URI."auth/register");
                return false;
            }

            $isRegistered = $user->register($nama, $email, $password);

            echo ( $isRegistered ? "SUCCESS: New user `$email` is added!" : "ERROR: Failed to register a new user!" );
            header("Refresh: 2; URL=".BASE_URI."auth/login");
        }

        return $this->app->view($this->page);
    }
    
    // public function isEmailRegistered($email) {
    //     $user = $this->app->model($this->model);
    //     return $user->getUserByEmail($email) !== false;
    // }

    public function login() {
        $email = @$_POST['email'];
        $password = @$_POST['password'];

        if ( isset($email) && isset($password) && $_SERVER['REQUEST_METHOD'] === 'POST' ) {
            $user = $this->app->model($this->model);
            $user = $user->login($email, $password);
        
            if ( $user ) {
                // Login berhasil, simpan user dalam session dan alihkan ke halaman utama
                session_start();
                $_SESSION["user"] = $user;
                header("Location: ".BASE_URI."dashboard");
            } else {
                // Login gagal, tampilkan pesan kesalahan
                echo "ERROR: Invalid email or password! Please try again.";
                header("Refresh: 2; URL=".BASE_URI."auth/login");
            }
        }

        return $this->app->view($this->page);
    }

    public function logout() {
        unset($_SESSION['user']);
        return header("Location: ".BASE_URI."auth/login");
    }

    public function readProfile($email) {
        $user = $this->app->model($this->model);
        return $user->getUserByEmail($email);
    }
    
    // public function updateProfile($email, $nama, $password) {
    //     $user = $this->app->model($this->model);
    //     $user_data = $user->getUserByEmail($email);
    //     if ($user_data === false) {
    //         return false;
    //     }
    
    //     if (!empty($nama)) {
    //         $user_data['nama'] = $nama;
    //     }
    
    //     if (!empty($password)) {
    //         $user_data['password'] = $user->hashPassword($password);
    //     }
    
    //     $query = "UPDATE users SET nama = :nama, password = :password WHERE email = :email";
    //     $stmt = $this->app->db->prepare($query);
    
    //     $stmt->bindParam(':nama', $user_data['nama']);
    //     $stmt->bindParam(':password', $user_data['password']);
    //     $stmt->bindParam(':email', $email);
    
    //     return $stmt->execute();
    // }
    
    // public function deleteProfile($email) {
    //     $user = $this->app->model($this->model);
    //     $user_data = $user->getUserByEmail($email);
    //     if ($user_data === false) {
    //         return false;
    //     }
    
    //     $query = "DELETE FROM users WHERE email = :email";
    //     $stmt = $this->app->db->prepare($query);
    
    //     $stmt->bindParam(':email', $email);
    
    //     return $stmt->execute();
    // }
    
}

?>
