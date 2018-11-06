<?php
/**
 * Copyright (C) 1997-2018 Reyesoft <info@reyesoft.com>.
 *
 * This file is part of CryptoQr. CryptoQr can not be copied and/or
 * distributed without the express permission of Reyesoft
 */

declare(strict_types=1);

namespace MercadoPagoQr;

use Endroid\QrCode\QrCode;
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
     *
     * @param array $preference_data
     * @param string $client_id
     * @param string $client_secret
     *
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
     * @param string $client_id
     * @param string $client_secret
     *
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

    public function setCollectorId(): void
    {
        $this->collector_id = $this->preference['response']['collector_id'];
    }

    public function setPosId(): void
    {
        /** @todo search pos_id */
        $this->pos_id = random_int(1000, 9999);
    }

    public function setUrl(string $url): void
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
