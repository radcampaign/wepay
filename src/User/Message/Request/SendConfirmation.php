<?php

namespace Omnipay\WePay\User\Message\Request;

use Omnipay\WePay\Message\Request\AbstractRequest;
use Omnipay\WePay\Utilities\LazyLoadParametersTrait;

class SendConfirmation extends AbstractRequest
{
    use LazyLoadParametersTrait;

    /**
     * Defines which lazy loaded parameters we are going to accept
     * for the request
     * @var array
     */
    protected $accepted_parameters = [
        'access_token',
        'email_message',
        'email_subject',
        'email_button_text'
    ];

    /**
     * {@inheritdoc}
     */
    public function getData()
    {
        $accepted = $this->getAcceptedParameters();
        $ret = [];
        foreach ($accepted as $param) {
            if ($param !== 'access_token') {
                $ret[$param] = $this->getParameter($param);
            }
        }

        return $ret;
    }

    /**
     * {@inheritdoc}
     */
    public function getEndpoint()
    {
        return 'user/send_confirmation';
    }
}