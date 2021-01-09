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
    const notificationController = 'NotificationController@';
    
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
    
    $router->group(["prefix" => "notify"], function () use ($router) {
        //
        $router->group(["prefix" => "/user"], function () use ($router) {
            $router->post('/send', notificationController . 'user');
            $router->post('/list', notificationController . 'all');
            $router->post('/list/unread', notificationController . 'unread');
            $router->post('/list/read', notificationController . 'read');
            $router->post('/read', notificationController . 'readByID');
            $router->post('/sms', notificationController . 'userSms');
            $router->post('/push/save-token', notificationController . 'saveToken');
            $router->post('/push', notificationController . 'sendNotificationToUser');
        });
        //
        $router->post('/email', notificationController . 'email');
        //
        $router->post('/sms', notificationController . 'sms');
        //
        $router->post('/push/all', notificationController . 'sendNotificationToAllUser');
    });
  
   
   
