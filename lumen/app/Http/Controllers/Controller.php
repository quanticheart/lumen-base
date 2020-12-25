<?php
    
    namespace App\Http\Controllers;
    
    use Laravel\Lumen\Routing\Controller as BaseController;
    use Tymon\JWTAuth\JWTAuth;

    class Controller extends BaseController {
        
        protected $jwt;
        
        /**
         * Controller constructor.
         * @param JWTAuth $jwt for valid connect
         * @param array $except for exclude connection jwt validation
         */
        function __construct(JWTAuth $jwt, $except = []) {
            $this->jwt = $jwt;
            $this->middleware('auth:api', ['except' => $except]);
        }
    }
