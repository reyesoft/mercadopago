<?php

namespace MercadoPagoQr;

use Endroid\QrCode\QrCode;
use MercadoPago\Payment;
use MercadoPago\Preference;
use MercadoPago\SDK;
use MP;

class MercadoPagoQr
{
    /** @var QrCode */
    protected $qr_code;

    /** @var MP */
    protected $mp;

    /** @var array */
    protected $preference;

    /** @var string */
    protected $url;

    protected $collector_id;
    protected $pos_id;

    /**
     * MercadoPagoQr constructor.
     * @param array $preference_data
     * @param $pos_id
     * @throws \MercadoPagoException
     */
    public function __construct(array $preference_data)
    {
        $this->qr_code = new QrCode();
        $this->setSDKAccessToken();
        $this->createMPClient();
        $this->setPreference($preference_data);
        $this->setCollectorId();
        $this->setPosId();
        $this->setUrl('https://mercadopago.com/s/qr/');
    }

    private function setSDKAccessToken(): void
    {
        SDK::setAccessToken("TEST-6533649929268021-092411-ff5874d11f4ab7c9b3f814c1024acc40-180653157");
    }

    /**
     * @throws \MercadoPagoException
     */
    private function createMPClient(): void
    {
        $mp_client = new MP('6533649929268021', 'zKXIDFQNMl9aBppst4J7d3PZIxXWC8bm');
        $this->mp = new MP($mp_client->get_access_token());
    }

    private function setPreference($preference_data): void
    {
        $this->preference = $this->mp->create_preference($preference_data);
    }

    public function setCollectorId()
    {
        $this->collector_id = $this->preference['response']['collector_id'];
    }

    public function setPosId()
    {
        $this->pos_id = rand(1000, 9999);
    }

    public function setUrl(string $url)
    {
        $this->url = $url . $this->getCollectorId() . '/' . $this->getPosId();
        $this->getQrCode()->setText($this->url);
    }

    public function getCollectorId()
    {
        return $this->collector_id;
    }

    public function getPosId()
    {
        return $this->pos_id;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function getQrCode(): QrCode
    {
        return $this->qr_code;
    }
}