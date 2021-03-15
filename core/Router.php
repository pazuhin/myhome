<?php


namespace core;

spl_autoload_register( function($name) {
    if (is_file('../'.$name.'.php')) {
        require_once('../'.$name.'.php');
    }
});

class Router
{
    protected static $routes = [];
    protected static $route = [];

    /**
     * @return array
     */
    public static function getRoutes()
    {
        return self::$routes;
    }

    /**
     * @return array
     */
    public static function getRoute()
    {
        return self::$route;
    }

    /**
     * @param $regExp
     * @param array $route
     */
    public static function add($regExp, $route = [])
    {
        self::$routes[$regExp] = $route;
    }

    /**
     * @param $url
     * @throws \Exception
     */
    public function dispatch($url)
    {
        $url = $this->removeQueryString($url);

        if (self::matchRoute($url)) {
            $controller = 'app\controllers\\' . self::$route['prefix'] . self::$route['controller'] . 'Controller';
            if (class_exists($controller)) {
                $controllerObj = new $controller(self::$route);
                $action = self::lowerCamelCase(self::$route['action']) . 'Action';
                if (method_exists($controllerObj, $action)) {
                    $controllerObj->$action();
                    $controllerObj->getView();
                } else {
                    throw new \Exception('Method ' . $action . ' not exist', 404);
                }
            } else {
                throw new \Exception('Controller ' . $controller . ' not exist', 404);
            }
        } else {
            throw new \Exception('Page not found', 404);
        }
    }

    /**
     * @param $url
     * @return bool
     */
    public static function matchRoute($url)
    {
        foreach(self::$routes as $pattern => $route){
            if(preg_match("#{$pattern}#i", $url, $matches)){
                foreach($matches as $k => $v){
                    if(is_string($k)){
                        $route[$k] = $v;
                    }
                }
                if(empty($route['action'])){
                    $route['action'] = 'index';
                }
                if(!isset($route['prefix'])){
                    $route['prefix'] = '';
                }else{
                    $route['prefix'] .= '\\';
                }
                $route['controller'] = self::upperCamelCase($route['controller']);
                self::$route = $route;

                return true;
            }
        }
        return false;
    }

    /**
     * @param $name
     * @return string|string[]
     */
    public static function upperCamelCase($name)
    {
        return str_replace(' ', '', ucwords(str_replace('-', ' ', $name)));
    }


    /**
     * @param $name
     * @return string
     */
    public static function lowerCamelCase($name)
    {
        return lcfirst(self::upperCamelCase($name));
    }

    /**
     * @param $url
     * @return string
     * Избавляемся от get-параметров в строке
     */
    public function removeQueryString($url)
    {
        if ($url) {
            $params = explode('?', $url);
            if (!empty($params)) {
                return trim($params[0]);
            } else {
                return '';
            }
        }
    }
}