<?php

use Jenssegers\Blade\Blade;

class App
{

    /**
     * @var App
     */
    private static $instance;

    /**
     * @var Blade
     */
    public static $blade;


    /**
     * @var AltoRouter
     */
    public static $router;

    /**
     * @var
     */
    private static $match;

    private function __construct()
    {
    }

    /**
     * @return App
     */
    public static function getInstance()
    {
        if (!self::$instance instanceof self) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    public function boot()
    {
        $this->loadEnv();
        $this->setupBlade();
        $this->setupRouter();
        if (env('DB_CONNECTION') !== 'json') {
            $this->setupActiveRecord();
        }
    }

    private function loadEnv()
    {
        $dotEnv = new \Dotenv\Dotenv(__DIR__ . '/../');
        $dotEnv->load();
    }

    private function setupBlade()
    {
        self::$blade = new Blade(['./resources/views/'], './app/cache');
        $GLOBALS['blade'] = self::$blade;
    }

    private function setupRouter()
    {
        self::$router = new AltoRouter();
        if(env('APP_BASE_PATH') !== '' ){
            self::$router->setBasePath(env('APP_BASE_PATH'));
        }
        $GLOBALS['router'] = self::$router;
    }

    private function setupActiveRecord()
    {
        $connection = env('DB_CONNECTION') . '://' . env('DB_USERNAME') . ':' . env('DB_PASSWORD') .'@' . env('DB_HOST') . '/' . env('DB_DATABASE');
        $cfg = ActiveRecord\Config::instance();
        $cfg->set_model_directory("./app/models");
        $cfg->set_connections(
            array(
                'development' => $connection
            )
        );
        $cfg->set_default_connection('development');
    }

    /**
     * @param string $path
     */
    public function setBasePath($path)
    {
        self::$router->setBasePath($path);
    }

    /**
     * @param $method
     * @param $route
     * @param $target
     * @param $name
     */
    public function addRoute($method, $route, $target, $name)
    {
        self::$router->map($method, $route, $target, $name);
    }

    /**
     * @param array $routes
     */
    public function addRoutes($routes)
    {
        self::$router->addRoutes($routes);
    }


    public function start()
    {
        self::$match = self::$router->match();
        $this->executeRoute();
    }

    private function executeRoute()
    {
        if (self::$match) {
            list($controller, $method) = explode("#", self::$match['target']);
            $controller = 'App\Controllers\\' . $controller;

            if (is_callable(array($controller, $method))) {
                $object = new $controller();
                call_user_func_array(array($object, $method), array(self::$match['params']));
            } else {
                echo "Can not find $controller->$method";
                exit();
            }

        } else {
            header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found", true, 404);
            view('notFound', []);
        }
    }

}