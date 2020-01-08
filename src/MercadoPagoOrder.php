<?php
/**
 * Copyright (C) 1997-2020 Reyesoft <info@reyesoft.com>.
 *
 * This file is part of CryptoQr. CryptoQr can not be copied and/or
 * distributed without the express permission of Reyesoft
 */

declare(strict_types=1);

namespace MercadoPagoQr;

use MercadoPago\InstoreOrder;

/**
 * @see https://www.mercadopago.com.ar/developers/en/guides/instore-payments/qr-payments/qr-pos/ "Order object"
 */
class MercadoPagoOrder
{
    use HasMpTrait;

    protected $data;

    /** @var MercadoPagoPos */
    protected $pos;

    /** @var InstoreOrder */
    protected $order;

    public function __construct(MercadoPagoPos $pos)
    {
        $this->pos = $pos;
        $this->order = new InstoreOrder();
    }

    public function setExternalReference(string $value): void
    {
        $this->order->external_reference = $value;
    }

    public function setNotificationUrl(string $value): void
    {
        $this->order->notification_url = $value;
    }

    public function setItems(array $value): void
    {
        $this->order->items = $value;
    }

    public function getResponse()
    {
        return $this->order->getAttributes();
    }

    public function sendData(array $data, $collector_id = null)
    {
        if ($data['external_reference']) {
            $this->setExternalReference($data['external_reference']);
        }
        if ($data['notification_url']) {
            $this->setNotificationUrl($data['notification_url']);
        }
        if ($data['items']) {
            $this->setItems($data['items']);
        }

        $this->order->external_id = $this->pos->getPosData()->getExternalId();

        $this->order->save();

        return $this->getResponse();
    }
}
