# MercadoPagoQr

*By [Reyesoft](http://reyesoft.com/)*

This library helps you generate a QR code to make payments through Mercadopago. Makes use of [endroid/qr-code]
(https://github.com/endroid/qr-code) and [mercadopago/dx-php](https://github.com/mercadopago/dx-php)

## Usage

Create a new object with MercadoPagoQr class with the preference_data (payment preference), client_id and client_secret,
arguments, which you can get them in: https://www.mercadopago.com/mla/account/credentials

```<?php
$preference_data = array(
   'items' => array(
       array(
           'title' => 'plan_plus',
           'quantity' => 1,
           'currency_id' => 'ARS',
           'unit_price' => 450
       )
   )
);

$client_id = 'YOUR_CLIENT_ID';
$client_secret = 'YOUR_CLIENT_SECRET';

$filename = __DIR__ . '/image/mercadopago-qr-code.png';

$qr = new MercadoPagoQr($preference_data, $client_id, $client_secret);

$qr->getQrCode()->writeFile($filename);

print_r($qr->getQrCode()->getText());
```

This generates a qr code like that:

![mercadopago-qr](https://github.com/reyesoft/mercadopago/blob/master/tests/image/mercadopago-qr-code.png?raw=true "Mercadopago QR generated with MercadoPagoQr library")




