<?php 
    namespace System;

    use System\System;

    class Controller extends System 
    {

        function __construct () {
            header("Access-Control-Allow-Origin: *");
            header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
            header("Access-Control-Max-Age: 10000");
            header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
            // // header("Content-Type: Application/json");
        }
        
        protected function view($name, $data = null)
        {
            if (is_array($data) && count($data) > 0) {
                extract($data);
            }
            $file = APPPATH . DIRECTORY_SEPARATOR . \Config::$view . DIRECTORY_SEPARATOR . $name;
            require_once file_exists($file . '.php') ? $file . '.php' : $file . '.html';
        }

        protected function url($page = '')
        {
            $base = BASE_URL == '/' || BASE_URL == '' ? $_SERVER['SERVER_NAME'].':'.$_SERVER['SERVER_PORT'].'/' : BASE_URL;
            return $base . $page;
        }

        protected function dd($value, $exit = false)
        {   
            echo "<pre>"; 
            print_r($value);
            echo "</pre>";
            if ($exit) exit();
        }

        public function has_post($key)
        {
            return !empty($_POST[$key]);
        }

        public function post($key = '')
        {
            if ($key != '') {
                return $this->AddSlashRecursiveArray($_POST[$key]);
            } else {
                $post = array();
                foreach ($_POST as $key => $value) {
                    $post[$key] = $this->AddSlashRecursiveArray($value);
                }
                return $post;
            }
        }

        public function has_get($key)
        {
            return !empty($_GET[$key]);
        }

        public function get($key = '')
        {    
            if ($key != '') {
                return $this->AddSlashRecursiveArray($_GET[$key]);
            } else {
                $get = array();
                foreach ($_GET as $key => $value) {
                    $get[$key] = $this->AddSlashRecursiveArray($value);
                }
                return $get;
            }
        }

        private function AddSlashRecursiveArray ($array) {
            if (is_array($array)) {
                foreach ($array as $key => $value) {
                    $array[$key] = $this->AddSlashRecursiveArray($value);
                }
                return $array;
            } else {
                return addslashes($array);
            }
        }

        public function response_json($response, $code = 200)
        {
            http_response_code($code);
            echo json_encode($response);
        }

        public function session($key = '', $value = '')
        {    
            if ($key != '') {
                if ($value != '') {
                    $_SESSION[$key] = $value;
                } else {
                    return $_SESSION[$key];
                }
            } else {
                return $_SESSION;
            }
        }

        public function auth_user()
        {
            return $this->session('usuarioLogado');
        }

        public function method()
        {
            return $_SERVER['REQUEST_METHOD'];
        }

        // public function dateToDb($date) {
        //     if (!empty($date)) {
        //         $date = explode("/", $date);
        //         $date = $date[2] . '-' . $date[1] . '-' . $date[0];
        //     } else
        //         $date = '0000-00-00';
        //     return $date;
        // }

        // public function dateFormat($date) {
        //     if(!empty($date()) {
        //         $date = explode("-", $date);
        //         $date = $date[2] . '/' . $date[1] . '/' . $date[0];
        //     } else $date = '';
        //     return $date;
        // }

    }