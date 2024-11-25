<?php
/**
 * Copyright (C) 1997-2020 Reyesoft <info@reyesoft.com>.
 *
 * This file is part of CryptoQr. CryptoQr can not be copied and/or
 * distributed without the express permission of Reyesoft
 */

declare(strict_types=1);

namespace MercadoPagoQr;

use MercadoPagoQr\Clients\InstoreOrderV2;

class MercadoPagoOrder
{
    /**
     * @see https://www.mercadopago.com.ar/developers/en/reference/instore_orders_v2/_instore_qr_seller_collectors_user_id_stores_external_store_id_pos_external_pos_id_orders/put
     */
    public static function createOrFail(
        int $user_id,
        string $external_store_id,
        string $external_pos_id,
        ?string $external_reference,
        ?string $notification_url,
        ?array $payeer,
        ?array $items,
        ?string $preference_id,
    ): bool {
        return (new InstoreOrderV2())->create(
            $user_id,
            $external_store_id,
            $external_pos_id,
            array_filter([
                'external_reference' => $external_reference,
                'notification_url' => $notification_url,
                'payeer' => $payeer,
                'items' => $items,
                'preference_id' => $preference_id,
            ])
        );
    }
}
