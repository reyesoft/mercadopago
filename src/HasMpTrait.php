<?php
/**
 * Copyright (C) 1997-2018 Reyesoft <info@reyesoft.com>.
 *
 * This file is part of CryptoQr. CryptoQr can not be copied and/or
 * distributed without the express permission of Reyesoft
 */

declare(strict_types=1);

namespace MercadoPagoQr;

use MercadoPago\SDK;

trait HasMpTrait
{
    protected function getCollectorIdFromMp()
    {
        preg_match('/^.*\-([0-9]+)$/', SDK::getAccessToken(), $matches);

        return $matches[1];
    }
}
