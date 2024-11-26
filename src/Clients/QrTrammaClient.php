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
use MercadoPago\Serialization\Serializer;
use MercadoPagoQr\Resources\Pos;
use MercadoPagoQr\Resources\QrTramma;

final class QrTrammaClient extends MercadoPagoClient
{
    private const URL_CREATE = '/instore/orders/qr/seller/collectors/%s/pos/%s/qrs';

    public function __construct(?MPHttpClient $MPHttpClient = null)
    {
        parent::__construct($MPHttpClient ?: MercadoPagoConfig::getHttpClient());
    }

    /**
     * @see https://www.mercadopago.com.ar/developers/en/reference/qr-dynamic/_instore_orders_qr_seller_collectors_user_id_pos_external_pos_id_qrs/post
     */
    public function create(int $user_id, string $external_pos_id, array $payload, ?RequestOptions $request_options = null): QrTramma
    {
        $response = parent::send(sprintf(self::URL_CREATE, $user_id, $external_pos_id), HttpMethod::POST, json_encode($payload), null, $request_options);
        $result = Serializer::deserializeFromJson(QrTramma::class, $response->getContent());
        $result->setResponse($response);

        return $result;
    }
}
