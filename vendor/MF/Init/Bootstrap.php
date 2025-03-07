<?php

namespace MF\Init;

abstract class Bootstrap{
    private $routes;

    abstract protected function initRoutes();

    public function __construct(){
        $this->initRoutes();
        $this->run($this->getURL());
    }
    public function getRoutes(){
        return $this->routes;
    }

    public function setRoutes(array $routes){
        $this->routes = $routes;
    }
    protected function run($url){
        foreach($this->getRoutes() as $route){
            if($url==$route['route']){
                $class="App\\Controllers\\".ucfirst($route['controller']); // Escreve a classe a ser chamada
                $action=$route['action']; // Seleciona a Action a ser executada e pega o nome do arquivo a ser

                $objct=new $class;
                $objct->$action($action);
            }
        }
    }
    protected function getURL()
    {
        // Assim eu recupero somente o caminho encaminhado na url
        return parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    }
}