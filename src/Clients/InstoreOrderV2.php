<?php
/**
 * Copyright (C) 1997-2020 Reyesoft <info@reyesoft.com>.
 *
 * This file is part of CryptoQr. CryptoQr can not be copied and/or
 * distributed without the express permission of Reyesoft
 */

declare(strict_types=1);

namespace MercadoPagoQr\Clients;

use MercadoPago\Client\Common\RequestOptions;
use MercadoPago\Client\MercadoPagoClient;
use MercadoPago\MercadoPagoConfig;
use MercadoPago\Net\HttpMethod;
use MercadoPago\Net\MPHttpClient;
use MercadoPago\Net\MPResponse;
use MercadoPago\Serialization\Serializer;
use MercadoPagoQr\Resources\Pos;

final class InstoreOrderV2 extends MercadoPagoClient
{
    private const URL = '/pos';
    private const URL_CREATE = '/instore/qr/seller/collectors/%s/stores/%s/pos/%s/orders';

    public function __construct(?MPHttpClient $MPHttpClient = null)
    {
        parent::__construct($MPHttpClient ?: MercadoPagoConfig::getHttpClient());
    }

    /**
     * @see https://www.mercadopago.com.ar/developers/en/reference/instore_orders_v2/_instore_qr_seller_collectors_user_id_stores_external_store_id_pos_external_pos_id_orders/put
     */
    public function create(int $user_id, string $external_store_id, string $external_pos_id, array $payload, ?RequestOptions $request_options = null): MPResponse
    {
        // no response
        return parent::send(sprintf(self::URL_CREATE, $user_id, $external_store_id, $external_pos_id), HttpMethod::PUT, json_encode($payload), null, $request_options);
    }
}
