<?php

/**
 * Copyright (C) 1997-2020 Reyesoft <info@reyesoft.com>.
 *
 * This file is part of CryptoQr. CryptoQr can not be copied and/or
 * distributed without the express permission of Reyesoft
 */

declare(strict_types=1);

namespace MercadoPagoQr;

use MercadoPago\Exceptions\MPApiException;
use MercadoPagoQr\Clients\PosClient;
use MercadoPagoQr\Resources\Pos;
use MercadoPagoQr\Support\HasMpTrait;

/**
 * @see https://www.mercadopago.com.ar/developers/en/guides/instore-payments/qr-payments/qr-pos/ "Create QR"
 */
class MercadoPagoPos
{
    use HasMpTrait;

    public function __construct(private readonly string $pos_external_id) {}

    /**
     * @throws MPApiException
     *
     * @see https://www.mercadopago.com.ar/developers/en/reference/pos/_pos/post
     */
    public static function createOrFail(
        string $name,
        string $external_id,
        bool $fixed_amount = true,
        ?string $category = null, // 621102 gastronomia argentina
        ?int $store_id = null
    ): Pos {
        // https://www.mercadopago.com.ar/developers/en/reference/pos/_pos/post
        return (new PosClient())->create(array_filter([
            'name' => $name,
            'external_id' => $external_id,
            'store_id' => $store_id,
            'fixed_amount' => $fixed_amount,
            'category' => $category,
        ]));
    }

    public function getQrContent(?string $collector_id = null): string
    {
        if ($collector_id === null) {
            $collector_id = $this->getCollectorIdFromMp();
        }

        return 'https://mercadopago.com/s/qr/' . $collector_id . '/' . $this->pos_external_id;
    }
}
