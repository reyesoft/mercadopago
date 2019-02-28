<?php
/**
 * Copyright (C) 1997-2018 Reyesoft <info@reyesoft.com>.
 *
 * This file is part of CryptoQr. CryptoQr can not be copied and/or
 * distributed without the express permission of Reyesoft
 */

declare(strict_types=1);

namespace MercadoPagoQr;

use Endroid\QrCode\QrCode;

/**
 * @see https://www.mercadopago.com.ar/developers/en/guides/instore-payments/qr-payments/qr-pos/ "Create QR"
 */
class MercadoPagoPos
{
    use HasMpTrait;

    /** @var QrCode */
    protected $qr_code;

    /** @var MercadoPagoPosData */
    protected $data;

    public function __construct(\MP $mp, $pos_external_id = '')
    {
        $this->data = new MercadoPagoPosData();
        $this->qr_code = new QrCode();
        $this->mp = $mp;
        $this->data = new MercadoPagoPosData($pos_external_id);
    }

    public function getPosData(): MercadoPagoPosData
    {
        return $this->data;
    }

    /**
     * @throws \MercadoPagoException
     */
    public function createOrFail(): bool
    {
        $this->mp->post('/pos', $this->data->getDataArray());

        return true;
    }

    public function checkOrCreate(): bool
    {
        try {
            return $this->createOrFail();
        } catch (\MercadoPagoException $e) {
            // created
            if ($e->getMessage() === 'Point of sale with corresponding user and id exists') {
                return true;
            } else {
                throw new $e();
            }
        } catch (\Exception $e) {
            throw new $e();
        }
    }

    public function getQrCode($collector_id = null): QrCode
    {
        if ($collector_id === null) {
            $collector_id = $this->getCollectorIdFromMp();
        }

        $this->qr_code->setText(
            'https://mercadopago.com/s/qr/' . $collector_id . '/' . $this->data->getExternalId()
        );

        return $this->qr_code;
    }

    public function createAnOrder()
    {
        return new MercadoPagoOrder($this, $this->mp);
    }
}
