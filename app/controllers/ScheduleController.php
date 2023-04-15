<?php

class ScheduleController {

    private $app;
    private $page;
    private $model = 'Schedule';

    public function __construct($app) {
        $this->app = $app;
        $this->page = $app->view;
    }

    public function index() {
        $model = $this->app->model($this->model);
        $data["courses"] = $model->getAllCourses();
        $data["title"] = APP_NAME." - Schedule";
        return $this->app->view($this->page, $data);
    }

    public function add() {
        $fields["required"] = ['course', 'started_at', 'ended_at', 'day', 'room'];
        $fields["optional"] = ['notes'];
        $submit = @$_POST['submit'];
        $data = [];

        if ( isset($submit) ) {
            foreach ( $fields["required"] as $required ) {
                if ( !isset($_POST[$required]) ) {
                    echo "WARNING: Failed to submit form due to a missing required field!";
                    header("Refresh: 2; URL=".BASE_URI."schedule/add");
                }
            }

            $columns = array_values(array_merge($fields["required"], $fields["optional"]));
            foreach ( $columns as $index => $column ) { $data[$index] = @$_POST[$column]; }

            $model = $this->app->model($this->model);
            $addSchedule = $model->addNewSchedule($columns, $data);

            echo ( $addSchedule ? "SUCCESS: New schedule is added!" : "ERROR: Failed to add a new schedule!" );
            header("Refresh: 2; URL=".BASE_URI."schedule");
        }

        $data["title"] = APP_NAME." - Add Schedule";
        return $this->app->view($this->page, $data);
    }

    public function edit() {
        $data["title"] = APP_NAME." - Edit Schedule";
        return $this->app->view($this->page, $data);
    }
}
