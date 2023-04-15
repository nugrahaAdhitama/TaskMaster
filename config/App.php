<?php
class App {
    private $conn;
    private $controller = 'Auth';
    private $method = 'index';
    private $params = [];
    private $data = [];
    public $view;

    public function __construct($db) {
        $this->conn = $db;
        $uri = explode('/', isset($_GET[URI_PARAM]) ? $_GET[URI_PARAM] : $this->controller);
        
        $this->controller = ucfirst(!empty($uri[0]) ? $uri[0] : $this->controller);
        $this->method = !empty($uri[1]) ? $uri[1] : $this->method;
        $this->params = array_slice($uri, 2);
        $this->view = "$this->controller/$this->method";
        
        $this->controller($this->controller);
    }

    public function controller(string $name) {
        $controller = $name."Controller";
        $file = "app/controllers/$controller.php";
        if ( !file_exists($file) ) {
            $this->data["title"] = "Page Not Found";
            $this->view('{templates}/errors/404');
            echo "<pre>Controller `$name` does not exist!</pre>";
            return;
        }
        include $file;
        $controller = new $controller($this);

        if ( $this->controller == 'Auth' && isset($_SESSION['user']) ) { header("Location: ".BASE_URI."dashboard"); }
        if ( $this->controller != 'Auth' && !isset($_SESSION['user']) ) { header("Location: ".BASE_URI."auth/login"); }

        if ( method_exists($controller, $this->method) ) {
            $this->data["title"] = APP_NAME.($this->method == 'index'  ? '' : ' - '.ucwords(str_replace('_', ' ', $this->method)));
            call_user_func_array([$controller, $this->method], $this->params);
        } else {
            $this->data["title"] = "Page Not Found";
            $this->view('{templates}/errors/404');
            echo "<pre>Method `$this->method` does not exist!</pre>";
        }
    }

    public function model(string $name) {
        if ( file_exists("app/models/".$name.".php") ) {
            include "app/models/".$name.".php";
            return new $name($this->conn);
        } else {
            echo "<pre>WARNING: Model `$name` not found!</pre>";
        }
    }

    public function view(string $name, mixed $data = []) {
        $data = array_merge($this->data, $data);
        extract($data);

        include "app/views/{templates}/header.php";
        include "app/views/" . ( file_exists("app/views/$name.php") && is_file("app/views/$name.php") ? $name : "{templates}/errors/404" ) . ".php";
        include "app/views/{templates}/footer.php";
    }
}
