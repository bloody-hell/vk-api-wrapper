<?php


namespace bloody_hell\vk_api_wrapper;


use bloody_hell\vk_api_wrapper\models\User;

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
     *
     * @return array
     *
     * @throws UploadServerNotAvailable
     */
    public function uploadPhotos($album_id, $imageUris)
    {
        $response = $this->getApi()->api('photos.getUploadServer', [
                'album_id'  => $album_id,
            ]);

        if(!isset($response['response'])){
            throw new UploadServerNotAvailable('Cannot get upload url');
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

        $post_data = file_get_contents($response['response']['upload_url'], null, $context);

        $items = $this->getApi()->api('photos.save', json_decode($post_data, true));

        return $items['response'];
    }
}
class UploadServerNotAvailable extends \Exception {}