<?php

class ProfileController {

    private $app;
    private $page;
    private $model = 'Profile';

    public function __construct($app) {
        $this->app = $app;
        $this->page = $app->view;
    }

    public function index() {
        $data["title"] = APP_NAME." - Profile";
        return $this->app->view($this->page, $data);
    }

    public function edit() {
        $nama = @$_POST['nama'];
        $password = @$_POST['password'];

        if ( isset($nama) && isset($password) ) {
            $profile = $this->app->model('Auth');
            $profile = $this->app->model($this->model);
            $updated = $profile->updateProfile($_SESSION['user']['email'], $nama, $password);
            if ($updated) {
                // Update session data
                $_SESSION['user']['nama'] = $nama;
                echo "SUCCESS: Profile updated!";
                header("Refresh: 2; URL=".BASE_URI."profile");
                exit;
            } else {
                // Jika gagal mengupdate profil, arahkan kembali ke halaman edit profile
                echo "ERROR: Failed to update profile!";
                header("Refresh: 2; URL=".BASE_URI."profile/edit");
                exit;
            }
        }

        $data["title"] = APP_NAME." - Edit Profile";
        return $this->app->view($this->page, $data);
    }

    public function delete() {
        $submit = @$_POST['submit'];

        if ( isset($submit) && $submit == 'yes') {
            $profile = $this->app->model('Auth');
            $profile = $this->app->model($this->model);
            $deleted = $profile->deleteProfile($_SESSION['user']['email']);
            if ( $deleted ) {
                unset($_SESSION['user']);
                echo "SUCCESS: Account deleted!";
                header("Refresh: 2; URL=".BASE_URI."auth/login");
                exit;
            } else {
                // Jika gagal menghapus akun, arahkan kembali ke halaman profil
                echo "ERROR: Failed to delete account!";
                header("Refresh: 2; URL=".BASE_URI."profile");
                exit;
            }
        }

        $data["title"] = APP_NAME." - Delete Account";
        return $this->app->view($this->page, $data);
    }

}
