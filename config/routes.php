<?php


use Cake\Routing\Route\DashedRoute;
use Cake\Routing\RouteBuilder;

return static function (RouteBuilder $routes) {

    $routes->setRouteClass(DashedRoute::class);

    $routes->scope('/', function (RouteBuilder $builder) {
  
        $builder->connect('/persons/add', ['controller' => 'Persons', 'action' => 'add', 'index']);
        $builder->connect('/users/login', ['controller' => 'users', 'action' => 'login', 'login']);
        $builder->connect('/persons/download/*', ['controller' => 'Persons', 'action' => 'download']);

      
        $builder->connect('/pages/*', 'Pages::display');
    
      
 

    
        $builder->fallbacks();
    });

};
