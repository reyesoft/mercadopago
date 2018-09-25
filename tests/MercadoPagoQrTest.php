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

        $filename = '/home/juan/Imágenes/mercadopago-qr-code.png';

        /** @var MercadoPagoQr $object */
        $qr = new MercadoPagoQr($preference_data);

        $qr->getQrCode()->writeFile($filename);

        $image = imagecreatefromstring(file_get_contents($filename));

        $this->assertTrue(is_resource($image));
    }
}
