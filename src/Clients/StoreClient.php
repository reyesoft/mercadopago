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
use MercadoPagoQr\Resources\Store;

final class StoreClient extends MercadoPagoClient
{
    private const URL_CREATE = '/users/%s/stores';

    public function __construct(?MPHttpClient $MPHttpClient = null)
    {
        parent::__construct($MPHttpClient ?: MercadoPagoConfig::getHttpClient());
    }

    /**
     * @see https://www.mercadopago.com.ar/developers/en/reference/stores/_users_user_id_stores/post
     */
    public function create(int $user_id, array $payload, ?RequestOptions $request_options = null): Store
    {
        $response = parent::send(sprintf(self::URL_CREATE, $user_id), HttpMethod::POST, json_encode($payload), null, $request_options);
        $result = Serializer::deserializeFromJson(Store::class, $response->getContent());
        $result->setResponse($response);

        return $result;
    }
}
