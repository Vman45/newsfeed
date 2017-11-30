<?php

namespace newsfeedBundle\Controller;

use newsfeedBundle\Helper\ApiConnect;
use newsfeedBundle\Helper\DomCrawler;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;


/* @author Gavin Moulton
 *
 *
 * TODO add summary details
*/

class DefaultController extends Controller
{

    /**
     * @Route("/", name="homepage")
     */
    public function indexAction() {

        // hacker news
        if(ApiConnect::feed('https://hacker-news.firebaseio.com/v0/topstories.json','json') === '404') {
            echo 'hacker news feed failed to connect';
        } else {
            $dataHackerNews = ApiConnect::feed('https://hacker-news.firebaseio.com/v0/topstories.json','json');
        }
        $data = json_decode($dataHackerNews);
        // get 10 of 100 records
        $data = array_slice($data,0,10);

        foreach($data as $item) {

            if (ApiConnect::feed('https://hacker-news.firebaseio.com/v0/item/' . $item . '.json','json') === '404') {
                echo 'hacker news feed item failed to connect';
            } else {
                $content = ApiConnect::feed('https://hacker-news.firebaseio.com/v0/item/' . $item . '.json', 'json');

                $dataContent = json_decode($content, true);

                try {

                    $em = $this->getDoctrine()->getManager();

                    $connection = $em->getConnection();

                    $sql = "INSERT into feed(date,title,url) VALUES (?,?,?)";

                    $statement = $connection->prepare($sql);

                    $currentTime = \DateTime::createFromFormat('U', $dataContent['time']);

                    $dateIs = $currentTime->format('Y-m-d H:m:i');

                    $statement->bindParam(1, $dateIs);
                    $statement->bindParam(2, $dataContent['title']);
                    //$statement->bindParam(3,'summary");
                    $statement->bindParam(3, $dataContent["url"]);

                    $statement->execute();

                } catch (\Exception $e) {
                    error_log($e->getMessage());
                }
            }

        }
        // bbc
        if(ApiConnect::feed('http://feeds.bbci.co.uk/news/technology/rss.xml','xml') === '404') {
            echo 'bbc feed no connection';
        } else {

            $bbc = ApiConnect::feed('http://feeds.bbci.co.uk/news/technology/rss.xml', 'xml');

            $bbc = new \SimpleXMLElement($bbc, true);
            // turn into json then array for easy handling
            $bbcContents = json_decode(json_encode($bbc), true);

            foreach ($bbcContents['channel']['item'] as $bbcContent) {

                try {

                    $title = "mocktitle";
                    $em = $this->getDoctrine()->getManager();

                    $connection = $em->getConnection();

                    $sql = "INSERT into feed(date,title,url) VALUES (?,?,?)";

                    $statement = $connection->prepare($sql);

                    $currentTime = new \DateTime($bbcContent['pubDate']);

                    $dateIs = $currentTime->format('Y-m-d H:m:i');

                    $statement->bindParam(1, $dateIs);
                    $statement->bindParam(2, $title);
                    //$statement->bindParam(3,'bbc');
                    $statement->bindParam(3, $bbcContent['link']);

                    $statement->execute();

                } catch (\Exception $e) {
                    error_log($e->getMessage());
                }

            }

        }

        // slashddot
        if(ApiConnect::feed('https://slashdot.org', 'dom') === '404') {
            echo 'no slashdot feed connection';
        } else {

            $slashNews = ApiConnect::feed('https://slashdot.org', 'dom');
            $slashResults = DomCrawler::domAction($slashNews);


            try {

                foreach($slashResults as $result) {

                    $date = new \DateTime();

                    // issues getting any more values in dom
                    $mockdateis = $date->format('Y-m-d H:m:i');
                    $mocktitleis = 'slashdot';
                    $mockurlis = 'url';

                    $em = $this->getDoctrine()->getManager();

                    $connection = $em->getConnection();

                    $sql = "INSERT into feed(date,title,url) VALUES (?,?,?)";

                    $statement = $connection->prepare($sql);

                    $statement->bindParam(1, $mockdateis);
                    $statement->bindParam(2, $result);
                    //$statement->bindParam(3,'summary");
                    $statement->bindParam(3,$mockurlis);

                    $statement->execute();


                }

            } catch (\Exception $e) {
                error_log($e->getMessage());
            }

        }

        return new Response('Data processing complete');

    }

}
