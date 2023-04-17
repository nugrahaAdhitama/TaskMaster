<?php

class ScheduleController {

    public function __construct(private $app) {}

    public function index() {
        $model = $this->app->model('Schedule');
        $data["schedules"] = $model->getScheduleByUserID($_SESSION['user']['id']);
        $data["title"] = APP_NAME." - Schedule";
        return $this->app->view('schedule/index', $data);
    }

    public function add() {
        $fields = [
            "required" => ['course', 'started_at', 'ended_at', 'day', 'room'],
            "optional" => ['notes']
        ];
    
        if ( isset($_POST['submit']) ) {
            $isValid = true;
            foreach ( $fields["required"] as $required ) {
                if ( !isset($_POST[$required]) || empty($_POST[$required]) ) {
                    $isValid = false;
                    break;
                }
            }
    
            if ( !$isValid ) {
                echo "WARNING: Failed to submit form!: Missing required field!";
                exit(header("Refresh: 2; URL=".BASE_URI."schedule/add"));
            }
    
            $model = $this->app->model('Schedule');
            $addSchedule = $model->addNewSchedule(array_merge($fields["required"], $fields["optional"]), $_POST);
    
            echo $addSchedule ? "SUCCESS: New schedule is added!" : "ERROR: Failed to add a new schedule!";
            exit(header("Refresh: 2; URL=".BASE_URI."schedule"));
        }
    
        $data["title"] = APP_NAME." - Add Schedule";
        return $this->app->view('schedule/add', $data);
    }

    public function edit() {
        $fields     = [
                    "required" => ['course', 'started_at', 'ended_at', 'day', 'room'],
                    "optional" => ['notes']
        ];
        $id         = $this->app->params[0] ?? '';
        $user_id    = $_SESSION['user']['id'];
        $model      = $this->app->model('Schedule');
        $schedules  = $model->getScheduleByOwner($id, $user_id);
    
        if ( !$schedules ) { exit("<pre>ERROR: Schedule not found!</pre><a href='".BASE_URI."schedule'>Back</a>"); }
    
        if ( isset($_POST['submit'] )) {
            $columns        = array_merge($fields['required'], $fields['optional']);
            $data           = array_intersect_key($_POST, array_flip($columns));

            $editSchedule   = $id ? $model->editSchedule($id, $user_id, $data) : false;
            $message        = $id ? ($editSchedule ? "SUCCESS: Schedule is updated!" : "ERROR: Failed to update schedule!")
                                  : "ERROR: Schedule ID is not specified!";
            exit($message.header("Refresh: 2; URL=".BASE_URI."schedule"));
        }
    
        $data = [
            "schedules" => $schedules,
            "title" => APP_NAME." - Edit Schedule"
        ];
        return $this->app->view('schedule/edit', $data);
    }
    

    public function delete() {
        $model      = $this->app->model('Schedule');
        $id         = @$this->app->params[0] ?? '';
        $user_id    = $_SESSION['user']['id'];
        $isAccepted = $_SERVER["REQUEST_METHOD"] === 'POST';
    
        $schedules = $model->getScheduleByOwner($id, $user_id);
        if ( !$schedules ) { exit("<pre>ERROR: Schedule not found!</pre><a href='".BASE_URI."schedule'>Back</a>"); }
    
        if ( isset($_POST["submit"], $id ) && $isAccepted ) {
            $isDeleted = $model->deleteScheduleByID($id);
    
            echo $isDeleted ? "SUCCESS: Schedule `$id` is deleted!" : "ERROR: Failed to delete schedule `$id`!";
            exit(header("Refresh: 2; URL=".BASE_URI."schedule"));
        }
    
        $data["title"] = APP_NAME." - Delete Schedule";
        return $this->app->view('schedule/delete', $data);
    }
    
}