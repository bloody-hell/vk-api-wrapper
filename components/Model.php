<?php


namespace bloody_hell\vk_api_wrapper\components;


class Model
{
    public function setAttributes(array $attributes)
    {
        foreach($attributes as $name => $value){
            if(property_exists($this, $name)){
                $this->$name = $value;
            }
        }
    }
} 