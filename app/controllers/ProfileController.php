<?php

use App\Core\Notification;

class ProfileController {

    public function __construct(private $app) {}

    public function index() {
        $data["title"] = APP_NAME." - Profile";
        return $this->app->view('profile/index', $data);
    }

    public function edit() {
        $nama           = @$_POST['nama'];
        $password       = @$_POST['password'];
        $data["title"]  = APP_NAME." - Edit Profile";

        if ( isset($nama) && isset($password) ) {
            $profile = $this->app->model('Auth');
            $profile = $this->app->model('Profile');

            $updated = $profile->updateProfile($_SESSION['user']['email'], $nama, $password);
            !$updated ?: $_SESSION['user']['nama'] = $nama;
            Notification::alert($updated ? "SUCCESS: Profile updated!" : "ERROR: Failed to update profile!", "profile");
        }

        return $this->app->view('profile/edit', $data);
    }

    public function delete() {
        $submit = @$_POST['submit'];
        $data["title"] = APP_NAME." - Delete Account";

        if ( isset($submit) && $submit == 'yes') {
            $profile = $this->app->model('Auth');
            $profile = $this->app->model('Profile');

            $isDeleted = $profile->deleteProfile($_SESSION['user']['email']);

            if ( $isDeleted ) { session_destroy(); }
            echo $isDeleted ? "SUCCESS: Account deleted!" : "ERROR: Failed to delete account!";
            exit(header("Refresh: 2; URL=".BASE_URI."profile"));
        }

        return $this->app->view('profile/delete', $data);
    }

}
