<?php


namespace bloody_hell\vk_api_wrapper;


use bloody_hell\vk_api_wrapper\models\City;
use bloody_hell\vk_api_wrapper\models\Country;

class DatabaseApi
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
     * @return VkApi
     */
    public function getApi()
    {
        return $this->_api;
    }

    /**
     * @param $id
     *
     * @return City
     */
    public function getCity($id)
    {
        $result = $this->getApi()->api(
            'database.getCitiesById',
            [
                'user_ids'  => implode(',', $id),
            ]
        );
        if(isset($result['response'])){
            $city = new City($this->getApi());
            $city->setAttributes($result['response'][0]);
            return $city;
        }
        return null;
    }

    /**
     * @param $id
     *
     * @return Country
     */
    public function getCountry($id)
    {
        $result = $this->getApi()->api(
            'database.getCountriesById',
            [
                'country_ids'  => implode(',', $id),
            ]
        );
        if(isset($result['response'])){
            $country = new Country($this->getApi());
            $country->setAttributes($result['response'][0]);
            return $country;
        }
        return null;
    }
} 