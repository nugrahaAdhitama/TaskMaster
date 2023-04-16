<?php

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
    private string $controller = 'Auth';

    /**
     * The default method to use.
     * 
     * @var string
     */
    private string $method = 'index';

    /**
     * The parameters from the URI.
     * 
     * @var array
     */
    public array $params = [];

    /**
     * The name of the view to display.
     * 
     * @var string
     */
    public string $view;

    /**
     * The data to be passed to the view.
     * 
     * @var array
     */
    private array $data = [];

    /**
     * The constructor for the App class.
     * 
     * @param object $db The database connection object.
     */
    public function __construct(object $db) {
        $uri = explode('/', $_GET[URI_PARAM] ?? $this->controller);
        
        $this->conn = $db;
        $this->controller = ucfirst($uri[0] ?: $this->controller);
        $this->method = @$uri[1] ?: $this->method;
        $this->params = array_slice($uri, 2);
        $this->view = "$this->controller/$this->method";

        $this->controller($this->controller);
    }

    /**
     * Load the specified controller.
     * 
     * @param string $name The name of the controller to load.
     * @return void
     */
    public function controller(string $name) {
        $controller = "{$name}Controller";
        $file = "app/controllers/$controller.php";
    
        if ( !file_exists($file) ) { exit("<pre>Controller `$name` does not exist!</pre>"); }

        if ( $this->controller === 'Auth' && isset($_SESSION['user']) ) { header("Location: ".BASE_URI."dashboard"); }
        if ( $this->controller !== 'Auth' && !isset($_SESSION['user']) ) { header("Location: ".BASE_URI."auth/login"); }
    
        include $file;
        $controller = new $controller($this);
    
        $method = $this->method;
        if ( !method_exists($controller, $method) ) { exit("<pre>Method `$method` does not exist!</pre>"); }
    
        $this->data["title"] = APP_NAME . ( $method === 'index' ? '' : ' - ' . ucwords(str_replace('_', ' ', $method)) );
        call_user_func_array([$controller, $method], $this->params);
    }
    

    /**
     * Load the specified model.
     * 
     * @param string $name The name of the model to load.
     * @return void
     */
    public function model(string $name) {
        $modelFile = "app/models/$name.php";
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
        $view = 'app/views/';
    
        $file = "$view$name.php";
        if (!file_exists($file) || !is_file($file)) exit("<pre>ERROR: View file does not exist!</pre>");
    
        foreach (["{templates}/header.php", "$name.php", "{templates}/footer.php"] as $_) include "$view$_";
    }
    
}
