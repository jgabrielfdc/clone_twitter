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


        // ? AuthController
        $routes["autenticar"] = array(
            "route" => "/autenticar",
            "controller" => "authController",
            "action" => "autenticar"
        );
        
        $routes["sair"] = array(
            "route" => "/sair",
            "controller" => "authController",
            "action" => "sair"
        );
        

        // ? AppController
        $routes["timeline"] = array(
            "route" => "/timeline",
            "controller" => "appController",
            "action" => "timeline"
        );

        $routes["tweet"] = array(
            "route" => "/tweet",
            "controller" => "appController",
            "action" => "tweet"
        );

        $routes["deletar"] = array(
            "route" => "/deletar",
            "controller" => "appController",
            "action" => "deletar"
        );

        $routes["quem_seguir"] = array(
            "route" => "/quem_seguir",
            "controller" => "appController",
            "action" => "quem_seguir"
        );
        
        $routes["acao"] = array(
            "route" => "/acao",
            "controller" => "appController",
            "action" => "acao"
        );

        $this->setRoutes($routes);
    }

}
?>