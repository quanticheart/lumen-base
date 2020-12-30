<?php
    
    namespace App\Http\Controllers\ValidateUtils;
    
    class UserUtils {
        const VALIDATE_NEW_USER = [
            'usuario' => 'required|min:5|max:80',
            'password' => 'required',
            'email' => 'required|email|unique:usuario,email'
        ];
        
        const VALIDATE_UPDATE_USER = [
            'usuario' => 'required|min:5|max:80',
            'password' => 'required'
        ];
        
        const VALIDATE_LOGIN = [
            'email' => 'required|email|max:255',
            'password' => 'required'
        ];
    }
