<?php

namespace newsfeedBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use GuzzleHttp\Client;


/* @author Gavin Moulton
 *
 * date
title
summary
url
*/

class DefaultController extends Controller
{
    private $listing;

    /**
     * @Route("/", name="homepage")
     */

    public function indexAction() {

        // hacker news
        $dataHackerNews = $this->feedAction('https://hacker-news.firebaseio.com/v0/topstories.json','json');

        $data = json_decode($dataHackerNews);

        $data = array_slice($data,0,10);

        foreach($data as $item) {

        $content = $this->feedAction('https://hacker-news.firebaseio.com/v0/item/' . $item .'.json','json');

        $dataContent = json_decode($content,true);

       // var_dump($dataContent);
       // echo $dataContent['title'];
        //    echo $dataContent['url'];
         //   echo $dataContent['time'];

        }

        // bbc
        $bbc = $this->feedAction('http://feeds.bbci.co.uk/news/technology/rss.xml','xml');

        $bbc = new \SimpleXMLElement($bbc,true);

        $bbcContents = json_decode(json_encode($bbc),true);


        foreach ($bbcContents['channel']['item'] as $bbcContent) {

          echo $bbcContent['link'];
          echo   $bbcContent['pubDate'];
         // get title from content

            echo '<br><br><br>';
        }

        return 'yes';
    }

    public function feedAction($url,$type)
    {
        $source = new Client();

        $feed = $source->get($url);

        if($feed->getStatusCode() == '200') {

            if($type == 'xml') {
                $this->listing = $feed->getBody()->getContents();
            } else {
                $this->listing = $feed->getBody()->getContents();
            }
            return $this->listing;
           // return $this->render('newsfeedBundle:Default:index.html.twig', array('listing' => $this->listing));

        } else {

            return new Response('Sorry, Listings unavailable');

        }

    }





}
