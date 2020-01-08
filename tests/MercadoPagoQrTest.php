<?php
/**
 * Copyright (C) 1997-2020 Reyesoft <info@reyesoft.com>.
 *
 * This file is part of CryptoQr. CryptoQr can not be copied and/or
 * distributed without the express permission of Reyesoft
 */

declare(strict_types=1);

namespace MercadoPagoQr\Tests;

use MercadoPago\SDK;
use MercadoPagoQr\MercadoPagoPos;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 * @coversNothing
 */
final class MercadoPagoQrTest extends TestCase
{
    // public static $location_mp = null;

    public function initializeMercadoPagoSdk(): void
    {
        //        $GLOBALS['LIB_LOCATION'] = self::$location_mp;  // fix problem on library
        //        if (self::$mp === null) {
        //            // self::$mp = new \MP('3282634683852359', $client_secret);
        //            // self::$mp = new \MP('your_access_token');
        //            self::$location_mp = $GLOBALS['LIB_LOCATION'];
        //
        //        }
        SDK::setClientId('3282634683852359');
        SDK::setClientSecret('BAB5nUMycs4Nhpy5itEoGHMNrF2fklUR');
    }

    public function testCreateAPosQr(): string
    {
        $this->initializeMercadoPagoSdk();

        $pos = new MercadoPagoPos();

        $pos->getPosData()
            ->setExternalId('MyTestPos' . random_int(1, 1000) . time())
            ->setName('My MercadoPago POS of testing')
            ->setFixedAmount(false)
            ->setCategory(null)
            ->setStoreId(null);

        $created = $pos->createOrFail();

        static::assertTrue($created);

        return $pos->getPosData()->getExternalId();
    }

    /**
     * @depends testCreateAPosQr
     */
    public function testTryToCreateARepeatedPosQr(string $pos_id): void
    {
        $this->initializeMercadoPagoSdk();

        $pos = new MercadoPagoPos();
        $pos->getPosData()->setExternalId($pos_id);

        $this->expectExceptionMessage('Point of sale with corresponding user and id exists');
        $pos->createOrFail();
        echo 'zzzz';
    }

    public function testCreateTestPos(): void
    {
        $this->initializeMercadoPagoSdk();

        $pos = new MercadoPagoPos('MyTestPos');

        $pos->getPosData()
            ->setName('My MercadoPago POS of testing');

        $result = $pos->checkOrCreate();

        static::assertTrue($result);
    }

    /**
     * @depends testCreateTestPos
     */
    public function testCreateQr(): void
    {
        $this->initializeMercadoPagoSdk();

        $pos = new MercadoPagoPos('MyTestPos');
        $filename = __DIR__ . '/image/mercadopago-qr-code.png';
        $pos->getQrCode()->writeFile($filename);

        $file_content = file_get_contents($filename);
        static::assertNotFalse($file_content);

        $image = imagecreatefromstring($file_content);

        static::assertInternalType('resource', $image);
    }

    /**
     * @depends testCreateTestPos
     */
    public function testCreateAnOrderForTestPos(): void
    {
        $this->initializeMercadoPagoSdk();

        $pos = new MercadoPagoPos('MyTestPos');

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

        static::assertSame($order->getResponse()['total_amount'], 450);
    }
}
