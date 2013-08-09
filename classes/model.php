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

class model extends wpsc_merchant{
    
        /**
	 * Array with the PagSeguro status and WP e-Commerce
	 * @var array
	 */
	private static $array_order_status = array(
		0 => 1, // PagSeguro => Pending, WP e-Commerce => Incomplete Sale
		1 => 2, // PagSeguro => Awaiting payment, WP e-Commerce => Order Received
		2 => 2, // PagSeguro => Precessing, WP e-Commerce => Order Received
		3 => 3, // PagSeguro => Paid, WP e-Commerce => Accepted Payment
		4 => '',// PagSeguro => Complete, WP e-Commerce 
		5 => '',// PagSeguro => Dispute, WP e-Commerce 
		6 => '',// PagSeguro => Refunded, WP e-Commerce 
		7 => 6  // PagSeguro => Canceled, WP e-Commerce => Payment Declined
    );
        
        /**
         * Return status order sales WP e-Commerce By status PagSeguro.
         * @param type $status_pagseguro
         * @return integer
         */
        function returnStatusCommerceByPagSeguro( $status_pagseguro ){
            if(  self::$array_order_status[$status_pagseguro] != '' )
                return self::$array_order_status[$status_pagseguro];
            else
                return 0;
        }
}

?>