<?php

class App
{

    protected $controller = 'Home';
    protected $method = 'index';
    protected $params = [];

    public function __construct()
    {
        #MEMISAHKAN URL MENJADI ARRAY BERDASARKAN SLASH ' / '
        $url = $this->parseURL();

        # IDENTIFIKASI CONTROLLER
        if (isset($url[0])) {
            $controllerName = ucfirst($url[0]);
            if (file_exists('../app/controllers/' . $controllerName . '.php')) {
                $this->controller = $controllerName;
                unset($url[0]);
            }
        }
        require_once '../app/controllers/' . $this->controller . '.php';
        $this->controller = new $this->controller;

        # IDENTIFIKASI METHOD
        if (isset($url[1])) {
            if (method_exists($this->controller, $url[1])) {
                $this->method = $url[1];
                unset($url[1]);
            }
        }

        # IDENTIFIKASI PARAMS
        if (!empty($url)) {
            $this->params = array_values($url);
        }

        # RUN Controller and Method
        call_user_func_array([$this->controller, $this->method], $this->params);
    }

    public function parseURL()
    {
        if (isset($_GET['url'])) {

            $url = rtrim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode('/', $url);
            return $url;
        }
        return [];
    }

}