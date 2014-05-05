<?php


namespace bloody_hell\vk_api_wrapper\jsObjects;


class LinkWallPostAttachment implements IWallPostAttachment
{
    /**
     * @var string
     */
    private $_link;

    public function __construct($link)
    {
        $this->setLink($link);
    }

    /**
     * @param string $link
     */
    public function setLink($link)
    {
        $this->_link = $link;
    }

    /**
     * @return string
     */
    public function getLink()
    {
        return $this->_link;
    }

    /**
     * (PHP 5 &gt;= 5.4.0)<br/>
     * Specify data which should be serialized to JSON
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     */
    public function jsonSerialize()
    {
        return $this->getLink();
    }


} 