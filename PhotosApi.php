<?php


namespace bloody_hell\vk_api_wrapper;


use bloody_hell\vk_api_wrapper\models\Photo;
use bloody_hell\vk_api_wrapper\models\User;
use yii\helpers\VarDumper;

class PhotosApi
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
     * @param integer  $album_id
     * @param string[] $imageUris
     * @param integer $group_id
     *
     * @return Photo[]
     *
     * @throws UploadServerNotAvailable
     * @throws UploadError
     */
    public function uploadPhotos($album_id, array $imageUris, $group_id = null)
    {
        $params = [
            'album_id'  => $album_id,
        ];
        if($group_id){
            $params['group_id'] = $group_id;
        }
        $response = $this->getApi()->api('photos.getUploadServer', $params);

        if(!isset($response['response'])){
            throw new UploadServerNotAvailable('Cannot get upload url: ' . (isset($response['error']['error_msg']) ? $response['error']['error_msg'] : 'No error message'));
        }

        $request = [];

        $boundary = 'Boundary-Asrf456BGe4h';
        $i = 0;
        foreach($imageUris as $imageUri){

            $content = file_get_contents($imageUri);

            $item = '--'.$boundary . PHP_EOL;
            $item .= 'Content-Disposition: form-data; name="file'.(++$i).'"; filename="'.rand(0,65536).'.'.pathinfo($imageUri)['extension'].'"'. PHP_EOL;
            $item .= 'Content-Type: image/jpeg'. PHP_EOL;
            $item .= 'Content-Length: ' . strlen($content). PHP_EOL;
            $item .= PHP_EOL;
            $item .= $content . PHP_EOL;

            $request[] = $item;
        }

        $request[] = '--' . $boundary . '--' . PHP_EOL;

        $context = stream_context_create(['http' => [
                'method'    => 'POST',
                'header'    => 'Content-Type: multipart/form-data; boundary='.$boundary,
                'content'   => implode('', $request),
            ]]);

        $post_data = json_decode(file_get_contents($response['response']['upload_url'], null, $context), true);

        if(isset($post_data['aid'])){
            $post_data['album_id'] = $post_data['aid'];
        }
        if(isset($post_data['gid'])){
            $post_data['group_id'] = $post_data['gid'];
        }

        $response = $this->getApi()->api('photos.save', $post_data);

        if(!isset($response['response'])){
            throw new UploadError('Cannot upload images: ' . (isset($response['error']['error_msg']) ? $response['error']['error_msg'] : 'No error message'));
        }
        return array_map(function(array $item){
                $photo = new Photo($this->getApi());
                $photo->setAttributes($item);
                return $photo;
            }, $response['response']);
    }
}
class UploadServerNotAvailable extends \Exception {}
class UploadError extends \Exception {}