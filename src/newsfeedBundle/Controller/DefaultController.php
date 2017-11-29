<?php

namespace newsfeedBundle\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\DomCrawler\Crawler;
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

        $sql = "INSERT into feed(date,title,url) VALUES (?,?,?)";

        $em = $this->getDoctrine()->getManager();

        $connection = $em->getConnection();

            $statement = $connection->prepare($sql);

            $currentTime = \DateTime::createFromFormat('U',$dataContent['time']);

            $dateIs = $currentTime->format('Y-m-d H:m:i');

            $statement->bindParam(1, $dateIs);
            $statement->bindParam(2,$dataContent['title']);
            //$statement->bindParam(3,'summary");
            $statement->bindParam(3,$dataContent["url"]);

            $statement->execute();

        }

        // bbc
        $bbc = $this->feedAction('http://feeds.bbci.co.uk/news/technology/rss.xml','xml');

        $bbc = new \SimpleXMLElement($bbc,true);

        $bbcContents = json_decode(json_encode($bbc),true);

        foreach ($bbcContents['channel']['item'] as $bbcContent) {

         // echo $bbcContent['link'];
        //  echo $bbcContent['pubDate'];
         // get title from content

        }

        // slashddot
        $slashDot = $this->feedAction('https://slashdot.org','dom');

        $slashNews = $this->domAction($slashDot);

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

    public function domAction($content) {

     $crawler = new Crawler($content);

     $crawler->filterXPath('//div[@id="firehose"]//h2')->each(function (Crawler $node) use (&$results) {

     var_dump(trim($node->text()));

     });


    }

}
