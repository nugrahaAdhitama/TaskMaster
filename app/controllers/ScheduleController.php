<?php

class ScheduleController {

    private $app;
    private $page;
    private $model = 'Schedule';

    public function __construct($app) {
        $this->app = $app;
        $this->page = $app->uri;
    }

    public function index() {
        $model = $this->app->model($this->model);
        $data["schedules"] = $model->getAllSchedule();
        return $this->app->view($this->page, $data);
    }

    public function edit() {
        $data["title"] = "Customized Title";
        return $this->app->view($this->page, $data);
    }
}
