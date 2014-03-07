<?php


namespace bloody_hell\vk_api_wrapper\components;


use bloody_hell\vk_api_wrapper\VkApi;

class Model
{
    /**
     * @var VkApi
     */
    private $_api;

    public function __construct(VkApi $api)
    {
        $this->_api = $api;
    }

    /**
     * @return \bloody_hell\vk_api_wrapper\VkApi
     */
    public function getApi()
    {
        return $this->_api;
    }



    public function setAttributes(array $attributes)
    {
        foreach($attributes as $name => $value){
            if(property_exists($this, $name)){
                $this->$name = $value;
            }
        }
    }
} 