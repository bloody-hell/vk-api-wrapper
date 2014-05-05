<?php


namespace bloody_hell\vk_api_wrapper\jsObjects;


class WallPostAttachment implements IWallPostAttachment
{
    const TYPE_PHOTO = 'photo';

    const TYPE_VIDEO = 'video';

    const TYPE_AUDIO = 'audio';

    const TYPE_DOCUMENT = 'doc';

    const TYPE_WIKI_PAGE = 'page';

    const TYPE_NOTE = 'note';

    const TYPE_POLL = 'poll';

    const TYPE_ALBUM = 'album';

    /**
     * @var string
     */
    private $_owner_id;

    /**
     * @var string
     */
    private $_media_id;

    /**
     * @var string
     */
    private $_type;

    public function __construct($type, $owner_id, $media_id)
    {
        $this->setMediaId($media_id);
        $this->setOwnerId($owner_id);
        $this->setType($type);
    }

    /**
     * @param string $media_id
     */
    public function setMediaId($media_id)
    {
        $this->_media_id = $media_id;
    }

    /**
     * @return string
     */
    public function getMediaId()
    {
        return $this->_media_id;
    }

    /**
     * @param string $owner_id
     */
    public function setOwnerId($owner_id)
    {
        $this->_owner_id = $owner_id;
    }

    /**
     * @return string
     */
    public function getOwnerId()
    {
        return $this->_owner_id;
    }

    /**
     * @param string $type
     */
    public function setType($type)
    {
        $this->_type = $type;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->_type;
    }

    /**
     * (PHP 5 &gt;= 5.4.0)<br/>
     * Specify data which should be serialized to JSON
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return string data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     */
    public function jsonSerialize()
    {
        return $this->getType() . $this->getOwnerId() . '_' . $this->getMediaId();
    }
} 