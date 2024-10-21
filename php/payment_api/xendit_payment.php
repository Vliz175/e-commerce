<?php
require_once(__DIR__ . '/vendor/autoload.php');

// use Xendit\Xendit
use Xendit\Configuration;
use Xendit\Invoice\InvoiceApi;
use Xendit\Invoice\Invoice;
use Xendit\Invoice\CreateInvoiceRequest;
use Xendit\Payout\PayoutApi;

// Setel kunci API Xendit
Configuration::setXenditKey("xnd_development_x9Un6CNWGongWkuyO498Vm3qsopPHSUledHgY2gqvsrpU0zTCwM2EEhW8mDK");

// Contoh pembuatan Invoice
// $apiInstance = new InvoiceApi();
// $create_invoice_request = new Xendit\Invoice\CreateInvoiceRequest([
//     'external_id' => 'test1234',
//     'description' => 'Test Invoice',
//     'amount' => 10000,
//     'invoice_duration' => 172800,
//     'currency' => 'IDR',
//     'reminder_time' => 1
// ]);

// try {
//     $result = $apiInstance->createInvoice($create_invoice_request);
//     echo $result;
// } catch (\Xendit\XenditSdkException $e) {
//     echo 'Exception when calling InvoiceApi->createInvoice: ', $e->getMessage(), PHP_EOL;
//     echo 'Full Error: ', json_encode($e->getFullError()), PHP_EOL;
// }

$apiInstance = new PayoutApi();
$idempotency_key = "DISB-1234"; // string | A unique key to prevent duplicate requests from pushing through our system. No expiration.
$for_user_id = "5f9a3fbd571a1c4068aa40ce"; // string | The sub-account user-id that you want to make this transaction for. This header is only used if you have access to xenPlatform. See xenPlatform for more information.
$create_payout_request = new Xendit\Payout\CreatePayoutRequest([
    'reference_id' => 'DISB-001',
    'currency' => 'PHP',
    'channel_code' => 'PH_BDO',
    'channel_properties' => [
        'account_holder_name' => 'John Doe',
        'account_number' => '000000'
    ],
    'amount' => 90000,
    'description' => 'Test Bank Payout',
    'type' => 'DIRECT_DISBURSEMENT'
]); // \Xendit\Payout\CreatePayoutRequest

try {
    $result = $apiInstance->createPayout($idempotency_key, $for_user_id, $create_payout_request);
    print_r($result);
} catch (\Xendit\XenditSdkException $e) {
    echo 'Exception when calling PayoutApi->createPayout: ', $e->getMessage(), PHP_EOL;
    echo 'Full Error: ', json_encode($e->getFullError()), PHP_EOL;
}
