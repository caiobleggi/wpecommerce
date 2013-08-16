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
 * Class Form
 */
class Form{
    
    /**
     * <tr>
     * @var type string
     */
    private $open_tr = '<tr>';
    
     /**
     * </tr>
     * @var type string
     */
    private $close_tr = '</tr>';
        
     /**
     * <td>
     * @var type string
     */
    private $open_td = '<td>';
    
     /**
     * </td>
     * @var type string
     */
    private $close_td = '</td>';
    
    /**
     * Open class for description
     * @var type string
     */
    private $open_class_description = "<p class='description'>";
    
    /**
     * Close class for description
     * @var type string
     */
    private $close_class_description = "</p>";
            
     /**
     * array $properties
     * @var type array
     */
    private $properties;
    
    /**
     * 
     * @var type array
     */
    private $selected_charset;
    
    /**
     *
     * @var type array
     */
    private $checked_log;
    
    /**
     * Create form admin
     * @return html form admin
     */
    function form_admin(){
        
        $this->properties = $this->properties();
        
        $yes = __( 'Yes' );
        $no  = __( 'No' );
               
     	return <<<EOF
         $this->open_tr 
            $this->open_td
                <label for="ps_email"> {$this->properties['email']['lbl_email']} :</label>
            $this->close_td
                $this->open_td
                    <input type="text" name="ps_email" id="ps_email" value="{$this->properties['email']['value']}">
                    $this->open_class_description{$this->properties['email']['info_email']}$this->close_class_description  
                $this->close_td
        $this->close_tr
            
        $this->open_tr 
            $this->open_td
                <label for="ps_token"> {$this->properties['token']['lbl_token']} :</label>
            $this->close_td
                $this->open_td
                    <input type="text" name="ps_token" id="ps_token" value="{$this->properties['token']['value']}">
                    $this->open_class_description{$this->properties['token']['info_token']}$this->close_class_description    
                $this->close_td
        $this->close_tr
            
        $this->open_tr 
            $this->open_td
                <label for="ps_redirect"> {$this->properties['redirect']['lbl_redirect']} :</label>
            $this->close_td
                $this->open_td
                    <input type="text" name="ps_redirect" id="ps_redirect" value="{$this->properties['redirect']['value']}">
                    $this->open_class_description{$this->properties['redirect']['info_redirect']}$this->close_class_description     
                $this->close_td
        $this->close_tr
            
        $this->open_tr 
            $this->open_td
                <label for="ps_notification"> {$this->properties['notification']['lbl_notification']} :</label>
            $this->close_td
                $this->open_td
                    <input type="text" name="ps_notification" id="ps_notification" value="{$this->properties['notification']['value']}">
                    $this->open_class_description{$this->properties['notification']['info_notification']}$this->close_class_description    
                $this->close_td
        $this->close_tr
            
        $this->open_tr 
            $this->open_td
                <label for="ps_charset"> {$this->properties['charset']['lbl_charset']} :</label>
            $this->close_td
                $this->open_td
                    <select id="ps_charset" name="ps_charset">
                        <option value="1" {$this->selected_charset['utf']}>UTF-8</option>
                        <option value="2" {$this->selected_charset['iso']}>ISO-8859-1</option>
                    </select>
                    $this->open_class_description{$this->properties['charset']['info_charset']}$this->close_class_description    
                $this->close_td
        $this->close_tr
            
        $this->open_tr 
            $this->open_td
                <label for="ps_log"> {$this->properties['log']['lbl_log']} :</label>
            $this->close_td
                $this->open_td
                   <input type="radio" name="ps_log" id="ps_log" value="1" {$this->checked_log['yes']}> {$yes}
                   <input type="radio" name="ps_log" id="ps_log" value="0" {$this->checked_log['no']}> {$no}
                    $this->open_class_description{$this->properties['log']['info_log']}$this->close_class_description    
                $this->close_td
        $this->close_tr
          
        $this->open_tr
            $this->open_td
                <label for="ps_directory"> {$this->properties['directory']['lbl_directory']} :</label>
            $this->close_td
                $this->open_td
                   <input type="texte" name="ps_directory" id="ps_directory" value="{$this->properties['directory']['value']}">
                    $this->open_class_description{$this->properties['directory']['info_directory']}$this->close_class_description    
                $this->close_td
        $this->close_tr
EOF;
        
}    
    /**
     * Properties html
     * @return type array
     */
    private function properties(){
        $this->selected_checked();
        
        return array(
            "email" => array(
                "lbl_email" => __( 'E-Mail' ),
                "info_email" => __( 'Do not have a PagSeguro account? <a href="https://pagseguro.uol.com.br/registration/registration.jhtml?ep=12&tipo=cadastro#!vendedor" target="_blank">Click here </a> and register for free.' ), 
                "value" => get_option('ps_email')
            ),
            "token" => array(
                "lbl_token" => __( 'Token' ),
                "info_token" => __( 'Do not have or do not know your token? <a href="https://pagseguro.uol.com.br/integracao/token-de-seguranca.jhtml" target="_blank">Click here </a> to generate a new one.' ),
                "value" => get_option('ps_token')
            ),
            "redirect" => array(
                "lbl_redirect" => __( 'Redirect URL' ),
                "info_redirect" => __( 'Your customer will be redirected back to your store or to the URL entered in this field. <a href="https://pagseguro.uol.com.br/integracao/pagamentos-via-api.jhtml" target="_blank">Click here </a> to activate.' ),
                "value" => get_option('ps_redirect')
            ),
            "notification" => array(
                "lbl_notification" => __( 'Notification URL' ),
                "info_notification" => __( 'Whenever a transaction change its status, PagSeguro sends a notification to your store or to the URL entered in this field.' ),
                "value" => ( get_option('ps_notification') != null && get_option('ps_notification') != '' ) ? get_option('ps_notification') : home_url().'/index.php?notificationurl=true'
            ),
             "charset" => array(
                "lbl_charset" => __( 'Charset' ),
                "info_charset" => __( 'Set the charset according to the coding of your system.' ),
                "value" => get_option('ps_charset')
            ),
            "log" => array(
                "lbl_log" => __( 'Log' ),
                "info_log" => __( 'Create log file?' ),
                "value" => get_option('ps_log')
            ),
            "directory" => array(
                "lbl_directory" => __( 'Directory' ),
                "info_directory" => __( 'Path to the log file.' ),
                "value" => get_option('ps_directory')
            ),
        );
    }
    
    /**
     * Selected and Checked of values 
     */
    private function selected_checked(){
        
        $this->selected_charset = array(
            'utf' => (get_option('ps_charset') == 1 || get_option('ps_charset') == '') ? "selected='selected'" : '',
            'iso' => (get_option('ps_charset') == 2) ? "selected='selected'" : ''
        );
        
        $this->checked_log = array(
            'yes' => (get_option('ps_log') == 1) ? "checked='checked'" : '',
            'no'  => (get_option('ps_log') == 0 || get_option('ps_log') == '') ? "checked='checked'" : ''
        );
    }
    
    /**
     * Id and name fields form
     * @return type array
     */
    public function getId(){
        return array(
            "ps_email",
            "ps_token",
            "ps_redirect",
            "ps_notification",
            "ps_charset",
            "ps_log",
            "ps_directory"       
        );
    }
}
?>