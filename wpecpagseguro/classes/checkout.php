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
 * Class for Checkout PagSeguro.
 */
class checkout extends wpsc_merchant
{

    /**
     * Version Api
     * @var type int
     */
    private $api_version = '1.1';

    /**
     * Version WP e-Commerce.
     * @var type int
     */
    private $cms_version = WPSC_PRESENTABLE_VERSION;

    /**
     *
     * @var pagSeguroPaymentRequestObject
     */
    private $_pagSeguroPaymentRequestObject;

    /**
     *
     * @var Credential
     */
    private $_credential;

    /**
     *
     * @var url PagSeguro
     */
    private $_urlPagSeguro;

    /**
     *
     * @var array
     */
    private $_infoItem;

    /**
     * Construct
     * @global type $wpsc_cart
     */
    function __construct()
    {
        global $wpsc_cart;
        
        $this->activeLog();
        $this->set_api_version();
        $this->set_cms_version();

        $this->_infoItem = new wpsc_purchaselogs_items($wpsc_cart->log_id);
        $this->_pagSeguroPaymentRequestObject = $this->generatePagSeguroPaymentRequestObject();
        $this->_pagSeguroPaymentRequestObject->setReference($wpsc_cart->log_id);
        $this->performPagSeguroRequest($this->_pagSeguroPaymentRequestObject);

        if ($this->_urlPagSeguro != '')
            $this->redirect();
        else
            $this->error();
    }

    /**
     * Active log.
     */
    function activeLog()
    {
        PagSeguroConfig::activeLog(ABSPATH . get_option('ps_directory') . '/PagSeguro.log');
    }

    /**
     * Set Version Api.
     */
    function set_api_version()
    {
        PagSeguroLibrary::setModuleVersion('wpecommerce:' . $this->api_version);
    }

    /**
     * Set Version WP e-Commerce.
     */
    function set_cms_version()
    {
        PagSeguroLibrary::setCMSVersion('wpecommerce:' . $this->cms_version);
    }

    /**
     * Generate PagSeguro Payment Request
     * @return \PagSeguroPaymentRequest
     */
    function generatePagSeguroPaymentRequestObject()
    {

        $paymentRequest = new PagSeguroPaymentRequest();
        $paymentRequest->setCurrency(PagSeguroCurrencies::getIsoCodeByName("REAL"));
        $paymentRequest->setExtraAmount($this->extraAmount());
        $paymentRequest->setRedirectURL($this->redirectURL());
        $paymentRequest->setNotificationURL($this->notificationURL());
        $paymentRequest->setItems($this->items());
        $paymentRequest->setSender($this->sender());
        $paymentRequest->setShipping($this->shipping());
        return $paymentRequest;
    }

    /**
     * Calculate total discount of cart
     * @global type $wpsc_cart
     * @return type
     */
    function extraAmount()
    {
        global $wpsc_cart;
        if ($this->_infoItem->extrainfo->wpec_taxes_total > 0 && $wpsc_cart->coupons_amount > 0)
            return number_format(($this->_infoItem->extrainfo->wpec_taxes_total - $wpsc_cart->coupons_amount), 2, '.', '.');
        else
            if ($this->_infoItem->extrainfo->wpec_taxes_total > 0)
                return number_format($this->_infoItem->extrainfo->wpec_taxes_total , 2, '.', '.');
            else
                if ($wpsc_cart->coupons_amount > 0)
                    return number_format(($wpsc_cart->coupons_amount * -1), 2, '.', '.');

        return 0;
    }

    /**
     * Redirect Url
     * @return url
     */
    function redirectURL()
    {
        $url = get_option( 'transact_url' ).'&sessionid=' . $this->_infoItem->extrainfo->sessionid;

        if (get_option('ps_redirect') != null && get_option('ps_redirect') != '')
            $url = get_option('ps_redirect');

        return $url;
    }

    /**
     * Notification url
     * @return url
     */
    function notificationURL()
    {
        $url = home_url() . '/index.php?notificationurl=true';

        if (get_option('ps_notification') != null && get_option('ps_notification') != '')
            $url = get_option('ps_notification');

        return $url;
    }

    /**
     * Generate PagSeguro Products
     * @global type $wpsc_cart
     * @return array
     */
    function items()
    {
        global $wpsc_cart;

        $pagSeguroItems = array();
        $cont = 1;

        foreach ($wpsc_cart->cart_items as $product) {
            $item = new PagSeguroItem();
            $item->setId($cont++);
            $item->setDescription($product->product_name);
            $item->setQuantity($product->quantity);
            $item->setAmount($product->unit_price);
            $item->setWeight($product->weight * 1000);
            array_push($pagSeguroItems, $item);
        }
        return $pagSeguroItems;
    }

    /**
     * Generate PagSeguro Sender Data
     * @return \PagSeguroSender
     */
    function sender()
    {
        $sender = new PagSeguroSender();
        $sender->setEmail(str_replace(" ", "", $this->_infoItem->userinfo['billingemail']['value']));
        $sender->setName($this->_infoItem->userinfo['billingfirstname']['value'] . ' ' . $this->_infoItem->userinfo['billinglastname']['value']);
        $sender->setPhone(floatval(preg_replace('/[^A-Za-z0-9]/', "", $this->_infoItem->userinfo['billingphone']['value'])));
        return $sender;
    }

    /**
     * Generate PagSeguro Shipping Data
     * @return \PagSeguroShipping
     */
    function shipping()
    {
        $shipping = new PagSeguroShipping();
        $shipping->setAddress($this->address());
        $shipping->setType($this->shippingType());
        $shipping->setCost(number_format(($this->_infoItem->extrainfo->base_shipping + $this->extraShipping()), 2, '.', '.'));
        return $shipping;
    }

    /**
     * Extra shipping
     * @return number
     */
    function extraShipping()
    {

        $cost = 0;

        foreach ($this->_infoItem->allcartcontent as $pnp) {

            if ($pnp->pnp != null && $pnp->pnp > 0)
                $cost = $cost + $pnp->pnp;
        }
        return $cost;
    }

    /**
     * Generate PagSeguro Address
     * @return \PagSeguroAddress
     */
    function address()
    {
        $address = new PagSeguroAddress();
        $address->setCity(html_entity_decode($this->_infoItem->userinfo['billingcity']['value']));
        $address->setPostalCode($this->_infoItem->userinfo['billingpostcode']['value']);
        $address->setStreet(html_entity_decode($this->_infoItem->userinfo['billingaddress']['value']));
        $address->setCountry(html_entity_decode($this->_infoItem->userinfo['billingcountry']['value']));
        return $address;
    }

    /**
     * Generate PagSeguro Shiping type
     * @return \PagSeguroShippingType
     */
    function shippingType()
    {
        $type = new PagSeguroShippingType();
        $type->setByType('NOT_SPECIFIED');
        return $type;
    }

    /**
     * Perform PagSeguro Request
     * @param PagSeguroPaymentRequest $paymentRequest
     */
    function performPagSeguroRequest(PagSeguroPaymentRequest $paymentRequest)
    {

        $this->_credential = new PagSeguroAccountCredentials(get_option('ps_email'), get_option('ps_token'));
        try {
            $this->_urlPagSeguro = $paymentRequest->register($this->_credential);
        } catch (Exception $exc) {
            $this->_urlPagSeguro = '';
        }
    }

    /**
     * Redirect for payment PagSeguro.
     * @global type $wpsc_cart
     */
    function redirect()
    {
        global $wpsc_cart;
        wp_redirect($this->_urlPagSeguro);
        $wpsc_cart->empty_cart();
        exit();
    }

    /**
     * Display message error.
     */
    function error()
    {
        $this->set_error_message(Message::error());
        $this->return_to_checkout();
        exit();
    }
}
?>
