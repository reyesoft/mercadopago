# MercadoPagoQr

This library helps you generate a QR code to make payments through Mercadopago, even with QR code. Makes use of [endroid/qr-code]
(https://github.com/endroid/qr-code) and [mercadopago/dx-php](https://github.com/mercadopago/dx-php)

## Installation

```bash
composer require reyesoft/mercadopago
```

## Usage

### Creating a Pos

```php
$mp = new \MP('client_id', 'client_secret');
// $mp = new \MP('your_access_token');

$pos = new MercadoPagoPos($mp, 'MyTestPos');
$filename = __DIR__ . '/image/mercadopago-qr-code.png';
$pos->getQrCode()->writeFile($filename);
```

You can get MercadoPago credentials from https://www.mercadopago.com/mla/account/credentials

### Filling the Pos with a Order

```php
$order_data = [
    'external_reference' => 'id_interno',
    'notification_url' => 'www.yourserver.com/endpoint',
    'items' => [
        [
            'title' => 'api_smsc_com_ar',
            'quantity' => 1,
            'currency_id' => 'ARS',
            'unit_price' => 450,
        ],
    ],
];

$order = $pos->createAnOrder();
$result = $order->sendData($order_data);
```

### Images

```bash
docker run -it --rm --name php82 -e PHP_EXTENSIONS="" -v "$PWD":/usr/src/app pablorsk/laravel-json-api:8.2 bash
```
