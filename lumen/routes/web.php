<?php
    
    /** @var Router $router */
    
    /*
    |--------------------------------------------------------------------------
    | Application Routes
    |--------------------------------------------------------------------------
    |
    | Here is where you can register all of the routes for an application.
    | It is a breeze. Simply tell Lumen the URIs it should respond to
    | and give it the Closure to call when that URI is requested.
    |
    */
    
    use Laravel\Lumen\Routing\Router;
    
    const userController = 'UserController@';
    const loginController = 'LoginController@';
    
    $router->group(["prefix" => "user"], function () use ($router) {
        $router->get('/list', userController . 'getUsers');
        
        $router->get('/{id}', userController . 'getUser');
        
        $router->put('/update/{id}', userController . 'updateUser');
        
        $router->delete('/delete/{id}', userController . 'deleteUser');
        
        $router->post('/insert', loginController . 'insertUser');
    
        $router->post('/session', userController . 'session');
    });
    
    $router->post('/logout', userController . 'logout');
    
    $router->post('/login', loginController . 'login');
   
   
