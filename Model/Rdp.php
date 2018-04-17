<?php

namespace LaxCorp\RdpBundle\Model;

/**
 * @inheritdoc
 */
class Rdp
{

    const CONTENT_TYPE = 'application/rdp';
    const DEFAULT_FILE_NAME = 'Default';
    const FILE_EXT = '.rdp';
    const ROW_SEPARATOR = "\r\n";

    /**
     * @var string
     */
    private $userName;

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
     * @return string
     */
    public function generateData(): string
    {
        $rows = [
            "username:s:{$this->getUserName()}",
            "full address:s:{$this->getFullAddress()}"
        ];

        return implode($this::ROW_SEPARATOR, $rows);
    }

    /**
     * @return string
     */
    public function getUserName(): string
    {
        return $this->userName;
    }

    /**
     * @param string $userName
     *
     * @return Rdp
     */
    public function setUserName(string $userName): Rdp
    {
        $this->userName = $userName;

        return $this;
    }

    /**
     * @return string
     */
    public function getFullAddress(): string
    {
        return $this->fullAddress;
    }

    /**
     * @param string $fullAddress
     *
     * @return Rdp
     */
    public function setFullAddress(string $fullAddress): Rdp
    {
        $this->fullAddress = $fullAddress;

        return $this;
    }

}