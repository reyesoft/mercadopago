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
     * @param $client_id
     * @param $client_secret
     * @throws \MercadoPagoException
     */
    public function __construct(array $preference_data, $client_id, $client_secret)
    {
        $this->qr_code = new QrCode();
        $this->createMPClient($client_id, $client_secret);
        $this->setPreference($preference_data);
        $this->setCollectorId();
        $this->setPosId();
        $this->setUrl('https://mercadopago.com/s/qr/');
    }

    /**
     * @param $client_id
     * @param $client_secret
     * @throws \MercadoPagoException
     */
    private function createMPClient($client_id, $client_secret): void
    {
        $this->mp = new MP($client_id, $client_secret);
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