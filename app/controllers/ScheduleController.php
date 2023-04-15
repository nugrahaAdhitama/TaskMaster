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
        $data["schedules"] = $model->getAllSchedules();
        $data["title"] = APP_NAME." - Schedule";
        return $this->app->view($this->page, $data);
    }

    public function add() {
        $fields["required"] = ['course', 'started_at', 'ended_at', 'day', 'room'];
        $fields["optional"] = ['notes'];
        $submit = @$_POST['submit'];
        $data = [];
    
        if ( isset($submit) ) {
            $isValid = true;
            foreach ( $fields["required"] as $required ) {
                if ( !isset($_POST[$required]) || empty($_POST[$required]) ) {
                    $isValid = false;
                    break;
                }
            }
    
            if (!$isValid) {
                echo "WARNING: Failed to submit form due to a missing required field!";
                header("Refresh: 2; URL=".BASE_URI."schedule/add");
                exit();
            }
    
            $columns = array_values(array_merge($fields["required"], $fields["optional"]));
            foreach ( $columns as $index => $column ) { $data[$index] = @$_POST[$column]; }
    
            $model = $this->app->model($this->model);
            $addSchedule = $model->addNewSchedule($columns, $data);
    
            echo ( $addSchedule ? "SUCCESS: New schedule is added!" : "ERROR: Failed to add a new schedule!" );
            header("Refresh: 2; URL=".BASE_URI."schedule");
            exit();
        }
    
        $data["title"] = APP_NAME." - Add Schedule";
        return $this->app->view($this->page, $data);
    }

    public function edit() {
        $data["title"] = APP_NAME." - Edit Schedule";
        return $this->app->view($this->page, $data);
    }
}