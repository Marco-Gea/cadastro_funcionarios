<?php

namespace App;

use MF\Init\Bootstrap;

//Application's routes
class Route extends BootStrap{

    // Mapping the routes and yours action in application
    protected function initRoutes(){
        
        $routes["index"] = Array(
            'route' => '/',
            'controller' => 'AppController',
            'action' => 'index'
        );

        $routes["form"] = Array(
            'route' => '/form',
            'controller' => 'AppController',
            'action' => 'form'
        );

        $routes["create"] = Array(
            'route' => '/create',
            'controller' => 'AppController',
            'action' => 'create'
        );

        $routes["funcionario"] = Array(
            'route' => '/funcionario',
            'controller' => 'AppController',
            'action' => 'funcionario'
        );

        $routes["delete"] = Array(
            'route' => '/delete',
            'controller' => 'AppController',
            'action' => 'delete'
        );

        $routes["update"] = Array(
            'route' => '/update',
            'controller' => 'AppController',
            'action' => 'update'
        );


        $this->setRoutes($routes);
    }

}

?>