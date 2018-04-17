<?php

namespace LaxCorp\RdpBundle\Helper;

use LaxCorp\RdpBundle\Model\Rdp;

/**
 * @inheritdoc
 */
class RdpHelper
{

    /**
     * @var string
     */
    private $fullAddress;

    /**
     * @inheritdoc
     */
    public function __construct($fullAddress)
    {
        $this->fullAddress = $fullAddress;
    }

    /**
     * @return Rdp
     */
    public function getDefault()
    {
        return new Rdp($this->fullAddress);
    }

}