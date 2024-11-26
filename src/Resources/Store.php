<?php

/**
 * Copyright (C) 1997-2020 Reyesoft <info@reyesoft.com>.
 *
 * This file is part of CryptoQr. CryptoQr can not be copied and/or
 * distributed without the express permission of Reyesoft
 */

declare(strict_types=1);

namespace MercadoPagoQr\Resources;

use MercadoPago\Net\MPResource;

class Store extends MPResource
{
    public ?int $id;
    public ?string $name;
    public ?string $date_created;
    public ?array $business_hours;
    public ?array $location;
    public ?string $external_id;
}
