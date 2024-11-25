<?php
/**
 * Copyright (C) 1997-2020 Reyesoft <info@reyesoft.com>.
 *
 * This file is part of CryptoQr. CryptoQr can not be copied and/or
 * distributed without the express permission of Reyesoft
 */

declare(strict_types=1);

namespace MercadoPagoQr\Resources;

use MercadoPago\Serialization\Mapper;

class Pos
{
    use Mapper;

    public ?int $id;
    public ?string $qr;
    public ?string $status;
    public ?string $date_created;
    public ?string $date_last_updated;
    public ?string $uuid;
    public ?int $user_id;
    public ?string $name;
    public ?bool $fixed_amount;
    public ?int $category;
    public ?int $store_id;
    public ?string $external_store_id;
    public ?string $external_id;
    private array $map = [
        'qr' => 'MercadoPagoQr\\Resources\\Qr',
    ];

    /**
     * Method responsible for getting map of entities.
     */
    public function getMap(): array
    {
        return $this->map;
    }
}
