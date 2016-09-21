<?php
namespace core;

class Route
{
    private $url;
    private $routs = [];    // Array view: 'path' => ['Controller::method']

    public function __construct()
    {
        $routs = include(__DIR__ . '/../app/routs.php');

        foreach ($routs as $way => $action) {
            $routsRegExp = '/^' . str_replace('/', '\/', $way) . '$/';
            $routs[$routsRegExp] = $action;
            unset($routs[$way]);
        }
        return $this->routs = $routs;
    }

    private function setUrl()
    {
        $this->url = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/\ ');
        if (!$this->url) {
            $this->url = '/';
        }
    }

    private function match()
    {
        foreach ($this->routs as $key => $value) {
            if (preg_match($key, $this->url)) {
                return $result = $value;
            }
        }
        return false;
    }

    public function start()
    {
        $this->setUrl();
        $active = explode('::', $this->match()[0]);
        $controllerRoute = 'app\controllers\\' . $active[0] . 'Controller';
        if (!class_exists($controllerRoute)) {
            throw new \Exception('Error! No controller ' . $active[0]);
        }
        $controllerObj = new $controllerRoute;

        if (!method_exists($controllerObj, $active[1])) {
            throw new \Exception('Error no Action Method ' . $active[1]);
        }
        call_user_func([$controllerObj, $active[1]]);
    }
}