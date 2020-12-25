<?php
    
    namespace App\Http\Controllers\Constants;
    
    
    class ResponseConstants {
        
        /**
         * Msgs
         */
        /* TOKEN */
        public string $msgErrorTokenExpired = 'token expired';
        const msgErrorTokenInvalid = 'token invalid';
        const msgErrorTokenOut = 'token out';
        
        /**
         * Code Errors
         */
        
        /* TOKEN */
        const codeErrorTokenExpired = 10;
        const codeErrorTokenInvalid = 11;
        const codeErrorTokenOut = 12;
    }
