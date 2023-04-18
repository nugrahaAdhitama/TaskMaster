<?php

use App\Core\Notification;

class TaskController {

    private array $fields = [
        "required" => ['judul', 'deadline', 'status', 'tipe'],
        "optional" => ['deskripsi']
    ];

    public function __construct(private $app) {}

    public function index() {
        $model = $this->app->model('Task');
        $data['tasks'] = $model->getTaskByUserId($_SESSION['user']['id']);
        $data['title'] = APP_NAME." - Task";
        return $this->app->view('task/index', $data);
    }

    public function add() {
        $fields = $this->fields;

        if( isset($_POST['submit']) ) {
            $isValid = !array_diff_key(array_flip($fields['required']), $_POST);
            $isValid ?: Notification::alert("ERROR: Failed to submit form!: Missing required fields!", "task/add");

            $model = $this->app->model('Task');
            $addedTask = $model->addNewTask(array_merge($fields['required'], $fields['optional']), $_POST);

            Notification::alert($addedTask ? "SUCCESS: New task is added!" : "ERROR: Failed to add a new task!", "task");
        }

        $data["title"] = APP_NAME." - Add Task";
        return $this->app->view('task/add', $data);
    }

    public function edit() {
        $this->app->allowParams();
        $fields = $this->fields;
        $id = $this->app->params[0] ?? '';
        $user_id = $_SESSION['user']['id'];
        $model = $this->app->model('Task');

        $task = $model->getTaskByOwner($id, $user_id);
        $task ?: exit("<pre>ERROR: Task not found!</pre><a href='".BASE_URI."task'>Back</a>");

        if ( isset($_POST['submit'] )) {
            $columns        = array_merge($fields['required'], $fields['optional']);
            $data           = array_intersect_key($_POST, array_flip($columns));

            $editedTask   = $id ? $model->editTask($id, $user_id, $data) : false;

            Notification::alert($editedTask ? "SUCCESS: Task is updated!" : "ERROR: Failed to update task!", "task");
        }

        $data = [
            'task' => $task,
            'title' => APP_NAME." - Edit Task"
        ];

        return $this->app->view('task/edit', $data);
    }

    public function delete() {
        $this->app->allowParams();
        $model = $this->app->model('Task');
        $id = @$this->app->params[0] ?? '';
        $user_id = $_SESSION['user']['id'];
        $isAccepted = $_SERVER["REQUEST_METHOD"] === "POST";

        $tasks = $model->getTaskByOwner($id, $user_id);
        $tasks ?: exit("<pre>ERROR: Task not found!</pre><a href='".BASE_URI."schedule'>Back</a>");

        if( isset($_POST["submit"], $id) && $isAccepted ) {
            $deletedTask = $model->deleteTaskByID($id);

            Notification::alert($deletedTask ? "SUCCESS: Task is deleted!" : "ERROR: Failed to delete task!", "task");
        }

        $data["title"] = APP_NAME." - Delete Task";
        return $this->app->view('task/delete', $data);
    }
}