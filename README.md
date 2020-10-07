## FLAMIX.KASSA SDK EXAMPLES

### Check payments
```php

try {
    $kassa = new \Flamix\Kassa\API( 'cashbox_public_id' );
    
    //Check
    if(!$kassa->setSecretKey('cash_box_secretecode_REQUIRED')->setTestSecretKey('cash_box_TEST_secretecode_NOT_required')->isPaymentSuccess($_POST))
        exit();
    
    //If OK, you can use (all variables you can check in vendors/flamix/kassa/Actions/Check.php)
    $kassa->amount;
    $kassa->cashbox_currency;
    $kassa->order_id;
    $kassa->custom_info;
} catch (Exception $e) {
    echo $e->getMessage();
    exit();
}

```

### Work with Cashbox

```php

try {
    $kassa = new \Flamix\Kassa\API( 'cashbox_public_id', 'account_api_key' );
    
    //Manual
    $kassa->exec('getPayments');
    
    //Get all Payments Systems
    $kassa->getCashboxPaymentSystems();
    
    //Get URL to link (default), qr or form
    $kassa->setAmount(11)->setCurrency('USD')->setPaymentType('form')->getPaymentRequest();
} catch (Exception $e) {
    echo $e->getMessage();
}

```

## Reccurent method

```php

try {
    $kassa = new \Flamix\Kassa\API( 'cashbox_public_id', 'account_api_key' );
    
    //Find Reccurent by musk
    $kassa->setCustomInfo('4')->findReccurentPayment();
    
    //Pay by saved card use musk
    $kassa->setCustomInfo('u4')->setAmount(5)->setCurrency('UAH')->doReccurentPayment();
    
    //Pay by saved card use PAY_ID
    $kassa->setPaymentId('0-0-0-0-0-0')->setAmount(5)->setCurrency('UAH')->doReccurentPayment();
    
    //Delete by musk
    $kassa->setCustomInfo('u4')->deleteReccurentPayment()

} catch (Exception $e) {
    echo $e->getMessage();
}

```