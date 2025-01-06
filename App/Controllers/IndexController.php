<?php
namespace App\Controllers;

// OS recursos do Miniframework
use MF\Controller\Action;
use MF\Model\Container;

class indexController extends Action{

    public function index($path){

       // Instanciar Modelo
       $produto=Container::getModel("Produto");

       $arrayProdutos=$produto->getProdutos();

       $this->view->dados=$arrayProdutos;

       $this->render($path,"layout1");
    }

    public function sobre_nos($path){
        $info=Container::getModel("Info");

        $arrayInfo=$info->getInfo();

        $this->view->dados=$arrayInfo;

        $this->render($path,"layout2");
    }
    
    public function conteudo($path){
        $this->render($path,"layout1");
    }
    
}