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

    /**
     * @param array<mixed> $value
     */
    public function setItems(array $value): void
    {
        $this->order->items = $value;
    }

    /**
     * @return array<mixed>
     */
    public function getResponse(): array
    {
        return $this->order->getAttributes();
    }

    /**
     * @param array<string,mixed> $data
     * @param null $collector_id
     *
     * @throws \Exception
     *
     * @return array<mixed>
     */
    public function sendData(array $data, $collector_id = null): array
    {
        if (isset($data['external_reference'])) {
            $this->setExternalReference($data['external_reference']);
        }
        if (isset($data['notification_url'])) {
            $this->setNotificationUrl($data['notification_url']);
        }
        if (isset($data['items'])) {
            $this->setItems($data['items']);
        }

        $this->order->external_id = $this->pos->getPosData()->getExternalId();

        $this->order->save();

        return $this->getResponse();
    }
}
