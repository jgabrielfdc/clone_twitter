<?php

namespace MF\Controller;

abstract class Action
{
    protected $view;

    public function __construct()
    {
        $this->view = new \stdClass();
    }

    public function render($view, $layout="layout")
    {
        $this->view->page = $view;

        if(file_exists("../App/Views/" . $layout . ".phtml")){    
            require_once "../App/Views/" . $layout . ".phtml";
        }else{
            $this->content();
        }

    }

    protected function content()
    {
        // Redireciona para o caminho exato da view e qual o documento desejado
        $actualClass = get_class($this);

        $actualClass = str_replace("App\\Controllers\\", "", $actualClass);

        $actualClass = str_replace("Controller", "", $actualClass);

        $actualClass = strtolower($actualClass);
        require_once "../App/Views/" . $actualClass . "/" . $this->view->page . ".phtml";
    }
}