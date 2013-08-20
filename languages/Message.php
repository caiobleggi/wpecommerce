<?php

/*
************************************************************************
Copyright [2013] [PagSeguro Internet Ltda.]

Licensed under the Apache License, Version 2.0 (the "License");
you may not use this file except in compliance with the License.
You may obtain a copy of the License at

http://www.apache.org/licenses/LICENSE-2.0

Unless required by applicable law or agreed to in writing, software
distributed under the License is distributed on an "AS IS" BASIS,
WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
See the License for the specific language governing permissions and
limitations under the License.
************************************************************************
*/

 /**
  * Class responsible for translating the text displayed in the system /Message
  */
 class Message{
        
        /**
        * Portuguese
        */
        private static $language = 'pt_BR';
        
        /**
        * Message to be displayed if any errors were launched by PagSeguro
        */
        private static $error_en = 'Sorry, unfortunately there was an error during checkout. Please contact the store administrator if the problem persists.';
        private static $error_br = 'Desculpe, infelizmente ocorreu um erro durante a finalização da compra. Por favor entre em contato com o administrador da loja se o problema persistir.';
        
        /**
         * /Method info_account
         * @var string
         */
        public static  $lbl_email = 'E-Mail';
        private static $info_account_en = 'Do not have a PagSeguro account? <a href="https://pagseguro.uol.com.br/registration/registration.jhtml?ep=12&tipo=cadastro#!vendedor" target="_blank">Click here </a> and register for free.';
        private static $info_account_br = 'Não tem conta no PagSeguro? <a href="https://pagseguro.uol.com.br/registration/registration.jhtml?ep=12&tipo=cadastro#!vendedor" target="_blank">Clique aqui </a> e se cadastre grátis.';
        
        /**
         * /Method path_log
         * @var string
         */
        private static $path_log_en = 'Path to the log file.';
        private static $path_log_br = 'Caminho para o arquivo de log.';
        
        /**
         * /Method log_file
         * @var string
         */
        public static $lbl_log = 'Log';
        private static $log_file_en = 'Create log file?';
        private static $log_file_br = 'Criar arquivo de log?';
        
        /**
         * /Method set_charset
         * @var string 
         */
        public static $lbl_charset = 'Charset';
        private static $set_charset_en = 'Set the charset according to the coding of your system.';
        private static $set_charset_br = 'Definir o charset de acordo com a codificação do seu sistema.';
        
        /**
         * /Method not_token
         * @var string 
         */
        public static  $lbl_token = 'Token';
        private static $not_token_en = 'Do not have or do not know your token? <a href="https://pagseguro.uol.com.br/integracao/token-de-seguranca.jhtml" target=\"_blank\">Click here </a> to generate a new one.';
        private static $not_token_br = 'Não tem ou não sabe seu token? <a href="https://pagseguro.uol.com.br/integracao/token-de-seguranca.jhtml" target=\"_blank\">Clique aqui </a> para gerar um novo.';
        
        /**
         * /Method redirected_store
         * @var string
         */
        private static $redirected_store_en = 'Your customer will be redirected back to your store or to the URL entered in this field. <a href="https://pagseguro.uol.com.br/integracao/pagamentos-via-api.jhtml" target=\"_blank\">Click here </a> to activate.';
        private static $redirected_store_br = 'Seu cliente será redirecionado para sua loja ou para a URL que você informar neste campo. <a href="https://pagseguro.uol.com.br/integracao/pagamentos-via-api.jhtml" target=\"_blank\">Clique aqui </a> para ativar.';
        
        /**
         * /Method notification_store
         * @var string
         */
        private static $notification_store_en = 'Whenever a transaction change its status, PagSeguro sends a notification to your store or to the URL entered in this field.';
        private static $notification_store_br = 'Sempre que uma transação mudar de status, PagSeguro envia uma notificação para sua loja ou para a URL que você informar neste campo.';
        
        /**
         * /Method lbl_redirect
         * @var string
         */
        private static $lbl_redirect_en = 'Redirect URL';
        private static $lbl_redirect_br = 'URL de Redirecionamento';
        
        /**
         * /Method lbl_notification
         * @var string
         */
        private static $lbl_notification_en = 'Notification URL';
        private static $lbl_notification_br = 'URL de Notificação';
        
        /**
         * /Method lbl_directory
         * @var string
         */
        private static $lbl_directory_en = 'Directory';
        private static $lbl_directory_br = 'Diretório';
        
        /**
         * Method lbl_yes
         * @var string
         */
        private static $lbl_yes_en = 'Yes';
        private static $lbl_yes_br = 'Sim';
        
        /**
         * /Method lbl_no
         * @var string
         */
        private static $lbl_no_en = 'No';
        private static $lbl_no_br = 'Não';
        
        /**
         * Error
         * @return string 
         */
        public static function error(){
            if( self::language_br() )
                return self::$error_br;
            
            return self::$error_en;
        }
        
        /**
         * Info Account
         * @return string
         */
        public static function info_account(){
            if( self::language_br() )
                return self::$info_account_br;
            
            return self::$info_account_en;
        }
        
        /**
         * Path Log
         * @return string
         */
        public static function path_log(){
            if( self::language_br() )
                return self::$path_log_br;
            
            return self::$path_log_en;
        }
        
        /**
         * Log File
         * @return string
         */
        public static function log_file(){
            if( self::language_br() )
                return self::$log_file_br;
            
            return self::$log_file_en;
        }
        
        /**
         * Set Charset
         * @return string
         */
        public static function set_charset(){
            if( self::language_br() )
                return self::$set_charset_br;
            
            return self::$set_charset_en;
        }
        
        /**
         * Redirected Store
         * @return string
         */
        public static function redirected_store(){
            if( self::language_br() )
                return self::$redirected_store_br;
            
            return self::$redirected_store_en;
        }
        
        /**
         * Not Token
         * @return string
         */
        public static function not_token(){
            if( self::language_br() )
                return self::$not_token_br;
            
            return self::$not_token_en;
        }
        
        /**
         * Notification Store
         * @return string
         */
        public static function notification_store(){
            if( self::language_br() )
                return self::$notification_store_br;
            
            return self::$notification_store_en;
        }
        
        /**
         * Lbl Redirect
         * @return string
         */
        public static function lbl_redirect(){
            if( self::language_br() )
                return self::$lbl_redirect_br;
            
            return self::$lbl_redirect_en;
        }
        
        /**
         * Lbl Notification
         * @return string
         */
        public static function lbl_notification(){
            if( self::language_br() )
                return self::$lbl_notification_br;
            
            return self::$lbl_notification_en;
        } 
        
        /**
         * Lbl Directory
         * @return string
         */
        public static function lbl_directory(){
            if( self::language_br() )
                return self::$lbl_directory_br;
            
            return self::$lbl_directory_en;
        }
        
        /**
         * Lbl Yes
         * @return String
         */
        public static function lbl_yes(){
            if( self::language_br() )
                return self::$lbl_yes_br;
            
            return self::$lbl_yes_en;
        }
        
        /**
         * Lbl No
         * @return string
         */
         public static function lbl_no(){
            if( self::language_br() )
                return self::$lbl_no_br;
            
            return self::$lbl_no_en;
        }
        
        /**
         * Checks if the system language is Portuguese 
         * @return boolean
         */
        private static function language_br(){
            if(get_locale() == self::$language )
                return true;
            
            return false;
        }
    }
?>