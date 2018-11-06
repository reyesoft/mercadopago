<?php
/**
 * Copyright (C) 1997-2018 Reyesoft <info@reyesoft.com>.
 *
 * This file is part of CryptoQr. CryptoQr can not be copied and/or
 * distributed without the express permission of Reyesoft
 */

declare(strict_types=1);

namespace MercadoPagoQr\Tests;

use MercadoPagoQr\MercadoPagoQr;
use PHPUnit\Framework\TestCase;

class MercadoPagoQrTest extends TestCase
{
    /**
     * @throws \Exception
     */
    public function testQrCode(): void
    {
        $preference_data = [
            'items' => [
                [
                    'title' => 'plan_plus',
                    'quantity' => 1,
                    'currency_id' => 'ARS',
                    'unit_price' => 450,
                ],
            ],
        ];

        $client_id = '3282634683852359';
        $client_secret = 'BAB5nUMycs4Nhpy5itEoGHMNrF2fklUR';

        $filename = __DIR__ . '/image/mercadopago-qr-code.png';

        /** @var MercadoPagoQr $object */
        $qr = new MercadoPagoQr($preference_data, $client_id, $client_secret);

        $this->assertStringStartsWith('https://mercadopago.com', $qr->getUrl());

        $qr->getQrCode()->writeFile($filename);

        $image = imagecreatefromstring(file_get_contents($filename));

        $this->assertInternalType('resource', $image);
    }
}
