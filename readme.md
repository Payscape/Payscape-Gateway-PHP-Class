
#Payscape Gateway PHP Class v3.0
Rapid eCommerce web development with PHP and the Payscape Gateway PHP Class


## Requirements
* PHP 4, 5
* cURL
* Database server in one of these flavors 
*mySQL, 
PostgreSQL, 
Microsoft SQL Server or 
SQLite* 

##Installation

##Setup
* Edit userid: replace with your User ID from your Payscape account
* Edit userpass: replace with your Password from your Payscape account
	  

##cURL info	  
* /crt/cacert.pem is included so that you may use cURL.
* Place this folder in your root directory 
* If you prefer, you may also download this file at the cURL website http://curl.haxx.se/ca/cacert.pem 	 
	   	  
##Version 3.0 notes	  
* Sale() detects if your transaction is Credit Card or eCheck and sends the correct params 
* Payscape Gateway PHP Class exposes all of the methods of the Payscape Direct Post API
* See Payscape Direct Post API Documentation for complete notes on variables at http://payscape.com/developers/direct-post-api.php *Direct Post API / Documentation / Transaction Variables*
* See the Payscape Direct Post API PHP Developers Suite for working examples of each of the Payscape Gateway transactions.
	   
	  
##Features 
* Sale - credit card transaction
* Sale - eCheck ACH transaction
* Validate - credit card validation
* Update - update Shipping Information for a credit card transaction
* Auth - authorize a credit card tansaction
* Capture - capture a previously autorized credit card transaction
* Refund - refund amounts for credit card transaction
* Credit - credit a credit card transaction
* Void - void credit card transaction
 	  
## Documentation

### Example Sale Credit Card transaction
```
require_once 'classes/Payscape/Payscape.php';

$incoming = array();
/* required fields*/
$incoming['amount'] = 'amount';
$incoming['ccexp'] = 'ccexp';
$incoming['ccnumber'] = 'ccnumber';

/* optional fields*/
$incoming['cvv'] = $_POST['cvv'];					
$incoming['orderdescription'] = $_POST['orderdescription'];
$incoming['orderid'] = $_POST['orderid'];

$incoming['firstname'] = $_POST['firstname'];
$incoming['lastname'] = $_POST['lastname'];
$incoming['company'] = $_POST['company'];
$incoming['address1'] = $_POST['address1'];
$incoming['city'] = $_POST['city'];
$incoming['state'] = $_POST['state'];
$incoming['zip'] = $_POST['zip'];
$incoming['country'] = $_POST['country'];
$incoming['phone'] = $_POST['phone'];
$incoming['fax'] = $_POST['fax'];
$incoming['email'] = $_POST['email'];

$Payscape = NEW Payscape();
$result_array = $Payscape->Sale($incoming);	
	

```

### Example Response: Sale Credit Card Success
```
 Array
(
    [response] => 1
    [responsetext] => SUCCESS
    [authcode] => 123456
    [transactionid] => 2114572847
    [avsresponse] => 
    [cvvresponse] => 
    [orderid] => 
    [type] => sale
    [response_code] => 100
    [merchant_defined_field_6] => 
    [merchant_defined_field_7] => 
    [customer_vault_id] => 
)
```	  
### Example Sale eCheck ACH transaction
```
require_once 'classes/Payscape/Payscape.php';

$incoming = array();
$incoming['amount'] = 'amount';
$incoming['type'] = 'sale';
$incoming['payment'] = 'check';
				
$incoming['checkname'] = 'checkname';						
$incoming['checkaba'] = 'checkaba';
$incoming['checkaccount'] = 'checkaccount';
$incoming['account_holder_type'] = 'account_holder_type';
$incoming['account_type'] = 'account_type';
$incoming['sec_code'] = 'WEB';

// optional fields
$incoming['orderid'] = 'orderid';
$incoming['orderdescription'] = 'orderdescription';
			
$incoming['firstname'] = $_POST['firstname'];
$incoming['lastname'] = $_POST['lastname'];
$incoming['company'] = $_POST['company'];
$incoming['address1'] = $_POST['address1'];
$incoming['city'] = $_POST['city'];
$incoming['state'] = $_POST['state'];
$incoming['zip'] = $_POST['zip'];
$incoming['country'] = $_POST['country'];
$incoming['phone'] = $_POST['phone'];
$incoming['fax'] = $_POST['fax'];
$incoming['email'] = $_POST['email'];
		
$Payscape = NEW Payscape();
$result_array = $Payscape->Sale($incoming);	
		
```
### Example Response: Sale eCheck ACH Success
```
 Array
(
    [response] => 1
    [responsetext] => SUCCESS
    [authcode] => 123456
    [transactionid] => 2114572847
    [avsresponse] => 
    [cvvresponse] => 
    [orderid] => 
    [type] => sale
    [response_code] => 100
    [merchant_defined_field_6] => 
    [merchant_defined_field_7] => 
    [customer_vault_id] => 
)
```
### Example Auth transaction
```
require_once 'classes/Payscape/Payscape.php';

$incoming = array();
/* required fields */
$incoming['type'] = 'auth';
$incoming['amount'] =  $_POST['amount'];
$incoming['ccexp'] = $_POST['ccexp'];
$incoming['ccnumber'] = $_POST['ccnumber'];

/* optional fields */
$incoming['payment'] = 'creditcard';
$incoming['cvv'] = 'credit card cvv';
$incoming['orderdescription'] =  $_POST['orderdescription'];
$incoming['orderid'] = $_POST['orderid'];


$incoming['firstname'] = $_POST['firstname'];
$incoming['lastname'] = $_POST['lastname'];
$incoming['company'] = $_POST['company'];
$incoming['address1'] = $_POST['address1'];
$incoming['city'] = $_POST['city'];
$incoming['state'] = $_POST['state'];
$incoming['zip'] = $_POST['zip'];
$incoming['country'] = $_POST['country'];
$incoming['phone'] = $_POST['phone'];
$incoming['fax'] = $_POST['fax'];
$incoming['email'] = $_POST['email'];
		
		
$Payscape = NEW Payscape();
$result_array = $Payscape->Auth($incoming);	

```
### Example Response: Auth Success

```
Array
(
    [response] => 1
    [responsetext] => SUCCESS
    [authcode] => 123456			// returned by the API when Auth Transaction is successful	
    [transactionid] => 2114304708	// returned by the API when Auth Transaction is successful
    [avsresponse] => N
    [cvvresponse] => N
    [orderid] => 20140103081036TestAuthCC
    [type] => auth
    [response_code] => 100
    [merchant_defined_field_6] => 
    [merchant_defined_field_7] => 
    [customer_vault_id] => 
)
```
### Example Capture 
```
require_once 'classes/Payscape/Payscape.php';

$incoming = array();
$incoming['type'] = 'capture';
$incoming['transactionid'] = 'transaction id of the auth transaction';
$incoming['amount'] = '100.00'; // may not exceed Authorized amount

$Payscape = NEW Payscape();
$result_array = $Payscape->Capture($incoming);	

```
### Example Response Capture Success 
```
Array
(
    [response] => 1
    [responsetext] => SUCCESS
    [authcode] => 123456
    [transactionid] => 2114503473
    [avsresponse] => 
    [cvvresponse] => 
    [orderid] => 20140103112556TestAuthCC
    [type] => capture
    [response_code] => 100
    [merchant_defined_field_6] => 
    [merchant_defined_field_7] => 
    [customer_vault_id] => 
)
```

### Example Credit transaction
```
$time = gmdate('YmdHis');

require_once 'classes/Payscape/Payscape.php';

$incoming = array();
$incoming['type'] = 'credit;
$incoming['transactionid'] = 'sale transaction id';
$incoming['amount'] = 'sale amount';
$incoming['orderid'] = 'sale transactionid';
		
$incoming['time'] = $time;	
	
/* optional fields */		
$incoming['firstname'] = $transaction['transactions']['firstname'];
$incoming['lastname'] = $transaction['transactions']['lastname'];
$incoming['company'] = $transaction['transactions']['company'];
$incoming['address1'] = $transaction['transactions']['address1'];
$incoming['city'] = $transaction['transactions']['city'];
$incoming['state'] = $transaction['transactions']['state'];
$incoming['zip'] = $transaction['transactions']['zip'];
$incoming['country'] = $transaction['transactions']['country'];
$incoming['phone'] = $transaction['transactions']['phone'];
$incoming['fax'] = $transaction['transactions']['fax'];
$incoming['email'] = $transaction['transactions']['email'];

$Payscape = NEW Payscape();
$result_array = $Payscape->Credit($incoming);	

```
### Example Response Credit Success
```
Array
(
    [response] => 1
    [responsetext] => SUCCESS
    [authcode] => 123456
    [transactionid] => 2114517479
    [avsresponse] => N
    [cvvresponse] => N
    [orderid] => 20140103113440Test
    [type] => sale
    [response_code] => 100
    [merchant_defined_field_6] => 
    [merchant_defined_field_7] => 
    [customer_vault_id] => 
)
```
### Example Validation transaction
```
require_once 'classes/Payscape/Payscape.php';

$incoming = array();
$incoming['type'] = 'validate';
$incoming['ccexp'] = 'credit card expiration date';
$incoming['ccnumber'] = 'credit card number';

// optional fields
$incoming['cvv'] = 'credit card cvv';
		
$incoming['firstname'] = $_POST['firstname'];
$incoming['lastname'] = $_POST['lastname'];
$incoming['company'] = $_POST['company'];
$incoming['address1'] = $_POST['address1'];
$incoming['city'] = $_POST['city'];
$incoming['state'] = $_POST['state'];
$incoming['zip'] = $_POST['zip'];
$incoming['country'] = $_POST['country'];
$incoming['phone'] = $_POST['phone'];
$incoming['fax'] = $_POST['fax'];
$incoming['email'] = $_POST['email'];

$Payscape = NEW Payscape();
$result_array = $Payscape->ValidateCreditCard($incoming);	

```
### Example Response Validate Success
```
Array
(
    [response] => 1
    [responsetext] => SUCCESS
    [authcode] => 123456
    [transactionid] => 2117482337
    [avsresponse] => N
    [cvvresponse] => N
    [orderid] => 20140106083022Test
    [type] => sale
    [response_code] => 100
    [merchant_defined_field_6] => 
    [merchant_defined_field_7] => 
    [customer_vault_id] => 
)
```
### Example Refund transaction
```
require_once 'classes/Payscape/Payscape.php';

$incoming = array();
$incoming['type'] = 'refund';
$incoming['transactionid'] = 'sale transaction id';
$incoming['amount'] = 'required only if refund is less than the origianl sale transaction amount';

$Payscape = NEW Payscape();
$result_array = $Payscape->Refund($incoming);

```
### Example Response Refund Success
```
Array
(
    [response] => 1
    [responsetext] => SUCCESS
    [authcode] => 
    [transactionid] => 2114491871
    [avsresponse] => 
    [cvvresponse] => 
    [orderid] => 20131230143848Test
    [type] => refund
    [response_code] => 100
    [merchant_defined_field_6] => 
    [merchant_defined_field_7] => 
    [customer_vault_id] => 
)
```
### Example Update transaction
```
require_once 'classes/Payscape/Payscape.php';

incoming = array();
$incoming['type'] = 'refund;
$incoming['transactionid'] = 'sale transaction id';
$incoming['shipping_carrier'] = 'shipping_carrier';
$incoming['tracking_number'] = 'shipping carrier tracking_number';
		
$Payscape = NEW Payscape();
$result_array = $Payscape->Refund($incoming);

```
### Example Response Update Success
```
Array
(
    [response] => 1
    [responsetext] => 
    [authcode] => 123456
    [transactionid] => 2114757737
    [avsresponse] => 
    [cvvresponse] => 
    [orderid] => 20140103151413Test
    [type] => update
    [response_code] => 100
    [merchant_defined_field_6] => 
    [merchant_defined_field_7] => 
    [customer_vault_id] => 
)
```
### Example Void transaction
```
require_once 'classes/Payscape/Payscape.php';

$incoming = array();
$incoming['type'] = $'void';
$incoming['transactionid'] = 'sale transaction id';
$incoming['amount'] = 'sale amount';

$Payscape = NEW Payscape();
$result_array = $Payscape->Void($incoming);
```
### Example Response Void Success
```
Array
(
    [response] => 1
    [responsetext] => Transaction Void Successful
    [authcode] => 123456
    [transactionid] => 2110075690
    [avsresponse] => 
    [cvvresponse] => 
    [orderid] => 20131230143602Test
    [type] => void
    [response_code] => 100
    [merchant_defined_field_6] => 
    [merchant_defined_field_7] => 
    [customer_vault_id] => 
)
``` 	  
	  
1/14/2014
