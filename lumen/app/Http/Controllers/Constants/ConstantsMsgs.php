<?php
    
    namespace App\Http\Controllers\Constants;
    
    
    class ConstantsMsgs {
        
        public string $msgErrorTokenExpired = '';
        public string $msgErrorTokenInvalid = '';
        public string $msgErrorTokenOut = '';
        
        function __construct(string $language) {
            $this->setLanguage($language);
        }
        
        private function setLanguage(string $language) {
            switch ($language) {
                case self::eng:
                    $this->msgErrorTokenExpired = self::msgErrorTokenExpiredEng;
                    $this->msgErrorTokenInvalid = self::msgErrorTokenInvalidEng;
                    $this->msgErrorTokenOut = self::msgErrorTokenOutEng;
                    break;
                default:
                    $this->msgErrorTokenExpired = self::msgErrorTokenExpiredBR;
                    $this->msgErrorTokenInvalid = self::msgErrorTokenInvalidBR;
                    $this->msgErrorTokenOut = self::msgErrorTokenOutBR;
                    break;
            }
        }
        
        const defaultLanguage = 'pt-BR';
        private const br = 'pt-BR';
        private const eng = 'eng';
        
        /**
         * Msgs
         */
        /* pt_BR */
        const msgErrorTokenExpiredBR = 'token expidado';
        const msgErrorTokenInvalidBR = 'token invalido';
        const msgErrorTokenOutBR = 'token ausente';
        
        /* en */
        const msgErrorTokenExpiredEng = 'token expired';
        const msgErrorTokenInvalidEng = 'token invalid';
        const msgErrorTokenOutEng = 'token out';
    }
