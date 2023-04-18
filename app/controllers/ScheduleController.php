<?php

use App\Core\Notification;

class ScheduleController {

    private array $fields = [
        "required" => ['course', 'started_at', 'ended_at', 'day', 'room'],
        "optional" => ['notes']
    ];

    public function __construct(private $app) {}

    public function index() {
        $model = $this->app->model('Schedule');
        $data["schedules"] = $model->getScheduleByUserID($_SESSION['user']['id']);
        $data["title"] = APP_NAME." - Schedule";
        return $this->app->view('schedule/index', $data);
    }

    public function add() {
        if ( isset($_POST['submit']) ) {
            $isValid = true;
            foreach ( $this->fields["required"] as $required ) {
                if ( !isset($_POST[$required]) || empty($_POST[$required]) ) {
                    $isValid = false;
                    break;
                }
            }

            $isValid ?: Notification::alert("WARNING: Failed to submit form!: Missing required fields!", "schedule/add");
    
            $model = $this->app->model('Schedule');
            $addedSchedule = $model->addNewSchedule(array_merge($this->fields["required"], $this->fields["optional"]), $_POST);
    
            Notification::alert($addedSchedule?
                "SUCCESS: New schedule is added!" : "ERROR: Failed to add a new schedule!",
                "schedule"
            );
        }
    
        $data["title"] = APP_NAME." - Add Schedule";
        return $this->app->view('schedule/add', $data);
    }

    public function edit() {
        $this->app->allowParams();
        $id         = $this->app->params[0] ?? '';
        $user_id    = $_SESSION['user']['id'];
        $model      = $this->app->model('Schedule');
        $schedules  = $model->getScheduleByOwner($id, $user_id);
    
        if ( !$schedules ) { exit("<pre>ERROR: Schedule not found!</pre><a href='".BASE_URI."schedule'>Back</a>"); }
    
        if ( isset($_POST['submit'] )) {
            $columns        = array_merge($this->fields['required'], $this->fields['optional']);
            $data           = array_intersect_key($_POST, array_flip($columns));

            $editedSchedule = $id ? $model->editSchedule($id, $user_id, $data) : false;

            Notification::alert($editedSchedule?
                "SUCCESS: Schedule is updated!" : "ERROR: Failed to update schedule!",
                "schedule"
            );
        }
    
        $data = [
            "schedules" => $schedules,
            "title" => APP_NAME." - Edit Schedule"
        ];
        
        return $this->app->view('schedule/edit', $data);
    }
    

    public function delete() {
        $this->app->allowParams();
        $model      = $this->app->model('Schedule');
        $id         = @$this->app->params[0] ?? '';
        $user_id    = $_SESSION['user']['id'];
        $isAccepted = $_SERVER["REQUEST_METHOD"] === 'POST';
    
        $schedules = $model->getScheduleByOwner($id, $user_id);
        if ( !$schedules ) { exit("<pre>ERROR: Schedule not found!</pre><a href='".BASE_URI."schedule'>Back</a>"); }
    
        if ( isset($_POST["submit"], $id ) && $isAccepted ) {
            $deletedSchedule = $model->deleteScheduleByID($id);

            Notification::alert($deletedSchedule?
                "SUCCESS: Schedule is deleted!" : "ERROR: Failed to delete schedule!",
                "schedule"
            );
        }
    
        $data["title"] = APP_NAME." - Delete Schedule";
        return $this->app->view('schedule/delete', $data);
    }
    
}