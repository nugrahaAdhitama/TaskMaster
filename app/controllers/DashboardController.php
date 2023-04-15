<?php

class DashboardController {

    private $app;
    private $page;
    private $model = 'Dashboard';

    public function __construct($app) {
        $this->app = $app;
        $this->page = $app->uri;
    }

    public function index() {
        return $this->app->view($this->page);
    }

}
