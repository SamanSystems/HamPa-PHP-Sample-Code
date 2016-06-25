<?php


$MerchantID = 'XXXXXXXX-XXXX-XXXX-XXXX-XXXXXXXXXXXX';

// log GET & SERVER parameters For Test
// file_put_contents('test.txt', 'Server:' . PHP_EOL . print_r($_SERVER, true) . PHP_EOL . ' Get:' . PHP_EOL . print_r($_GET, true), FILE_APPEND);

if (strlen($_GET['Authority']) == 36 && $_GET['Status'] == 'OK') {
    $Amount = $_SERVER['HTTP_X_PAY_AMOUNT'];
    $payerCell = $_SERVER['HTTP_X_PAY_MOBILE'];
    if (!empty($amount) && !empty($payerCell)) {
        // URL also Can be https://de.zarinpal.com/pg/services/WebGate/wsdl
       $client = new SoapClient('https://www.zarinpal.com/pg/services/WebGate/wsdl', ['encoding' => 'UTF-8']); 
		
		$result = $client->PaymentVerification(
						  	[
									'MerchantID'	 => $MerchantID,
									'Authority' 	 => $_GET['Authority'],
									'Amount'	 => $Amount
								]
		);

        if ($result->Status == 100) {
            echo 'Transation success. RefID:'.$result->RefID;
        } else {
            echo 'Transation failed. Status:'.$result->Status;
        }
    }
}

?>
