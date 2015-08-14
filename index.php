<?php
@session_start();

require_once('secrets.php');
/******** Taxamo configuration **********/
require_once('taxamo/lib/Taxamo.php');

function getAmount($price)
{
$taxamo = new Taxamo(new APIClient($privTocken, 'https://api.taxamo.com'));

$transaction_line2 = new Input_transaction_line();
$transaction_line2->amount = $price;
$transaction_line2->custom_id = 'line2';
$transaction_line2->product_type = 'e-service';

$transaction = new Input_transaction();
$transaction->currency_code = 'GBP';
// whose currency code ? our or the customers ?
 //propagate customer's IP address when calling API server-side
$transaction->buyer_ip = "92.234.73.59";
$transaction->buyer_credit_card_prefix = "454638489";
// echo '>>>>>>>>'.$_SERVER['REMOTE_ADDR'];
$transaction->billing_country_code = 'GB';
$transaction->force_country_code = 'GB';
$transaction->transaction_lines = array($transaction_line2);
$resp = $taxamo->calculateTax(array('transaction' => $transaction));
$_SESSION['billing_country_code'] = $resp->transaction->billing_country_code;
print_r($resp->transaction);
return $resp->transaction;
}
echo getAmount(100);
exit;

?>
