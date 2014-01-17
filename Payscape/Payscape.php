<?php 
	/*
	 * Payscape Gateway API PHP Class v3.0
	 * 
	 * Edit userid: replace with your User ID from your Payscape account
	 * Edit userpass: replace with your Password from your Payscape account
	 * 
	 * 
	 *  /crt/cacert.pem is included so that you may use cURL.
	 *  Place this folder in your root directory 
	 *  	  
	 * 
	 * Sale() detects if your transaction is Credit Card or eCheck and sends the correct params 
	 * 
	 * Payscape Direct Post API PHP Class exposes all of the methods of the Payscape Direct Post API
	 * 
	 * See Payscape Direct Post API Documentation for complete notes on variables:
	 * 
	 * Direct Post API / Documentation / Transaction Variables
	 * http://payscape.com/developers/direct-post-api.php
	 * 
	 * See the Payscape PHP Developers Suite for examples of each of the methods.
	 *  payscape-php-wrappers
	 * 
     ** Features **
     * Sale - credit card transaction
     * Sale - eCheck ACH transaction
     * Validate - credit card validation
     * Update - update Shipping Information for a credit card transaction
     * Auth - authorize a credit card tansaction
     * Capture - capture a previously autorized credit card transaction
     * Refund - refund amounts for credit card transaction
     * Credit - credit a credit card transaction
     * Void - void credit card transaction
 	 * 
	 * 
	 * 1/14/2014
	 * 
	 * */



class Payscape
{
	
	var $url 		= 'https://secure.payscapegateway.com/api/transact.php';
	var $userid 	= 'demo'; 					//Replace with your UserID from Payscape.com
	var $userpass	= 'password';				//Replace with your Password from Payscape.com

	
	/* post to the API */
	
	protected function _send($trans){
		
		require_once('payscape-config.php');

		$trans['username'] = $userid;
		$trans['password'] = $userpass;

			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $this->url);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $trans);
			curl_setopt($ch, CURLOPT_REFERER, "");
			
			/* gateway SSL certificate options for Apache on Windows */
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
			curl_setopt($ch, CURLOPT_CAINFO, getcwd() . "/crt/cacert.pem");
				
			$outcome = curl_exec($ch);
					/* uncommment for testing */
			
				/*	
					if(curl_errno($ch)){
						die('Could not send request: ' .curl_error($ch));
						exit();
					}
				*/	

			curl_close($ch);		
			unset($ch);

			return $outcome;
}// send


	public function Sale($incoming=null){
		
		$time = gmdate('YmdHis');
		$type = 'sale';
		$response = array();
		
		$amount = (isset($incoming['amount']) ? $incoming['amount'] : '');
		$payment = (isset($incoming['payment']) ? $incoming['payment'] : '');
		
		if($payment=='check'){
			$required = array('type', 'checkname', 'checkaba', 'checkaccount', 'account_holder_type', 'account_type', 'amount');		
		} else {
			$required = array('type', 'ccnumber', 'ccexp', 'amount');
		}		
		
		if(count(array_intersect_key(array_flip($required), $incoming)) === count($required)) {		
		$transactiondata = array();
		$transactiondata['type'] = 'sale';
		$transactiondata['amount'] = urlencode($amount);

		
		/* user supplied required data */
		if($payment=='check'){
			$transactiondata['checkname'] = (isset($incoming['checkname']) ? $incoming['checkname'] : '');
			$transactiondata['checkaba'] = (isset($incoming['checkaba']) ? $incoming['checkaba'] : '');
			$transactiondata['checkaccount'] = (isset($incoming['checkaccount']) ? $incoming['checkaccount'] : '');
			$transactiondata['account_holder_type'] = (isset($incoming['account_holder_type']) ? $incoming['account_holder_type'] : '');
			$transactiondata['account_type'] = (isset($incoming['account_type']) ? $incoming['account_type'] : '');
			$transactiondata['payment'] = 'check';
				
		} else {
			$transactiondata['ccexp'] = (isset($incoming['ccexp']) ? $incoming['ccexp'] : '');			
			$transactiondata['ccnumber'] = (isset($incoming['ccnumber']) ? $incoming['ccnumber'] : '');
		}
		
		/* user supplied optional data */
		$transactiondata['cvv'] = (isset($incoming['cvv']) ? $incoming['cvv'] : '');		

		$transactiondata['firstname'] = (isset($incoming['firstname']) ? $incoming['firstname'] : '');
		$transactiondata['lastname'] = (isset($incoming['lastname']) ? $incoming['lastname'] : '');
		$transactiondata['company'] = (isset($incoming['company']) ? $incoming['company'] : '');
		$transactiondata['address1'] = (isset($incoming['address1']) ? $incoming['address1'] : '');
		$transactiondata['city'] = (isset($incoming['city']) ? $incoming['city'] : '');
		$transactiondata['state'] = (isset($incoming['state']) ? $incoming['state'] : '');
		$transactiondata['zip'] = (isset($incoming['zip']) ? $incoming['zip'] : '');
		$transactiondata['country'] = (isset($incoming['country']) ? $incoming['country'] : '');
		$transactiondata['phone'] = (isset($incoming['phone']) ? $incoming['phone'] : '');
		$transactiondata['fax'] = (isset($incoming['fax']) ? $incoming['fax'] : '');
		$transactiondata['email'] = (isset($incoming['email']) ? $incoming['email'] : '');
		$transactiondata['orderid'] = (isset($incoming['orderid']) ? $incoming['orderid'] : '');
	
		return $this->_send($transactiondata);
	
	} else {
		$response['Message'] = 'Required Values Are Missing';
		$response['error'] = 1;
		return $response;
	}
}// end Sale()

public function Validate($incoming=null){


	$time = gmdate('YmdHis');
	$type = 'validate';
	$response = array();


	$payment = (isset($incoming['payment']) ? $incoming['payment'] : '');

	$required = array('type', 'ccnumber', 'ccexp');


	if(count(array_intersect_key(array_flip($required), $incoming)) === count($required)) {
		$transactiondata = array();
		$transactiondata['type'] = $type;


		/* user supplied required data */
		$transactiondata['ccexp'] = (isset($incoming['ccexp']) ? $incoming['ccexp'] : '');
		$transactiondata['ccnumber'] = (isset($incoming['ccnumber']) ? $incoming['ccnumber'] : '');

		/* user supplied optional data */
		$transactiondata['cvv'] = (isset($incoming['cvv']) ? $incoming['cvv'] : '');		

		$transactiondata['firstname'] = (isset($incoming['firstname']) ? $incoming['firstname'] : '');
		$transactiondata['lastname'] = (isset($incoming['lastname']) ? $incoming['lastname'] : '');
		$transactiondata['company'] = (isset($incoming['company']) ? $incoming['company'] : '');
		$transactiondata['address1'] = (isset($incoming['address1']) ? $incoming['address1'] : '');
		$transactiondata['city'] = (isset($incoming['city']) ? $incoming['city'] : '');
		$transactiondata['state'] = (isset($incoming['state']) ? $incoming['state'] : '');
		$transactiondata['zip'] = (isset($incoming['zip']) ? $incoming['zip'] : '');
		$transactiondata['country'] = (isset($incoming['country']) ? $incoming['country'] : '');
		$transactiondata['phone'] = (isset($incoming['phone']) ? $incoming['phone'] : '');
		$transactiondata['fax'] = (isset($incoming['fax']) ? $incoming['fax'] : '');
		$transactiondata['email'] = (isset($incoming['email']) ? $incoming['email'] : '');
		$transactiondata['orderid'] = (isset($incoming['orderid']) ? $incoming['orderid'] : '');

		return $this->_send($transactiondata);

	} else {
		$response['Message'] = 'Required Values Are Missing';
		$response['error'] = 1;
		return $response;
	}
}// Validate()

	
	public function Auth($incoming=null){
		
		$time = gmdate('YmdHis');
		$type = 'auth';
					

		
	
		$required = array('type', 'ccnumber', 'ccexp', 'amount');
	
		
		if(count(array_intersect_key(array_flip($required), $incoming)) === count($required)) {
			
			$payment = (isset($incoming['payment']) ? $incoming['payment'] : '');
			$amount = (isset($incoming['amount']) ? $incoming['amount'] : '');
			$tax = (isset($incoming['tax']) ? $incoming['tax'] : '');
				
			
			$transactiondata = array();
			$transactiondata['type'] = $type;
			$transactiondata['amount'] = $amount;
			$transactiondata['tax'] = $tax;
				
			/* user supplied required data */
				
			$transactiondata['ccexp'] = (isset($incoming['ccexp']) ? $incoming['ccexp'] : '');
			$transactiondata['ccnumber'] = (isset($incoming['ccnumber']) ? $incoming['ccnumber'] : '');
		
			/* user supplied optional data */
			$transactiondata['cvv'] = (isset($incoming['cvv']) ? $incoming['cvv'] : '');
				
			$transactiondata['firstname'] = (isset($incoming['firstname']) ? $incoming['firstname'] : '');
			$transactiondata['lastname'] = (isset($incoming['lastname']) ? $incoming['lastname'] : '');
			$transactiondata['company'] = (isset($incoming['company']) ? $incoming['company'] : '');
			$transactiondata['address1'] = (isset($incoming['address1']) ? $incoming['address1'] : '');
			$transactiondata['city'] = (isset($incoming['city']) ? $incoming['city'] : '');
			$transactiondata['state'] = (isset($incoming['state']) ? $incoming['state'] : '');
			$transactiondata['zip'] = (isset($incoming['zip']) ? $incoming['zip'] : '');
			$transactiondata['country'] = (isset($incoming['country']) ? $incoming['country'] : '');
			$transactiondata['phone'] = (isset($incoming['phone']) ? $incoming['phone'] : '');
			$transactiondata['fax'] = (isset($incoming['fax']) ? $incoming['fax'] : '');
			$transactiondata['email'] = (isset($incoming['email']) ? $incoming['email'] : '');
			$transactiondata['orderid'] = (isset($incoming['orderid']) ? $incoming['orderid'] : '');
			$transactiondata['orderdescription'] = (isset($incoming['orderdescription']) ? $incoming['orderdescription'] : '');
				
			return $this->_send($transactiondata);
		
		} else {

			$response['Message'] = 'One or more Required Values of <strong>type, ccnumber, ccexp or amount</strong> Are Missing';
			$response['error'] = 1;
			return $response;
		}		
		
}// end Auth
	
	public function Credit($incoming=null){
		
		$time = gmdate('YmdHis');
		$type = 'credit';
		$response = array();
		
		$amount = (isset($incoming['amount']) ? $incoming['amount'] : '');
		$payment = (isset($incoming['payment']) ? $incoming['payment'] : '');
		
//		$required = array('type', 'ccnumber', 'ccexp', 'amount');
		$required = array('type', 'transactionid');
	
		if(count(array_intersect_key(array_flip($required), $incoming)) === count($required)) {		
		$transactiondata = array();
		$transactiondata['type'] = 'credit';
		$transactiondata['amount'] = urlencode($amount);

		
		/* user supplied required data */	
		$transactiondata['transactionid'] = (isset($incoming['transactionid']) ? $incoming['transactionid'] : '');
		
		/* user supplied optional data */

		$transactiondata['firstname'] = (isset($incoming['firstname']) ? $incoming['firstname'] : '');
		$transactiondata['lastname'] = (isset($incoming['lastname']) ? $incoming['lastname'] : '');
		$transactiondata['company'] = (isset($incoming['company']) ? $incoming['company'] : '');
		$transactiondata['address1'] = (isset($incoming['address1']) ? $incoming['address1'] : '');
		$transactiondata['city'] = (isset($incoming['city']) ? $incoming['city'] : '');
		$transactiondata['state'] = (isset($incoming['state']) ? $incoming['state'] : '');
		$transactiondata['zip'] = (isset($incoming['zip']) ? $incoming['zip'] : '');
		$transactiondata['country'] = (isset($incoming['country']) ? $incoming['country'] : '');
		$transactiondata['phone'] = (isset($incoming['phone']) ? $incoming['phone'] : '');
		$transactiondata['fax'] = (isset($incoming['fax']) ? $incoming['fax'] : '');
		$transactiondata['email'] = (isset($incoming['email']) ? $incoming['email'] : '');
		$transactiondata['orderid'] = (isset($incoming['orderid']) ? $incoming['orderid'] : '');
	
	/*
		 echo "TRANSACTIONDATA:";
		$this->debug($transactiondata);
		exit();
	*/	
	
		return $this->_send($transactiondata);
	
	} else {
		$response['Message'] = 'Required Values Are Missing';
		$response['error'] = 1;
		return $response;
	}
}// end Credit()

	public function Capture($incoming=null){

		$type = 'capture';
	
	
		$required = array('type', 'transactionid');
	
		if(count(array_intersect_key(array_flip($required), $incoming)) === count($required)) {
			$transactiondata = array();
			$transactiondata['type'] = 'capture';
			$transactiondata['transactionid'] = (isset($incoming['transactionid']) ? $incoming['transactionid'] : '');
				
			return $this->_send($transactiondata);
				
		} else {
			$response['Message'] = 'Required Values <strong>type or transactionid</strong> Are Missing';
			$response['error'] = 1;
			return $response;
		}
	
	}// Capture
	
	

	
	public function Void($incoming=null){
	

		$time = gmdate('YmdHis');
		$type = 'void';
	
	
		$required = array('type', 'transactionid');
	
		if(count(array_intersect_key(array_flip($required), $incoming)) === count($required)) {
			$transactiondata = array();
			$transactiondata['type'] = 'void';
			$transactiondata['transactionid'] = (isset($incoming['transactionid']) ? $incoming['transactionid'] : '');
				
			return $this->_send($transactiondata);
				
		} else {
			$response['Message'] = $response['Message'] = 'Required Values <strong>type or transactionid</strong> Are Missing';
			$response['error'] = 1;
			return $response;
		}
	
	}// Void
	

	
	public function Refund($incoming=null){

		$type = 'refund';
		$required = array('type', 'transactionid');
		
		if(count(array_intersect_key(array_flip($required), $incoming)) === count($required)) {
			$transactiondata = array();
			
			$transactiondata['type'] = 'refund';
			$transactiondata['transactionid'] = (isset($incoming['transactionid']) ? $incoming['transactionid'] : '');				
			
			// Optional, used only if you are making a partial refund.
		if(isset($incoming['amount'])){
			$transactiondata['amount'] = (isset($incoming['amount']) ? $incoming['amount'] : '');
		}	

				
			return $this->_send($transactiondata);
		
		} else {
			$response['Message'] = 'Required Values <strong>type or transactionid</strong> Are Missing';
			$response['error'] = 1;
			return $response;
		}
	}// Refund
	
	
	public function Update($incoming=null){
		
		$required = array('type', 'transactionid');
		
		if(count(array_intersect_key(array_flip($required), $incoming)) === count($required)) {
			$transactiondata = array();
			
			$transactiondata['type'] = 'update';		
			$transactiondata['transactionid'] = (isset($incoming['transactionid']) ? $incoming['transactionid'] : '');
			
			/* optional fields */
			$transactiondata['tracking_number'] = (isset($incoming['tracking_number']) ? $incoming['tracking_number'] : '');				
			$transactiondata['shipping_carrier'] = (isset($incoming['shipping_carrier']) ? $incoming['shipping_carrier'] : '');
			$transactiondata['orderid'] = (isset($incoming['orderid']) ? $incoming['orderid'] : '');
		
			return $this->_send($transactiondata);		
		}  else {
			$response['Message'] = 'Required Values <strong>type or transactionid</strong> Are Missing';
			$response['error'] = 1;
			return $response;
		}
	
	}// Update
	
	public function debug($data)
	{
		echo "<pre>";
		print_r($data);
		echo "</pre>";
	}
	
	
}// end Payscape
?>