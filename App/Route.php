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

        $routes["conteudo"] = array(
            "route" => "/conteudo",
            "controller" => "IndexController",
            "action" => "conteudo"
        );

        $routes["sobre_nos"] = array(
            "route" => "/sobre_nos",
            "controller" => "IndexController",
            "action" => "sobre_nos"
        );

        $this->setRoutes($routes);
    }

}
?>