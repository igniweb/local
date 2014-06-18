<?php namespace Local\Services\SocialWall\Apis;

use ErrorException;

class InstagramApi {
    
    private $apiUrl;

    public function __construct()
    {
        $this->apiUrl  = 'https://api.instagram.com/v1/';
    }

    public function query($query, $params = [])
    {
        $url = $this->buildUrl($query, $params);
        try
        {
            $response = file_get_contents($url);
        }
        catch (ErrorException $exception)
        {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, 0);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $response = curl_exec($ch);
            curl_close($ch);
        }

        return $this->parseResponse($response);
    }

    private function buildUrl($query, $params)
    {
        $url = $this->apiUrl . $query . '?client_id=' . $_ENV['INSTAGRAM_ID'];

        if ( ! empty($params))
        {
            foreach ($params as $key => $val)
            {
                $url .= '&' . $key . '=' . urlencode($val);
            }
        }

        return $url;
    }

    private function parseResponse($response)
    {
        if ( ! empty($response))
        {
            $response = json_decode($response);
            if (isset($response->meta->code) and ($response->meta->code === 200))
            {
                return $response->data;
            }
        }

        return false;
    }

}
