<?php

namespace newsfeedBundle\Helper;
use Symfony\Component\DomCrawler\Crawler;

/*
 * TODO can get values separate but did not have time to figure out how to combine into a useable array see commented out ones
 */


class DomCrawler
{
    public static function domAction($content) {


        $crawler = new Crawler($content);

        $crawler->filterXPath('//div[@id="firehose"]//h2')->each(function (Crawler $node) use (&$results) {

            $results[] = trim($node->text());

        });

        return $results;

        /*
        $crawler = new Crawler($content);

        $crawler->filterXPath('//div[@id="firehoselist"]//h2')->each(function (Crawler $node) use (&$results) {

        $results[] = $node->text();

        });

        $crawler->filterXPath('//div[@id="firehoselist"]//i')->each(function (Crawler $node) use (&$resultsSummary) {

        $resultsSummary[] = $node->text();

        });

        $crawler->filterXPath('//div[@id="firehoselist"]//time')->each(function (Crawler $node) use (&$resultsTime) {

        $resultsTime[] = $node->text();

        });
*/

    }




}