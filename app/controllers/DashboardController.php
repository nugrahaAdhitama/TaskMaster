<?php

class DashboardController {

    private $app;
    private $page;
    private $model = 'Dashboard';

    public function __construct($app) {
        $this->app = $app;
        $this->page = $app->view;
    }

    public function index() {
        $data["title"] = APP_NAME.' - Dashboard';
        return $this->app->view($this->page, $data);
    }

}
