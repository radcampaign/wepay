<?php
/**
 * Request response
 */
namespace Omnipay\WePay\Message\Response;

use Omnipay\WePay\Message\Response\AbstractResponse;

class PurchaseResponse extends AbstractResponse
{
    /**
     * Defines success for the request
     * @return {Boolean}
     */
    public function isSuccessful()
    {
        // input your own success rules here
        return parent::isSuccessful() && !empty($this->getData('checkout_id'));
    }
}
