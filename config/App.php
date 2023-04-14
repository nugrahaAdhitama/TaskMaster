<?php
class App {
    private $conn;
    private $data = [];
    private $controller = 'Auth';
    private $method = 'index';
    private $params = [];
    public $uri;

    public function __construct($db) {
        $this->conn = $db;
        $uri = explode('/', isset($_GET[URI_PARAM]) ? $_GET[URI_PARAM] : $this->controller);
        
        $this->controller = ucfirst(!empty($uri[0]) ? $uri[0] : $this->controller);
        $this->method = !empty($uri[1]) ? $uri[1] : $this->method;
        $this->params = array_slice($uri, 2);

        $this->uri = $this->controller."/".$this->method;

        if ( $this->controller == 'Auth' && isset($_SESSION['user']) ) { header("Location: ".BASE_URI."dashboard"); }
        if ( $this->controller != 'Auth' && !isset($_SESSION['user']) ) { header("Location: ".BASE_URI."auth/login"); }
        
        $this->controller($this->controller);
    }

    public function controller(string $name) {
        $controller = $name."Controller";
        $file = "app/controllers/$controller.php";
        if ( !file_exists($file) ) { exit("<pre>ERROR: Controller `$name` does not exist!</pre>"); }
        include $file;
        $controller = new $controller($this);
        if ( method_exists($controller, $this->method) ) {
            $this->data["title"] = APP_NAME.($this->method == 'index'  ? '' : ' - '.ucwords(str_replace('_', ' ', $this->method)));
            call_user_func_array([$controller, $this->method], $this->params);
        } else {
            $this->data["title"] = "Page Not Found";
            $this->view('{templates}/errors/404');
            echo '<pre>Invalid method name: ' . $this->method . '</pre>';
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
