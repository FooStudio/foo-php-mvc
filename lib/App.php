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

    /**
     *
     */
    public function bootstrap()
    {
        self::$blade = new Blade(['./resources/views/'], './app/cache');
        $GLOBALS['blade'] = self::$blade;
        self::$router = new AltoRouter();
        $GLOBALS['router'] = self::$router;
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