<?php

/**
 * Copyright (C) 1997-2020 Reyesoft <info@reyesoft.com>.
 *
 * This file is part of CryptoQr. CryptoQr can not be copied and/or
 * distributed without the express permission of Reyesoft
 */

declare(strict_types=1);

namespace Tests;

use MercadoPago\MercadoPagoConfig;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 *
 * @coversNothing
 */
final class MercadoPagoQrTest extends TestCase
{
    public function initializeMercadoPagoSdk(): void
    {
        MercadoPagoConfig::setAccessToken('TEST-1234567890123456-123456-12345678901234567890');
    }
}
