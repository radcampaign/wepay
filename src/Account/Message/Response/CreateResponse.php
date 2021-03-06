<?php

namespace Omnipay\WePay\Account\Message\Response;

use Omnipay\WePay\Message\Response\AbstractResponse;

class CreateResponse extends AbstractResponse
{
    public function isSuccessful()
    {
        return parent::isSuccessful() && !empty($this->getData());
    }
}
