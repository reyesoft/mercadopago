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
 * @see https://www.mercadopago.com.ar/developers/en/guides/instore-payments/qr-payments/qr-pos/ "Create QR"
 */
class MercadoPagoPosData
{
    private $name = '';
    private $external_id;
    private $fixed_amount = true;
    private $category = null;   // 621102 gastronomia argentina
    private $store_id = null;

    public function __construct($pos_external_id = '')
    {
        $this->external_id = $pos_external_id;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function setFixedAmount(bool $fixed_amount): self
    {
        $this->fixed_amount = $fixed_amount;

        return $this;
    }

    public function setCategory(?string $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function setStoreId(?int $store_id): self
    {
        $this->store_id = $store_id;

        return $this;
    }

    public function getExternalId(): string
    {
        return $this->external_id;
    }

    public function setExternalId(string $external_id): self
    {
        $this->external_id = $external_id;

        return $this;
    }

    public function getDataArray(): array
    {
        return [
            'name' => $this->name,
            'external_id' => $this->external_id,
            'store_id' => $this->store_id,
            'fixed_amount' => $this->fixed_amount,
            'category' => $this->category,
        ];
    }
}
