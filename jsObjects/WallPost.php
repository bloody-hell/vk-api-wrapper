<?php


namespace bloody_hell\vk_api_wrapper\jsObjects;


class WallPost implements \JsonSerializable
{
    public $message;

    /**
     * @var IWallPostAttachment[]
     */
    private $_attachments = [];

    /**
     * @param string                $message
     * @param IWallPostAttachment[] $attachments
     */
    public function __construct($message, array $attachments)
    {
        $this->message      = $message;
        foreach($attachments as $attachment){
            $this->addAttachment($attachment);
        }
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
        return [
            'message'       => $this->message,
            'attachments'   => $this->getAttachments(),
        ];
    }

    /**
     * @return \bloody_hell\vk_api_wrapper\jsObjects\IWallPostAttachment[]
     */
    public function getAttachments()
    {
        return $this->_attachments;
    }

    public function addAttachment(IWallPostAttachment $attachment)
    {
        $this->_attachments[] = $attachment;
    }


}