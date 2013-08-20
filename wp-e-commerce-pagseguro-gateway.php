<?php 
/**
 * Plugin Name: WP e-Commerce PagSeguro Oficial
 * Plugin URI: https://pagseguro.uol.com.br/v2/guia-de-integracao/downloads.html#!Modulos
 * Description: Ofereça PagSeguro em seu e-commerce e receba pagamentos por cartão de crédito, transferência bancária e boleto.
 * Author: PagSeguro Internet LTDA.
 * Author URI: https://pagseguro.uol.com.br
 * Version: 1.0 
 */

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
 * Variables of information of gateways
 */
$nzshpcrt_gateways[$num]['name'] =  'PagSeguro';
$nzshpcrt_gateways[$num]['image'] = '';
$nzshpcrt_gateways[$num]['internalname'] = 'pagseguro';
$nzshpcrt_gateways[$num]['form'] = "form_pagseguro";
$nzshpcrt_gateways[$num]['submit_function'] = "submit_pagseguro";
$nzshpcrt_gateways[$num]['function'] = 'gateway_pagseguro';
$nzshpcrt_gateways[$num]['is_exclusive'] = true;
$nzshpcrt_gateways[$num]['payment_type'] = "pagseguro_checkout";
$nzshpcrt_gateways[$num]['display_name'] = 'PagSeguro';

require_once( WP_PLUGIN_DIR . '/wp-e-commerce/wpsc-includes/merchant.class.php' );
require_once('classes/form.php');
require_once 'languages/Message.php';
require_once('classes/checkout.php');
require_once('PagSeguroLibrary/PagSeguroLibrary.php');
require_once(realpath(dirname(dirname(__FILE__))) . '/wp-e-commerce/wpsc-core/wpsc-functions.php');
require_once(realpath(dirname(dirname(__FILE__))) . '/wp-e-commerce/wpsc-includes/merchant.class.php');
require_once(realpath(dirname(dirname(__FILE__))) . '/wp-e-commerce/wpsc-includes/purchaselogs.class.php');
require_once(realpath(dirname(dirname(__FILE__))) . '/wp-e-commerce/wpsc-theme/functions/wpsc-transaction_results_functions.php');



/**
 * Create form admin
 * @return html
 */
function form_pagseguro(){
    $form = new Form();
    return $form->form_admin();
}

/**
 * Save information admin
 * @return boolean
 */
function submit_pagseguro(){
   $form = new Form();
   foreach ( $form->getId() as $id  ) {
              update_option($id, $_POST[$id]);
	}
       set_configuration(); 
       return true;
}

/**
 * Set configuration charset and log.
 */
function set_configuration(){
    
    //setting configurated default charset.
    PagSeguroConfig::setApplicationCharset( (get_option('ps_charset') == 1) ? 'ISO-8859-1' : 'UTF-8' );
    
    // If Active Log == True, setting configurated default log info.
    if(get_option('ps_log') == 1 ){
        $directory = directoryLog();
        createLogFile($directory);
        PagSeguroConfig::activeLog($directory);
    }
}

/**
 * Return directory log.
 * @return string
 */
function directoryLog(){
    return ABSPATH.get_option('ps_directory').'/PagSeguro.log';
}

/**
 * Create file log.
 * @param type $directory
 */
function createLogFile($directory){
    try {
        $f = fopen($directory, 'a');
        fclose($f);
    } catch (Exception $exc) {
        die($exc);
    }
}

/**
 * Method call for checkout
 * @global type $wpsc_checkout
 * @param type $fromcheckout
 */
function gateway_pagseguro($fromcheckout = false){
	global $wpsc_checkout;
        
	if(!isset($wpsc_checkout)){
             new checkout();
	}
}

/**
 *  Call actions for notification
 */
function notification_pagseguro(){
    global $wpdb;
    require_once "wp-e-commerce-pagseguro-notification.php";
    
    if(isset($_REQUEST['notificationurl']) && $_REQUEST['notificationurl'] == "true" && isset($_POST)){
   
        $notification =  new notification();
        $array_notification = $notification->init($_POST);

        if( $array_notification['status'] > 0 )
           $wpdb->query( 'UPDATE ' . WPSC_TABLE_PURCHASE_LOGS . ' SET processed = "'.$wpdb->escape( $array_notification['status'] ).'" WHERE id = "' . $wpdb->escape( $array_notification['reference'] ) . '" LIMIT 1' );
        }
}

add_action('init', 'notification_pagseguro');

?>