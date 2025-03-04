<?php

use Illuminate\Routing\Router;

$router->group(['prefix' => '/iorder/v1'], function (Router $router) {
  $router->apiCrud([
    'module' => 'iorder',
    'prefix' => 'orders',
    'controller' => 'OrderApiController',
    'permission' => 'iorder.orders',
    //'middleware' => ['create' => [], 'index' => [], 'show' => [], 'update' => [], 'delete' => [], 'restore' => []],
    // 'customRoutes' => [ // Include custom routes if needed
    //  [
    //    'method' => 'post', // get,post,put....
    //    'path' => '/some-path', // Route Path
    //    'uses' => 'ControllerMethodName', //Name of the controller method to use
    //    'middleware' => [] // if not set up middleware, auth:api will be the default
    //  ]
    // ]
  ]);
  $router->apiCrud([
    'module' => 'iorder',
    'prefix' => 'items',
    'controller' => 'ItemApiController',
    'permission' => 'iorder.items',
    //'middleware' => ['create' => [], 'index' => [], 'show' => [], 'update' => [], 'delete' => [], 'restore' => []],
    // 'customRoutes' => [ // Include custom routes if needed
    //  [
    //    'method' => 'post', // get,post,put....
    //    'path' => '/some-path', // Route Path
    //    'uses' => 'ControllerMethodName', //Name of the controller method to use
    //    'middleware' => [] // if not set up middleware, auth:api will be the default
    //  ]
    // ]
  ]);
  $router->apiCrud([
    'module' => 'iorder',
    'prefix' => 'supplies',
    'controller' => 'SupplyApiController',
    'permission' => 'iorder.supplies',
    //'middleware' => ['create' => [], 'index' => [], 'show' => [], 'update' => [], 'delete' => [], 'restore' => []],
    // 'customRoutes' => [ // Include custom routes if needed
    //  [
    //    'method' => 'post', // get,post,put....
    //    'path' => '/some-path', // Route Path
    //    'uses' => 'ControllerMethodName', //Name of the controller method to use
    //    'middleware' => [] // if not set up middleware, auth:api will be the default
    //  ]
    // ]
  ]);
  $router->apiCrud([
    'module' => 'iorder',
    'prefix' => 'types',
    'staticEntity' => 'Modules\Iorder\Entities\Type',
    //'middleware' => ['create' => [], 'index' => [], 'show' => [], 'update' => [], 'delete' => [], 'restore' => []]
  ]);
  $router->apiCrud([
    'module' => 'iorder',
    'prefix' => 'statuses',
    'staticEntity' => 'Modules\Iorder\Entities\Status',
    //'middleware' => ['create' => [], 'index' => [], 'show' => [], 'update' => [], 'delete' => [], 'restore' => []]
  ]);
// append


});
