<?php

/*
 * App Core Class
 * Creates URL & loads core controller
 * URL FORMAT - /controller/methond/params
 */

class Core
{
    protected $currentController = 'Pages';
    protected $currentMethod = 'index';
    protected $params = [];


    public function __construct()
    {
        // $this->getUrl();
        $url = $this->getUrl();


        //Look in cotrollers for first value
        if (file_exists('../app/controllers/' . ucwords($url[0]) . '.php')) {
            //IF exits, set as controller
            $this->currentController = ucwords($url[0]);
            //Unser 0 index
            unset($url[0]);
        }

        //Require the controller
        require_once '../app/controllers/' . $this->currentController . '.php';

        //Instantiate controller class
        $this->currentController = new $this->currentController;

        //Check for second part of url
        if (isset($url[1])) {
            //check for method in controller

            if (method_exists($this->currentController, $url[1])) {
                $this->currentMethod = $url[1];
            }
            unset($url[1]);
        }

        // Get params
        $this->params = $url ? array_values($url) : [];

        //call callback with array of parmas;
        call_user_func_array([$this->currentController, $this->currentMethod], $this->params);
    }

    public function getUrl()
    {

        if (isset($_GET['url'])) {
            $url = rtrim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode('/', $url);
            return $url;
        }
    }
}
