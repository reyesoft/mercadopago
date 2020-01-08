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
use MercadoPago\Pos as Pos;

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

    /** @var Pos */
    protected $pos;

    public function __construct(string $pos_external_id = '')
    {
        $this->qr_code = new QrCode();
        $this->data = new MercadoPagoPosData($pos_external_id);
        $this->pos = new Pos();
    }

    public function getPosData(): MercadoPagoPosData
    {
        return $this->data;
    }

    public function createOrFail(): bool
    {
        $pos = new POS();
        $pos->name = $this->data->getName();
        $pos->external_id = $this->data->getExternalId();
        $pos->store_id = $this->data->getStoreId();
        $pos->fixed_amount = $this->data->getFixedAmount();
        $pos->category = $this->data->getCategory();
        $pos->save();

        if ($pos->Error() === null) {
            return true;
        }

        throw new MercadoPagoQrException(
                        $pos->Error()->message
                        . ' (' . $pos->Error()->error . ')'
                        . ' (' . $pos->Error()->status . ')'
                    );
    }

    public function checkOrCreate(): bool
    {
        try {
            return $this->createOrFail();
            // @todo
            // @codeCoverageIgnoreStart
        } catch (MercadoPagoQrException $e) {
            // created
            if (strpos($e->getMessage(), 'point_of_sale_exists') > 0) {
                return true;
            } else {
                throw $e;
            }
        } catch (\Exception $e) {
            throw $e;
        }
        // @codeCoverageIgnoreEnd
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
        return new MercadoPagoOrder($this);
    }
}
