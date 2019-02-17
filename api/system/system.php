<?php
namespace System;

class System 
{
    private $_url;
    private $_explode;
    public $_controller;
    public $_action;
    public $_params;

    public function __construct()
    {
        $this->setUrl();
        $this->setExplode();
        $this->setController();
        $this->setAction();
        $this->setParams();
    }

    private function setUrl()
    {
        $_GET['url'] = (isset($_GET['url']) ? $_GET['url'] : 'index/index');
        $this->_url = $_GET['url'];
    }

    private function setExplode()
    {
        $this->_explode = explode('/', $this->_url);
    }

    private function setController()
    {
        $this->_controller = $this->_explode[0];
    }

    private function setAction()
    {
        $ac = (!isset($this->_explode[1]) || $this->_explode[1] == null || $this->_explode[1] == 'index' ? 'index' : $this->_explode[1]);
        $this->_action = $ac;
    }

    private function setParams()
    {
        unset($this->_explode[0], $this->_explode[1]);

        if(end($this->_explode) == null){
            array_pop($this->_explode);
        }

        // $i = 0;
        // if(!empty($this->_explode)){
        //     foreach ($this->_explode as $value){
        //         if ($i % 2 == 0) {
        //             $key[] = $value;
        //         } else {
        //             $values[] = $value;
        //         }
        //         $i++;
        //     }

        // } else{
        //     $key = array();
        //     $values = array();
        // }

        // if(count($key) == count($values) && !empty($key) && !empty($values)){
        //     $this->_params = array_combine($key, $values);
        // } else{
        //     $this->_params = array();
        // }
    }

    public function getParam($name = null)
    {
        if($name != null){
            return (isset($this->_params[$name])) ? $this->_params[$name] : false; 
        } else {
            return $this->_params;
        }
        
    }

    public function run()
    {
        $controller = DIRECTORY_SEPARATOR . \Config::$namespace["aplication"] . DIRECTORY_SEPARATOR . "Controller" . DIRECTORY_SEPARATOR .  ucfirst($this->_controller) . "Controller";
        $app = new $controller();
        /*if (!file_exists($controller_path)){
            throw new \Exception("Error: The controller doesn't exist!", 1);
        }

        require_once($controller_path);
        $app = new $this->_controller();

        if(!method_exists($app, $this->_action)){
            throw new \Exception("Error: Action doesn't exist!", 1);
        }*/
  
        // if ($this->_action != 'index') {
        //     array_unshift($this->_explode, $this->_action);
        //     $this->_action = 'index';
        // }
        $action = $this->_action;
        call_user_func_array(array($app, $action), $this->_explode);
        // $app->$action();
    }

}
