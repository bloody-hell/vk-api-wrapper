<?php


namespace bloody_hell\vk_api_wrapper;


use bloody_hell\vk_api_wrapper\models\User;

class UsersApi
{
    /**
     * Именительный падеж
     */
    const CASE_NOMINATIVE = 'nom';

    /**
     * Родительный падеж
     */
    const CASE_GENITIVE = 'gen';

    /**
     * Дательный падеж
     */
    const CASE_DATIVE = 'dat';

    /**
     * Винительный
     */
    const CASE_ACCUSATIVE = 'acc';

    /**
     * Творительный
     */
    const CASE_INSTRUMENTAL = 'ins';

    /**
     * Предложный
     */
    const CASE_PREPOSITIONAL = 'abl';

    const FIELD_USER_UID = 'uid';

    const FIELD_USER_FIRST_NAME = 'first_name';

    const FIELD_USER_LAST_NAME = 'last_name';

    const FIELD_USER_NICKNAME = 'nickname';

    const FIELD_USER_SCREEN_NAME = 'screen_name';

    const FIELD_USER_SEX = 'sex';

    const FIELD_USER_BDATE = 'bdate';

    const FIELD_USER_CITY = 'city';

    const FIELD_USER_COUNTRY = 'country';

    const FIELD_USER_TIMEZONE = 'timezone';

    const FIELD_USER_PHOTO = 'photo';

    const FIELD_USER_PHOTO_MEDIUM = 'photo_medium';

    const FIELD_USER_PHOTO_BIG = 'photo_big';

    const FIELD_USER_HAS_MOBILE = 'has_mobile';

    const FIELD_USER_RATE = 'rate';

    const FIELD_USER_CONTACTS = 'contacts';

    const FIELD_USER_EDUCATION = 'education';

    const FIELD_USER_ONLINE = 'online';

    const FIELD_USER_COUNTERS = 'counters';

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
     * @param array  $ids
     * @param string $name_case
     * @param array  $fields
     *
     * @return User[]
     */
    public function getUsers(array $ids, $name_case = self::CASE_NOMINATIVE, array $fields = array())
    {
        $result = $this->getApi()->api(
            'users.get',
            [
                'user_ids'  => implode(',', $ids),
                'fields'    => implode(',', $fields),
                'name_case' => $name_case,
            ]
        );
        if(isset($result['response'])){
            return array_map(
                function($item){
                    $user = new User($this->getApi());
                    $user->setAttributes($item);
                    return $user;
                },
                $result['response']
            );
        }
        return array();
    }

    /**
     * @param        $uid
     * @param string $name_case
     * @param array  $fields
     *
     * @return User|null
     */
    public function getUser($uid, $name_case = self::CASE_NOMINATIVE, array $fields = array())
    {
        if($users = $this->getUsers([$uid], $name_case, $fields)){
            return $users[0];
        }
        return null;
    }
} 