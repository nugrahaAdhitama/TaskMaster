<?php

class DashboardController {

    public function __construct(private $app) {}

    public function index() {
        $data["title"] = APP_NAME.' - Dashboard';
        return $this->app->view('dashboard/index', $data);
    }

}
