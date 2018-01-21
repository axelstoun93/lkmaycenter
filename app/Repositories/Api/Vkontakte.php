<?php
namespace App\Repositories\Api;

class Vkontakte
{
    const VERSION = '5.6';

    private $appId;

    private $secret;

    private $scope = array();

    private $redirect_uri;

    private $responceType = 'code';

    private $accessToken;

    protected $publicID;

    public $post_id;

    public function __construct()
    {
        $this->accessToken = config('settings.vkontakte.access_token');
        $this->publicID = config('settings.vkontakte.publicID');

    }

    public function api($method, array $query = array())
    {
        /* Generate query string from array */
        $parameters = array();
        foreach ($query as $param => $value) {
            $q = $param . '=';
            if (is_array($value)) {
                $q .= urlencode(implode(',', $value));
            } else {
                $q .= urlencode($value);
            }

            $parameters[] = $q;
        }

        $q = implode('&', $parameters);
        if (count($query) > 0) {
            $q .= '&'; // Add "&" sign for access_token if query exists
        }
        $url = 'https://api.vk.com/method/' . $method . '?' . 'access_token=' . $this->accessToken;
        $result = json_decode($this->curl($url, $query));
        if (!empty($result->response) && is_object($result)) {

            return $result->response;
        }

        return false;
    }

    /**
     * Make the curl request to specified url
     * @param string $url The url for curl() function
     * @return mixed The result of curl_exec() function
     * @throws \Exception
     */
    protected function curl($url, $data)
    {
        // create curl resource
        $ch = curl_init($url);

        // return the transfer as a string
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        // disable SSL verifying
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

        // $output contains the output string
        $result = curl_exec($ch);

        if (empty($result) and false and is_object($result)) {
            $errno = curl_errno($ch);
            $error = curl_error($ch);
            curl_close($ch);
            return false;
        }

        // close curl resource to free up system resources
        curl_close($ch);

        if (isset($errno) && isset($error)) {
            throw new \Exception($error, $errno);
        }

        return $result;
    }

    function saveImages($fullServerPathToImage)
    {
        $response = $this->api('photos.getWallUploadServer', [
            'group_id' => $this->publicID,
        ]);
        /*
         * public 'upload_url' => string 'http://cs618028.vk.com/upload.php?act=do_add&mid=76989657&aid=-14&gid=70941690&hash=0c9cdfa73779ea6c904c4b5326368700&rhash=ba9b60e61e258bf8fd61536e6683e3af&swfupload=1&api=1&wallphoto=1' (length=185)
              public 'aid' => int -14
              public 'mid' => int 76989657
         *
         *  */


        $uploadURL = $response->upload_url;
        $post_params = [
            'file1' => new \CurlFile($fullServerPathToImage)
        ];
        $ch = curl_init($uploadURL);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_params);
        $response = curl_exec($ch);
        curl_close($ch);
        $response = json_decode($response);

        /*
         *  public 'server' => int 618028
              public 'photo' => string '[{"photo":"96df595e0b:z","sizes":[["s","618028657","c5b1","RfjznPPyhxs",75,54],["m","618028657","c5b2","dQRTijvf4tE",130,93],["x","618028657","c5b3","-zUzUi-uOkU",604,432],["y","618028657","c5b4","FAAY0vnMSWc",807,577],["z","618028657","c5b5","OBZqwGjlO9s",900,644],["o","618028657","c5b6","Ku7Q6IqN5uc",130,93],["p","618028657","c5b7","0eFhSRrjxvU",200,143],["q","618028657","c5b8","F8E6QJg51o4",320,229],["r","618028657","c5b9","-a3oiI8SVOg",510,365]],"kid":"6bba9104fa05dd017597abce3ebeb215"}]' (length=496)
              public 'hash' => string 'd02d83e70eca1c0d756d1a5d51c2fbfb' (length=32)
         */
        $response = $this->api('photos.saveWallPhoto', [
            'group_id' => $this->publicID,
            'photo' => $response->photo,
            'server' => $response->server,
            'hash' => $response->hash,
        ]);

        return $response;
    }

    function postToPublic($text, $post_id = false,$link = null, $fullServerPathToImage = false, $tags = [])
    {

        if ($fullServerPathToImage) {
            $response = $this->saveImages($fullServerPathToImage);
        }
        if ($post_id) {
            $res = $this->postToDelete($post_id);
            if (!$res) {
                return false;
            }
        }

        if (!empty($tags)) {
            if ($tags) {
                $text .= "\n\n";
            }
            $array = explode(',', $tags);
            foreach ($array as $tag) {

                $text .= ' #' . str_replace(' ', '_', $tag);
            }
        }
        $text = html_entity_decode($text);

        $response = $this->api('wall.post',
            [
                'owner_id' => -$this->publicID,
                'from_group' => 1,
                'message' => "$text",
                'attachments' => (!empty($link)) ? $link : '' // uploaded image is passed as attachment
            ]);
        if (is_object($response) and !empty($response->post_id)) {
            $this->post_id = $response->post_id;
            return true;
        } else {
            return false;
        }
    }

    function postToDelete($id)
    {
        $response = $this->api('wall.delete',
            [
                'owner_id' => -$this->publicID,
                'post_id' => $id
            ]);
        if (!empty($response)) {
            return $response;
        }
        return false;
    }
}