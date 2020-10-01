<?php
/* 
    Base Controller
    Loads models and vies
*/

class Controller
{
    //Load Model

    public function model($model)
    {
        require_once '../app/models/' . $model . '.php';

        return new $model();
    }

    public function view($view, $data = [])
    {
        //check for view file
        if (file_exists('../app/views/' . $view . '.php')) {
            require_once '../app/views/' . $view . '.php';
        } else {

            die('View Does Not Exist');
        }
    }
}
