<?php

//Responsável por executar as rotas

namespace App;
use MF\Init\Bootstrap;

class Route extends Bootstrap
{
    protected function initRoutes()
    {
        $routes["home"] = array(
            "route" => "/",
            "controller" => "indexController",
            "action" => "index"
        );
        $routes["inscreverse"] = array(
            "route" => "/inscreverse",
            "controller" => "indexController",
            "action" => "inscreverse"
        );

        $routes["cadastro"] = array(
            "route" => "/cadastro",
            "controller" => "indexController",
            "action" => "cadastro"
        );

        $this->setRoutes($routes);
    }

}
?>