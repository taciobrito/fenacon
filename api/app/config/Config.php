<?php 

class Config 
{
    public static $preg = array("\\","/");

    public static $constants = "App/Config/Config";

    /*
    *  Config BASE URL
    */
    public static $base_url = "http://localhost/fenacon/api/";

    public static $application = "App";

    public static $controller = "Controller";
    
    public static $model = "Model";

    public static $view = "View";

    public static $helper = "Helpers";

    public static $system = "System";

    /*
    * Set Debbuger
    */
    public static $debugger = false;

    public static $namespace = array(
        "aplication" => "App"
    );

    public static $helpers = array();

    public static function define($key, $value) 
    {
        define($key,self::barderInDirectories($value));
    }

    public static function barderInDirectories($value) 
    {
        return str_replace(self::$preg, DIRECTORY_SEPARATOR, $value);
    }
}
