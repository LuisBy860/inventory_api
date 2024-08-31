<?php
use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;

return function (App $app) {
    $app->get('/products', 'ProductController:getAllProducts');
    $app->get('/products/{id}', 'ProductController:getProduct');
    $app->post('/products', 'ProductController:createProduct');
    $app->put('/products/{id}', 'ProductController:updateProduct');
    $app->delete('/products/{id}', 'ProductController:deleteProduct');
};
