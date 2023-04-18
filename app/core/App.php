<?php

namespace App\Core;

/**
 * The App class is responsible for handling the request
 * and routing it to the appropriate controller and method.
 */
class App {

    /**
     * The database connection object.
     * 
     * @var object
     */
    private object $conn;

    /**
     * The default controller to use.
     * 
     * @var string
     */
    private string $controller;

    /**
     * The default method to use.
     * 
     * @var string
     */
    private string $method;

    /**
     * The parameters from the URI.
     * 
     * @var array
     */
    public array $params = [];

    /**
     * The data to be passed to the view.
     * 
     * @var array
     */
    private array $data = [];

    /**
     * The default values from .env file.
     *
     * @var array
     */
    public array $default;

    /**
     * The constructor for the App class.
     * 
     * @param object $db The database connection object.
     */
    public function __construct(object $db) {
        define('APP_NAME', $_ENV["APP_NAME"]??'');
        define('URI_PARAM', $_ENV["APP_URI_PARAM"]??'');
        define('BASE_URI', $_ENV["APP_URI_BASE"]??'');

        $this->default      = [
            "controller"     => $_ENV["DEFAULT_CONTROLLER"]??'',
            "method"         => $_ENV["DEFAULT_METHOD"]??'',
            "controllerPath" => $_ENV["DEFAULT_PATH_CONTROLLER"]??'',
            "modelPath"      => $_ENV["DEFAULT_PATH_MODEL"]??'',
            "viewPath"       => $_ENV["DEFAULT_PATH_VIEW"]??'',
            "authPage"       => $_ENV["DEFAULT_URI_AUTH"]??'',
            "accessPage"     => $_ENV["DEFAULT_URI_ACCESS"]??''
        ];

        $uri = explode('/', $_GET[URI_PARAM] ?? $this->default["controller"]);
        
        $this->conn           = $db;
        $this->controller     = $uri[0] ?: $this->default["controller"];
        $this->method         = @$uri[1] ?: $this->default["method"];
        $this->default["URI"] = $uri;
        
        $this->controller($this->controller);
    }

    /**
     * Load the specified controller.
     * 
     * @param string $name The name of the controller to load.
     * @return void
     */
    public function controller(string $name) {
        $controllerName = ucfirst($name)."Controller";
        $file = "{$this->default["controllerPath"]}$controllerName.php";
    
        if ( !file_exists($file) ) { exit("<pre>Controller `$name` does not exist!</pre>"); }

        $defaultController = $this->default["controller"];
        $isAuthorized = isset($_SESSION["KEY"]);

        if ( $isAuthorized && $this->controller === $defaultController ) { header("Location: ".BASE_URI.$this->default["accessPage"]); }
        if ( !$isAuthorized && $this->controller !== $defaultController ) { header("Location: ".BASE_URI.$this->default["authPage"]); }
    
        include $file;
        $controller = new $controllerName($this);
    
        $method = $this->method;
        $this->data["title"] = APP_NAME . ( $method === 'index' ? '' : ' - ' . ucwords(str_replace('_', ' ', $method)) );
        if ( !method_exists($controller, $method) ) { exit("<pre>Method `$method` does not exist!</pre>"); }

        call_user_func_array([$controller, $method], $this->params);
    }
    

    /**
     * Load the specified model.
     * 
     * @param string $name The name of the model to load.
     * @return void
     */
    public function model(string $name) {
        $model = $this->default["modelPath"];
        $modelFile = "$model$name.php";
        if ( file_exists($modelFile) ) {
            include $modelFile;
            return new $name($this->conn);
        }
        exit("<pre>WARNING: Model file does not exist!</pre>");
    }

    /**
     * Load the specified view.
     * 
     * @param string $name The name of the view file to be rendered.
     * @param array $data Optional associative array of data to be passed to the view.
     * @return void
     */
    public function view(string $name, array $data = []) {
        $data = array_merge($this->data, $data);
        extract($data);
        $view = $this->default["viewPath"];
    
        $file = "$view$name.php";
        if (!file_exists($file) || !is_file($file)) exit("<pre>ERROR: View file does not exist!</pre>");
    
        foreach (["{templates}/header.php", "$name.php", "{templates}/footer.php"] as $_) include "$view$_";
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function allowParams() {
        return $this->params = array_slice($this->default["URI"], 2);
    }
    
}
