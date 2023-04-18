<?php

class TaskController {
    public function __construct(private $app) {}

    public function index() {
        $model = $this->app->model('Task');
        $data['tasks'] = $model->getTaskByUserId($_SESSION['user']['id']);
        $data['title'] = APP_NAME." - Task";
        return $this->app->view('task/index', $data);
    }

    public function add() {
        $fileds = [
            "required" => ['judul', 'deadline', 'status', 'tipe'],
            "optional" => ['deskripsi']
        ];

        if( isset($_POST['submit']) ) {
            $isValid = true;
            foreach ( $fileds['required'] as $required ) {
                if ( !isset($_POST[$required]) || empty($_POST[$required]) ) {
                    $isValid = false;
                    break;
                }
            }

            if( !$isValid ) {
                echo "WARNING: Failed to submit form!: Missing required field!";
                exit(header("Refresh: 2; URL=".BASE_URI."task/add"));
            }

            $model = $this->app->model('Task');
            $addTask = $model->addNewTask(array_merge($fileds['required'], $fileds['optional']), $_POST);

            echo $addTask ? "SUCCESS: New task is added!" : "ERROR: Failed to add a new task!";
            exit(header("Refresh: 2; URL=".BASE_URI."task"));
        }

        $data["title"] = APP_NAME." - Add Task";
        return $this->app->view('task/add', $data);
    }

    public function edit() {
        $fields = [
            "required" => ['judul', 'deadline', 'status', 'tipe'],
            "optional" => ['deskripsi']
        ];
        $id = $this->app->params[0] ?? '';
        $user_id = $_SESSION['user']['id'];
        $model = $this->app->model('Task');
        $tasks = $model->getTaskByOwner($id, $user_id);

        if( !$tasks ) {
            exit("<pre>ERROR: Task not found!</pre><a href='".BASE_URI."task'>Back</a>");
        }

        if ( isset($_POST['submit'] )) {
            $columns        = array_merge($fields['required'], $fields['optional']);
            $data           = array_intersect_key($_POST, array_flip($columns));

            $editTask   = $id ? $model->editTask($id, $user_id, $data) : false;
            $message        = $id ? ($editTask ? "SUCCESS: Task is updated!" : "ERROR: Failed to update task!")
                                  : "ERROR: Task ID is not specified!";
            exit($message.header("Refresh: 2; URL=".BASE_URI."schedule"));
        }

        $data = [
            'tasks' => $tasks,
            'title' => APP_NAME." - Edit Task"
        ];
        return $this->app->view('task/edit', $data);
    }

    public function delete() {
        $model = $this->app->model('Task');
        $id = @$this->app->params[0] ?? '';
        $user_id = $_SESSION['user']['id'];
        $isAccepted = $_SERVER["REQUEST_METHOD"] === "POST";

        $tasks = $model->getTaskByOwner($id, $user_id);
        if ( !$tasks ) { 
            exit("<pre>ERROR: Task not found!</pre><a href='".BASE_URI."schedule'>Back</a>"); 
        }

        if( isset($_POST["submit"], $id) && $isAccepted ) {
            $isDeleted = $model->deleteTaskByID($id);

            echo $isDeleted ? "SUCCESS: Task `$id` is deleted!" : "ERROR: Failed to delte schedule `$id`!";
            exit(header("Refresh: 2; URL=".BASE_URI."task"));
        }

        $data["title"] = APP_NAME." - Delete Task";
        return $this->app->view('task/delete', $data);
    }
}