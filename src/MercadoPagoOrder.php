<?php
/**
 * Copyright (C) 1997-2018 Reyesoft <info@reyesoft.com>.
 *
 * This file is part of CryptoQr. CryptoQr can not be copied and/or
 * distributed without the express permission of Reyesoft
 */

declare(strict_types=1);

namespace MercadoPagoQr;

/**
 * @see https://www.mercadopago.com.ar/developers/en/guides/instore-payments/qr-payments/qr-pos/ "Order object"
 */
class MercadoPagoOrder
{
    use HasMpTrait;

    protected $data;

    /** @var MercadoPagoPos */
    protected $pos;

    public function __construct(MercadoPagoPos $pos, \MP $mp)
    {
        $this->pos = $pos;
        $this->mp = $mp;
    }

    public function sendData(array $data, $collector_id = null)
    {
        if ($collector_id === null) {
            $collector_id = $this->getCollectorIdFromMp();
        }

        return $this->mp->post(
            '/mpmobile/instore/qr/' . $collector_id . '/' . $this->pos->getPosData()->getExternalId(),
            $data
        );
    }
}
