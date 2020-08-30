<?php


class Route
{
    const MODELS_PATH = "application/Models/";

    const CONTROLLERS_PATH = "application/Controllers/";

    const VIEWS_PATH = "application/Views/";

    const DEFAULT_CONTROLLER_ACTION = "Start";

    public static function Start(){
        require_once "application/autoload.php";

        $url = preg_replace("([?][a-zA-Z0-9\=\&]*)","",$_SERVER['REQUEST_URI']);

        $routes = explode('/', $url);

        $controller_name = "Controller_".(empty($routes[1])?"Main":strtolower($routes[1]));

        $action_name =  empty($routes[2])?self::DEFAULT_CONTROLLER_ACTION:$routes[2];

        $model_name = "Model_".(empty($routes[1])?"main":strtolower($routes[1]));

        if(!file_exists(self::CONTROLLERS_PATH.$controller_name.".php")) {
            $controller_name = "Controller_main";
        }
        if(!file_exists(self::MODELS_PATH.$model_name.".php")) {
            $model_name = "Model_main";
        }

        require_once(self::MODELS_PATH . $model_name . ".php");
        require_once(self::CONTROLLERS_PATH . $controller_name . ".php");

        $controller = new $controller_name;

        if(method_exists($controller,$action_name))
            $controller->$action_name();

    }
}