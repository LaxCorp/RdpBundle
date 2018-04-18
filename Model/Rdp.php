<?php

namespace LaxCorp\RdpBundle\Model;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

/**
 * @inheritdoc
 */
class Rdp
{

    const CONTENT_TYPE = 'application/rdp';
    const DEFAULT_FILE_NAME = 'Default';
    const RDP_EXT = '.rdp';
    const ZIP_EXT = '.rdp.zip';
    const ROW_SEPARATOR = "\r\n";

    /**
     * @var RDP[]
     */
    private $collection;

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
        $this->collection  = [];
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
     * @inheritdoc
     */
    public function add(RDP $rdp)
    {
        $this->collection[] = $rdp;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getCollection()
    {
        return $this->collection;
    }

    /**
     * @inheritdoc
     */
    public function responceFile(?string $name = null)
    {
        $name     = (!$name) ? $this::DEFAULT_FILE_NAME : $name;
        $fileName = $name . $this::RDP_EXT;
        $data     = $this->generateData();

        $response = new Response($data);
        $response->headers->set('Content-Type', $this::CONTENT_TYPE);
        $response->headers->set('Cache-Control', 'no-cache, private');
        $response->headers->set('Content-Disposition',
            ResponseHeaderBag::DISPOSITION_ATTACHMENT . '; filename="' . $fileName . '"');

        return $response;

    }

    /**
     * @inheritdoc
     */
    public function responceZip(?string $name = null)
    {
        $name       = (!$name) ? $this::DEFAULT_FILE_NAME : $name;
        $fileName   = $name . $this::ZIP_EXT;
        $collection = $this->getCollection();

        $tmpfile     = tmpfile();
        $fmeta       = stream_get_meta_data($tmpfile);
        $zipFilePath = $fmeta['uri'];

        $zip = new \ZipArchive();
        $zip->open($zipFilePath, \ZipArchive::CREATE);

        foreach ($collection as $rdp) {
            $localname = $rdp->getUserName() . $this::RDP_EXT;
            $zip->addFromString($localname, $rdp->generateData());
        }

        $zip->close();

        $response = new Response(file_get_contents($zipFilePath));
        $response->headers->set('Content-Type', 'application/octet-stream');
        $response->headers->set('Cache-Control', 'no-cache, private');
        $response->headers->set('Content-Disposition',
            ResponseHeaderBag::DISPOSITION_ATTACHMENT . '; filename="' . $fileName . '"');

        return $response;
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