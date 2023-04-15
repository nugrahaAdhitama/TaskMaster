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
        $data["schedules"] = $model->getScheduleByUserID($_SESSION['user']['id']);
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
        $fields["required"] = ['course', 'started_at', 'ended_at', 'day', 'room'];
        $fields["optional"] = ['notes'];
        $submit = @$_POST['submit'];
        $data = [];
        $id = @$this->app->params[0];
        $user_id = $_SESSION['user']['id'];
        $model = $this->app->model($this->model);

        if ( $id === NULL ) { $id = ''; }
        $schedules = $model->getScheduleByOwner($id, $user_id);
        if ( !$schedules ) { exit("<pre>ERROR: Schedule `$id` not found!</pre><a href='".BASE_URI."schedule'>Back</a>"); }

        if ( isset($submit) ) {
            if ( !isset($id) || @$id == '' ) {
                echo "ERROR: Schedule ID is not specified!";
                return header("Refresh: 2; URL=".BASE_URI."schedule");
            }

            $columns = array_values(array_merge($fields["required"], $fields["optional"]));
            foreach ( $columns as $index => $column ) { $data[$index] = @$_POST[$column]; }

            $editSchedule = $model->editSchedule($id, $user_id, $columns, $data);

            echo ( $editSchedule ? "SUCCESS: Schedule is updated!" : "ERROR: Failed to update schedule!" );
            header("Refresh: 2; URL=".BASE_URI."schedule");
            exit();
        }

        $data["schedules"] = $schedules;
        $data["title"] = APP_NAME." - Edit Schedule";
        return $this->app->view($this->page, $data);
    }

    public function delete() {
        $model = $this->app->model($this->model);
        $id = @$this->app->params[0];
        $user_id = $_SESSION['user']['id'];
        $submit = @$_POST["submit"];

        if ( $id === NULL ) { $id = ''; }
        $schedules = $model->getScheduleByOwner($id, $user_id);
        if ( !$schedules ) { exit("<pre>ERROR: Schedule `$id` not found!</pre><a href='".BASE_URI."schedule'>Back</a>"); }

        if ( isset($submit) && isset($id) ) {
            $deleteSchedule = $model->deleteScheduleByID($id);
            
            echo ( $deleteSchedule ? "SUCCESS: Schedule `$id` is deleted!" : "ERROR: Failed to delete schedule `$id`!" );
            header("Refresh: 2; URL=".BASE_URI."schedule");
            exit();
        }

        $data["title"] = APP_NAME." - Delete Schedule";
        return $this->app->view($this->page, $data);
    }
}