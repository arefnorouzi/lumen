<?php
$prefix = env('API_VERSION').'/category';
$router = $this->app->router;
$router->group(['prefix'=> $prefix,'namespace' => 'Modules\CategoryPack'], function () use ($router){

    $router->get('/', ['uses' => 'CategoryController@index']);
    $router->get('/{id}', ['uses' => 'CategoryController@show']);
});

