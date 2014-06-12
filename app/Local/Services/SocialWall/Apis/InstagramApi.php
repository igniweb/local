<?php namespace Local\Services\SocialWall\Apis;

class InstagramApi {
    
    private $apiUrl;

    public function __construct()
    {
        $this->apiUrl  = 'https://api.instagram.com/v1/';
    }

    public function query($query, $params = [])
    {
        $url = $this->buildUrl($query, $params);

        $response = @file_get_contents($url);

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
