	/*
	 * Payscape Direct Post API PHP Class v3.0
	 * 
	 * Edit userid: replace with your User ID from your Payscape account
	 * Edit userpass: replace with your Password from your Payscape account
	 * 
	 * 
	 *  /crt/cacert.pem is included so that you may use cURL.
	 *  Place this folder in your root directory 
	 *
	 * If you prefer, you may also download this file at the cURL website:
	 *  http://curl.haxx.se/ca/cacert.pem 	 
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
	 * See the Payscape Direct Post API PHP Developers Suite for examples of each of the methods.
	 *  
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