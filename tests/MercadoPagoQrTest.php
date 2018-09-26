<?php
/**
 * Created by PhpStorm.
 * User: juan
 * Date: 19/09/18
 * Time: 10:51
 */

namespace MercadoPagoQr\Tests;


use MercadoPago\Payment;
use MercadoPago\SDK;
use MercadoPagoException;
use MP;
use PHPUnit\Framework\TestCase;
use MercadoPagoQr\MercadoPagoQr;

class MercadoPagoQrTest extends TestCase
{
    /**
     * @throws \Exception
     */
    public function testQrCode(): void
    {
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

        $client_id = '3282634683852359';
        $client_secret = 'BAB5nUMycs4Nhpy5itEoGHMNrF2fklUR';

        $filename = __DIR__ . '/image/mercadopago-qr-code.png';

        /** @var MercadoPagoQr $object */
        $qr = new MercadoPagoQr($preference_data, $client_id, $client_secret);

        $qr->getQrCode()->writeFile($filename);

        $image = imagecreatefromstring(file_get_contents($filename));

        $this->assertTrue(is_resource($image));
    }
}
