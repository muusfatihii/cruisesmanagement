<?php



class App{

    protected $controller = 'home';
    protected $method = 'index';
    protected $params = [];

    public function __construct(){

        $url = $this->parseUrl();

        if(isset($url[0])){

            if(file_exists('../app/controllers/'.$url[0].'.php')){

                $tempController = $url[0];
                unset($url[0]);

                if(isset($url[1])){

                    require_once '../app/controllers/'. $tempController .'.php';

                    if(method_exists(new $tempController,$url[1])){

        
                        $this->controller = $tempController;
                        $this->method = $url[1];
                        unset($url[1]);


                        $this->params = $url ? array_values($url) : [];


                        
                        $this->controller = new $this->controller;
                        call_user_func_array([$this->controller,$this->method],$this->params);
        
                    }else{

                    require_once '../app/controllers/'. $this->controller .'.php';
                    $this->controller = new $this->controller;
                    call_user_func_array([$this->controller,$this->method],$this->params);


                    }

                }else{

                    require_once '../app/controllers/'. $this->controller .'.php';
                    $this->controller = new $this->controller;
                    call_user_func_array([$this->controller,$this->method],$this->params);

                }
    
            }else{

                require_once '../app/controllers/'. $this->controller .'.php';
                $this->controller = new $this->controller;
                call_user_func_array([$this->controller,$this->method],$this->params);
            }

        }else{

            require_once '../app/controllers/'. $this->controller .'.php';

            $this->controller = new $this->controller;
            
            call_user_func_array([$this->controller,$this->method],$this->params);

        }
        
    }

    public function parseUrl(){

        if(isset($_GET['url'])){
            
            return explode('/',filter_var(rtrim($_GET['url'],'/'), FILTER_SANITIZE_URL));
        }
    }
}