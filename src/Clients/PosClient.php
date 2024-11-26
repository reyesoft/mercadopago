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
use MercadoPago\Exceptions\MPApiException;
use MercadoPago\MercadoPagoConfig;
use MercadoPago\Net\HttpMethod;
use MercadoPago\Net\MPHttpClient;
use MercadoPago\Serialization\Serializer;
use MercadoPagoQr\Resources\Pos;

final class PosClient extends MercadoPagoClient
{
    private const URL = '/pos';

    public function __construct(?MPHttpClient $MPHttpClient = null)
    {
        parent::__construct($MPHttpClient ?: MercadoPagoConfig::getHttpClient());
    }

    /**
     * Method responsible for creating card token.
     *
     * @param array $request card token data
     *
     * @throws MPApiException if the request fails
     * @throws \Exception if the request fails
     *
     * @return Pos card token created
     */
    public function create(array $request, ?RequestOptions $request_options = null): Pos
    {
        $response = parent::send(self::URL, HttpMethod::POST, json_encode($request), null, $request_options);
        $result = Serializer::deserializeFromJson(Pos::class, $response->getContent());
        $result->setResponse($response);

        // @phpstan-ignore-next-line
        return $result;
    }
}
