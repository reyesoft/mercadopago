# MercadoPagoQr

This library extend API entrypoints of [mercadopago/dx-php](https://github.com/mercadopago/dx-php), like Instore V2, Qr Tramma, and Store Client.

## Installation

```bash
composer require reyesoft/mercadopago
```

## Usage

Usage it's the same of mercadopago/dx-php, but with some new features and extensions. Like...

### Creating and handling a Pos

```php
MercadoPagoConfig::setAccessToken('YOUR_ACCESS_TOKEN']);

$store = (new StoreClient())->create(
    $params->getUserId(),
    [
        'name' => 'Reyesoft Point',
        'business_hours' => [
            'wednesday' => [
                [
                    'open' => '00:00',
                    'close' => '23:59',
                ],
            ],
        ],
        'external_id' => 'your_store_external_id',
        'location' => [
            'street_number' => '3039',
            'street_name' => 'Caseros',
            'city_name' => 'Belgrano',
            'state_name' => 'Capital Federal',
            'latitude' => -32.8897322,
            'longitude' => -68.8443275,
            'reference' => '3er Piso',
        ],
    ]
);
```

You can get MercadoPago credentials from https://www.mercadopago.com/mla/account/credentials

### Showing a Point Of Sale QR

```php
$pos = new MercadoPagoPos('your_pos_external_id');
$qr_content = $pos->getQrContent();

// just an example, this is Endroid\QrCode library
$qr_code = new QrCode($qr_content);
$qr_code->setText($qr_content);
echo $qr_code->getDataUri();
```

### Putting a order in a Point Of Sale

```php
(new InstoreOrderV2())->create(
    'your_mercadopago_user_id',
    'your_store_external_id',
    'your_pos_external_id',
    [
        'external_reference' => '#' . $your_order_id,
        'title' => 'Order ' . $your_order_id, 
        'description' => 'Your proyects',
        'notification_url' => 'https://yourserver.com/endpoint',
        'total_amount' => 100.10,
        'expiration_date' => today()->addDays(7)->format('Y-m-d\TH:i:s.vP'),
        'items' => [
            [
                'title' => 'Your lovely product',
                'id' => '#' . $your_order_id,
                'external_reference' => '#' . $your_order_id,
                'quantity' => 1,
                'unit_measure' => 'unit',
                'currency_id' => 'ARS',
                'unit_price' => 100.10,
                'total_amount' => 100.10,
                'picture_url' => 'https://yourserver.com/image.jpg',
            ],
        ],
    ]
);
```

### Images

```bash
docker run -it --rm --name php82 -e PHP_EXTENSIONS="" -v "$PWD":/usr/src/app pablorsk/laravel-json-api:8.2 bash
```
