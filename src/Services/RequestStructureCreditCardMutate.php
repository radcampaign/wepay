<?php
/**
 * This service takes a \Omnipay\Common\CreditCard object
 * and conforms it to a known request structure
 * using conformers found in src/Services/CCConformers.
 */
namespace Omnipay\WePay\Services;

use Omnipay\WePay\Helper;
use Omnipay\Common\CreditCard;
use Omnipay\WePay\Data\Mutators\MutatorInterface;

class RequestStructureCreditCardMutate implements ServiceInterface
{
    /**
     * The namespace from where the conformers exist
     *
     * @var string
     */
    protected static $namespace = '\\Omnipay\\WePay\\Data\\Mutators\\';

    /**
     * Storage for the Request Structure Tag
     * @var string
     */
    protected $mutator_tag = '';

    /**
     * Storage for the CrediCard
     * @var CreditCard
     */
    protected $card = null;

    /**
     * Creates our service
     * @return static
     */
    public static function create()
    {
        return new static();
    }

    /**
     * [create description]
     * @param  string     $rs_tag [description]
     * @param  CreditCard $card   [description]
     * @return [type]             [description]
     */
    public function invoke()
    {
        $mutator_tag = Helper::paramMethodized($this->getMutatorTag());
        if (empty($mutator_tag)) {
            throw new \Exception("Must set the Request Structure tag using setRSTag");
        }

        $card = $this->getCreditCard();
        if (empty($card)) {
            throw new \Exception("Must set the CreditCard object using setCard");
        }

        $class = self::$namespace . $mutator_tag;
        if (!class_exists($class)) {
            throw new \Exception("Mutator for $rs_tag does not exist");
        }

        if (!self::classImplementsInterface($class)) {
            throw new \Exception("Found $class but fails to implement our MutatorInterface");
        }

        $obj = new $class;
        $obj->setCard($card);
        return $obj->mutate();
    }

    public function getMutatorTag()
    {
        return $this->mutator_tag;
    }

    public function setMutatorTag(string $mutator_tag = '')
    {
        $this->mutator_tag = $mutator_tag;
        return $this;
    }

    public function getCreditCard()
    {
        return $this->card;
    }

    public function setCreditCard(CreditCard $card)
    {
        $this->card = $card;
        return $this;
    }

    public static function classImplementsInterface($class = '')
    {
        return in_array(MutatorInterface::class, class_implements($class));
    }
}
