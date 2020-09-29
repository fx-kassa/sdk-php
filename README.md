## FLAMIX.KASSA SDK EXAMPLES

```php

try {
    $kassa = new \Flamix\Kassa\API( 'id', 'key' );
    
    //Manual
    $kassa->exec('getPayments');
    
    //Get all Payments Systems
    $kassa->getCashboxPaymentSystems();
    
    //Get URL to link, qr or form
    $kassa->setAmount(11)->setCurrency('USD')->setPaymentType(11)->getPaymentRequest();
} catch (Exception $e) {
  echo $e->getMessage();
}

```

## Reccurent method

```php

try {
    $kassa = new \Flamix\Kassa\API( 'id', 'key' );
    
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