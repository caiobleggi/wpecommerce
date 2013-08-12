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


require_once 'classes/model.php';

/**
 * Class Notification
 */
class notification extends wpsc_merchant{
    
   /**
    * $_POST['notificationType']
    * @var string 
    */
    private $notification_type;
   
    /**
     * $_POST['notificationCode']
     * @var string 
     */
    private $notification_code;
    
    /**
     *
     * @var /model
     */
    private $_model;
    
    /**
     *
     * @var /PagSeguroAccountCredentials
     */
    private $_obj_credential;
    
    /**
     *
     * @var /PagSeguroNotificationType
     */
    private $_obj_notification_type;
    
    /**
     *
     * @var /PagSeguroNotificationService
     */
    private $_obj_transaction;
    
    /**
     *
     * @var integer
     */
    private $reference;
       
   /**
    * Init Notification
    * @param type $_POST
    * @return array
    */
   function init($_POST){

       $this->load();
       $this->validatePost($_POST);
       $this->createCredential();
       $this->createNotificationType();
       
       if($this->_obj_notification_type->getValue() == $this->notification_type){
          $this->createTransaction();
          return  $this->updateCms();
        }
   }
   
   /**
    * Load
    */
   function load(){
       $this->_model = new model();
   }
   
   /**
   * validete if the post is empty
   */
   function validatePost($_POST){
        $this->notification_type = (isset($_POST['notificationType']) && trim($_POST['notificationType']) != "") ? trim($_POST['notificationType']) : NULL;
        $this->notification_code = (isset($_POST['notificationCode']) && trim($_POST['notificationCode']) != "") ? trim($_POST['notificationCode']) : NULL;
    }
    
    /**
     * Create Object Credential
     */
    function createCredential(){
        $this->_obj_credential = new PagSeguroAccountCredentials(get_option('ps_email'), get_option('ps_token'));
    }
    
    /**
     * Notification Type.
     */
    function createNotificationType(){
        $this->_obj_notification_type = new PagSeguroNotificationType();
        $this->_obj_notification_type->setByType("TRANSACTION");
    }
    
    /**
     * Transaction
     */
    function createTransaction(){
	     include_once('PagSeguroLibrary/PagSeguroLibrary.php');
            $this->_obj_transaction = PagSeguroNotificationService::checkTransaction($this->_obj_credential, $this->notification_code);         
            $this->reference       = $this->_obj_transaction->getReference();
    }
    
    /**
     * Update CMS
     * @return array 
     */
    function updateCms(){
        return array(
            'reference' => $this->reference,
            'status'    =>  $this->_model->returnStatusCommerceByPagSeguro($this->_obj_transaction->getStatus()->getValue())
        );
    }
}

?>