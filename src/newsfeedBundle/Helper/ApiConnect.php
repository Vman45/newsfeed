<?php

namespace newsfeedBundle\Helper;
use GuzzleHttp\Client;

class ApiConnect
{
    public $url;
    public $type;

    public static function feed($url,$type)
    {
        $source = new Client();

        $feed = $source->get($url);

        if($feed->getStatusCode() == '200') {

            return $feed->getBody()->getContents();


        } else {

            return '404';

        }

    }

}