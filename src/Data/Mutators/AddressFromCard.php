<?php

namespace Omnipay\WePay\Data\Mutators;

use Omnipay\WePay\Helper;

class AddressFromCard extends AbstractMutator
{
    /**
     * {@inheritdoc}
     */
    public function getStructureTag()
    {
        return 'Address';
    }

    /**
     * {@inheritdoc}
     */
    public function mutate()
    {
        $card = $this->getCard();
        if (is_null($card)) {
            throw new \Exception(
                "Must set card before running the conform process"
            );
        }

        $structure = $this->getStructure();
        return $structure->fill(
            Helper::arrayStripNulls([
                'address1' => $card->getBillingAddress1(),
                'address2' => $card->getBillingAddress2(),
                'city'     => $card->getBillingCity(),
                'country'  => $card->getBillingCountry(),
                'postal_code' => $card->getBillingPostcode()
            ])
        );
    }
}
