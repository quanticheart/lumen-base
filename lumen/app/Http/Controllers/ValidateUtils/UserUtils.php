<?php
    
    namespace App\Http\Controllers\ValidateUtils;
    
    class UserUtils {
        const NEW_USER = [
            'usuario' => 'required|min:5|max:80',
            'password' => 'required',
            'email' => 'required|email|unique:usuario,email'
        ];
        
        const UPDATE_USER = [
            'usuario' => 'required|min:5|max:80',
            'password' => 'required'
        ];
    }
