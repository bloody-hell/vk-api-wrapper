<?php

namespace bloody_hell\vk_api_wrapper\models;

use bloody_hell\vk_api_wrapper\components\Model;

class User extends Model
{
    public $id;

    public $first_name;

    public $last_name;

    public $nickname;

    public $screen_name;

    public $sex;

    public $bdate;

    public $city;

    public $country;

    public $timezone;

    public $photo;

    public $photo_medium;

    public $photo_big;

    public $has_mobile;

    public $rate;

    public $home_phone;

    public $mobile_phone;

    public $university;

    public $university_name;

    public $faculty;

    public $faculty_name;

    public $graduation;

    public $online;

    /**
     * @var bool|City
     */
    private $_city = false;

    /**
     * @var bool|Country
     */
    private $_country = false;

    /**
     * @return City
     */
    public function getCity()
    {
        if($this->_city === false){
            $this->_city = $this->fetchCity();
        }
        return $this->_city;
    }

    /**
     * @return City
     */
    public function fetchCity()
    {
        if($this->city){
            return $this->getApi()->db()->getCity($this->city);
        }
        return null;
    }

    /**
     * @return Country
     */
    public function getCountry()
    {
        if($this->_country === false){
            $this->_country = $this->fetchCity();
        }
        return $this->_country;
    }

    /**
     * @return Country
     */
    public function fetchCountry()
    {
        if($this->country){
            return $this->getApi()->db()->getCountry($this->country);
        }
        return null;
    }
}