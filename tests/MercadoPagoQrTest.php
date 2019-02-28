<?php
/**
 * Copyright (C) 1997-2018 Reyesoft <info@reyesoft.com>.
 *
 * This file is part of CryptoQr. CryptoQr can not be copied and/or
 * distributed without the express permission of Reyesoft
 */

declare(strict_types=1);

namespace MercadoPagoQr\Tests;

use MercadoPagoQr\MercadoPagoPos;
use MercadoPagoQr\MercadoPagoQr;
use PHPUnit\Framework\TestCase;

class MercadoPagoQrTest extends TestCase
{
    public static $mp = null;
    public static $location_mp = null;

    public static function getMp(): \MP
    {
        $GLOBALS['LIB_LOCATION'] = self::$location_mp;  // fix problem on library
        if (self::$mp === null) {
            self::$mp = new \MP('3282634683852359', 'BAB5nUMycs4Nhpy5itEoGHMNrF2fklUR');
            // self::$mp = new \MP('your_access_token');
            self::$location_mp = $GLOBALS['LIB_LOCATION'];
        }

        return self::$mp;
    }

    public function testCreateAPosQr(): string
    {
        $pos = new MercadoPagoPos(self::getMp());

        $pos->getPosData()
            ->setExternalId('MyTestPos' . random_int(1, 1000) . time())
            ->setName('My MercadoPago POS of testing');

        $created = $pos->createOrFail();

        $this->assertTrue($created);

        return $pos->getPosData()->getExternalId();
    }

    /**
     * @depends testCreateAPosQr
     */
    public function testTryToCreateARepeatedPosQr(string $pos_id): void
    {
        $pos = new MercadoPagoPos(self::getMp(), $pos_id);

        $this->expectExceptionMessage('Point of sale with corresponding user and id exists');
        $pos->createOrFail();
    }

    public function testCreateTestPos(): void
    {
        $pos = new MercadoPagoPos(self::getMp(), 'MyTestPos');

        $pos->getPosData()
            ->setName('My MercadoPago POS of testing');

        $pos->checkOrCreate();

        $this->assertTrue(true);
    }

    /**
     * @depends testCreateTestPos
     */
    public function testCreateQr(): void
    {
        $pos = new MercadoPagoPos(self::getMp(), 'MyTestPos');
        $filename = __DIR__ . '/image/mercadopago-qr-code.png';
        $pos->getQrCode()->writeFile($filename);

        $image = imagecreatefromstring(file_get_contents($filename));

        $this->assertInternalType('resource', $image);
    }

    /**
     * @depends testCreateTestPos
     */
    public function testCreateAnOrderForTestPos(): void
    {
        $pos = new MercadoPagoPos(self::getMp(), 'MyTestPos');

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

        $this->assertSame($result['response']['total_amount'], 450);
    }
}
