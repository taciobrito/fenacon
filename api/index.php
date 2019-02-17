<?php
    require __DIR__ . "/app/config/Config.php";
    // require __DIR__ . "/app/config/newVerbs.php";

    Config::define("BASEPATH", __DIR__);
    Config::define("BASEPATHSYSTEM", BASEPATH . DIRECTORY_SEPARATOR . Config::$system);
    Config::define("APPPATH", BASEPATH . DIRECTORY_SEPARATOR . Config::$application);
    
    Config::define("CONTROLLER", APPPATH . DIRECTORY_SEPARATOR . Config::$controller . DIRECTORY_SEPARATOR);
    Config::define("VIEW", APPPATH . DIRECTORY_SEPARATOR . Config::$view . DIRECTORY_SEPARATOR);
    Config::define("MODEL", APPPATH . DIRECTORY_SEPARATOR . Config::$model . DIRECTORY_SEPARATOR);
    Config::define("HELPERS", BASEPATHSYSTEM . DIRECTORY_SEPARATOR . Config::$helper . DIRECTORY_SEPARATOR);

    Config::define('BASE_URL', Config::$base_url);
    
    require Config::barderInDirectories(BASEPATHSYSTEM . '/Autoloader/Autoload.php');

    $auto = new Autoload();
    $auto->register();

    try {
        $start = new \System\System;
        $start->run();
    } catch (\Exception $e) {
         require_once VIEW . 'errors/404.php';
         // echo "Error! " . $e->getMessage();
    }

    if (Config::$debugger) $auto->getDebugger();
